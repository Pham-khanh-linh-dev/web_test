console.log("sell.js loaded");

const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));

function showMessage(title, message, isError = false) {
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    
    modalTitle.textContent = title;
    modalTitle.className = isError ? 'modal-title text-danger' : 'modal-title text-primary';
    modalMessage.textContent = message;
    modalMessage.className = isError ? 'text-danger' : '';
    
    messageModal.show();
}

const cart = [];

// Search products
function findProduct() {
    const keyword = document.getElementById("product-search").value.trim();
    
    if (!keyword) {
        showMessage("Lỗi", "Vui lòng nhập từ khóa tìm kiếm!", true);
        return;
    }

    $.ajax({
        url: "findProduct.php",
        type: "POST",
        data: { search: keyword },
        dataType: "json",
        success: function (response) {
            const resultList = document.getElementById("search-result");
            resultList.innerHTML = "";
            
            if (response.success) {
                response.products.forEach(product => {
                    const formattedPrice = parseFloat(product.selling_price).toLocaleString("vi-VN");
                    const row = `
                        <tr>
                            <td>${product.name}</td>
                            <td class="text-end">${formattedPrice} VND</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success" onclick='addToCart(${JSON.stringify(product)})'>
                                    <i class="fas fa-plus"></i> Thêm
                                </button>
                            </td>
                        </tr>
                    `;
                    resultList.innerHTML += row;
                });
            } else {
                showMessage("Lỗi", response.message, true);
                resultList.innerHTML = `<tr><td colspan='3' class='text-center text-danger'>${response.message}</td></tr>`;
            }
        },
        error: function(xhr, status, error) {
            showMessage("Lỗi", "Lỗi kết nối server: " + error, true);
        }
    });
}

// Add product to cart
function addToCart(product) {
    const existing = cart.find(item => item.id == product.id);
    
    if (existing) {
        existing.quantity += 1;
        showMessage("Thành công", `Đã cập nhật số lượng ${product.name} trong giỏ hàng`);
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: parseFloat(product.selling_price),
            quantity: 1
        });
        showMessage("Thành công", `Đã thêm ${product.name} vào giỏ hàng`);
    }
    
    // Lưu giỏ hàng vào localStorage
    localStorage.setItem("cart", JSON.stringify(cart));

    renderCart();
}


// Render cart items
function renderCart() {
    const cartTable = document.getElementById("product-list");
    cartTable.innerHTML = "";

    if (cart.length === 0) {
        cartTable.innerHTML = `
            <tr>
                <td colspan='5' class='text-center text-muted'>
                    <i class="fas fa-shopping-cart me-2"></i>
                    Chưa có sản phẩm nào trong giỏ hàng
                </td>
            </tr>
        `;
        updateGrandTotal();
        return;
    }

    cart.forEach(item => {
        const total = item.price * item.quantity;
        const row = `
            <tr data-product-id="${item.id}">
                <td>${item.name}</td>
                <td class="text-center">
                    <input type="number" class="form-control form-control-sm" 
                           value="${item.quantity}" min="1" 
                           onchange="changeQuantity(${item.id}, this.value)">
                </td>
                <td class="text-end">${item.price.toLocaleString("vi-VN")} VND</td>
                <td class="text-end">${total.toLocaleString("vi-VN")} VND</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        cartTable.innerHTML += row;
    });

    // Lưu giỏ hàng vào localStorage sau khi render
    localStorage.setItem("cart", JSON.stringify(cart));

    updateGrandTotal();
}


// Update total cost
function updateGrandTotal() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById("grand-total").textContent = total.toLocaleString("vi-VN") + " VND";
}

// Go to confirmation page
function goToConfirmPage() {
    if (cart.length === 0) {
        showMessage("Lỗi", "Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán", true);
        return;
    }

    const cartData = {
        items: cart.map(item => ({
            id: item.id,
            name: item.name,
            quantity: item.quantity,
            price: item.price,
            total: item.price * item.quantity
        })),
        grandTotal: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    };

    localStorage.setItem("cart", JSON.stringify(cartData));
    window.location.href = "views/BanHang/confirm_invoice.php";
}
