$(document).ready(function() {
  
    $(".view-details").click(function() {
      const card = $(this).closest(".customer-card");
      const customerId = card.data('id');
      const orderDiv = card.next(".order-details");
      
      if (orderDiv.data('loaded')) {
        orderDiv.slideToggle();
        return;
      }
      
      orderDiv.html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>').slideDown();
      
      $.get(`get_orders.php?customer_id=${customerId}`, function(data) {
        if (data) {
          orderDiv.html(data).data('loaded', true);
        } else {
          orderDiv.html('<div class="alert alert-danger">Không có lịch sử mua hàng</div>');
        }
      }).fail(function() {
        orderDiv.html('<div class="alert alert-danger">Lỗi tải dữ liệu</div>');
      });
    });
  });
  