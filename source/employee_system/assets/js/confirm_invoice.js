let currentCustomer = null;
const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));

// Hiển thị thông báo
function showMessage(title, message) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalMessage').textContent = message;
    messageModal.show();
}

// Tải dữ liệu giỏ hàng từ localStorage và hiển thị
function loadCartData() {
    const productList = document.getElementById("summary-product-list");
    // Đọc dữ liệu giỏ hàng từ localStorage và kiểm tra tính hợp lệ của dữ liệu
    const rawCart = JSON.parse(localStorage.getItem("cart"));
    const cartData = rawCart?.items || [];


    // Kiểm tra nếu cartData không phải là mảng
    if (!Array.isArray(cartData)) {
        cartData = [];
    }

    // Nếu giỏ hàng rỗng
    if (cartData.length === 0) {
        productList.innerHTML = "<tr><td colspan='4' class='text-center text-muted'>Không có sản phẩm nào trong giỏ hàng!</td></tr>";
        document.getElementById("summary-grand-total").textContent = "0 VND";
        return;
    }

    let grandTotal = 0;
    productList.innerHTML = "";

    // Duyệt qua từng sản phẩm trong giỏ hàng và hiển thị
    cartData.forEach(product => {
        const cleanPrice = parseInt(product.price.toString().replace(/[^\d]/g, ""));
        const rowTotal = product.quantity * cleanPrice;
        grandTotal += rowTotal;

        const row = `
            <tr>
                <td>${product.name}</td>
                <td>${product.quantity}</td>
                <td>${cleanPrice.toLocaleString("vi-VN")} VND</td>
                <td>${rowTotal.toLocaleString("vi-VN")} VND</td>
            </tr>
        `;
        productList.innerHTML += row;
    });

    document.getElementById("summary-grand-total").textContent = grandTotal.toLocaleString("vi-VN") + " VND";
}


// Tìm khách hàng
function findCustomer() {
    const phone = document.getElementById("customer-phone").value.trim();
    if (!phone) {
        showMessage("Lỗi", "Vui lòng nhập số điện thoại khách hàng!");
        return;
    }

    fetch("../../findCustomer.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ phone: phone })
    })
    .then(response => {
        if (!response.ok) throw new Error("Lỗi kết nối");
        return response.json();
    })
    .then(data => {
        const customerInfo = document.getElementById("customer-info");
        if (data.success) {
            currentCustomer = data;
            customerInfo.innerHTML = `
                <div class="card p-3 bg-light">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5><i class="fas fa-user-check text-success"></i> ${data.name}</h5>
                            <p class="mb-1"><i class="fas fa-phone"></i> ${phone}</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt"></i> ${data.address}</p>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="clearCustomer()">
                            <i class="fas fa-times"></i> Xóa
                        </button>
                    </div>
                </div>
            `;
        } else {
            currentCustomer = null;
            customerInfo.innerHTML = `
                <div class="card p-3 bg-light">
                    <h5 class="text-danger"><i class="fas fa-user-slash"></i> Không tìm thấy</h5>
                    <p>Khách hàng mới sẽ được tạo tự động khi thanh toán</p>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" id="customer-name" class="form-control" placeholder="Họ tên">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="customer-address" class="form-control" placeholder="Địa chỉ">
                        </div>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        showMessage("Lỗi", "Đã xảy ra lỗi khi tìm kiếm khách hàng");
    });
}

// Xóa thông tin khách hàng
function clearCustomer() {
    currentCustomer = null;
    document.getElementById("customer-info").innerHTML = "";
    document.getElementById("customer-phone").value = "";
}

// Chuẩn bị dữ liệu và submit
function confirmInvoice() {
    const cartData = JSON.parse(localStorage.getItem("cart")) || [];
    if (cartData.length === 0) {
        showMessage("Lỗi", "Giỏ hàng đang trống!");
        return;
    }

    const customerPhone = document.getElementById("customer-phone").value.trim();
    const totalText = document.getElementById("summary-grand-total").textContent; // "30.000.000 VND"
    const numericTotal = parseInt(totalText.replace(/[^\d]/g, '')); // => 30000000

    let invoiceData = {
        products: cartData,
        total: numericTotal, // Gửi số "thô"
        customer: null
    };

    if (!currentCustomer) {
        const name = document.getElementById("customer-name")?.value.trim();
        const address = document.getElementById("customer-address")?.value.trim();

        if (name && address && customerPhone) {
            invoiceData.customer = {
                name: name,
                address: address,
                phone: customerPhone
            };
        } else {
            showMessage("Lỗi", "Vui lòng nhập đầy đủ thông tin khách hàng mới (tên, địa chỉ, số điện thoại)!");
            return;
        }
    } else {
        invoiceData.customer = {
            name: currentCustomer.name,
            address: currentCustomer.address,
            phone: customerPhone
        };
    }

    document.getElementById("invoiceData").value = JSON.stringify(invoiceData);
    document.getElementById("invoiceForm").submit();

    // Xóa giỏ hàng sau khi in
    localStorage.removeItem("cart");
}

// Load khi trang sẵn sàng
document.addEventListener("DOMContentLoaded", loadCartData);
