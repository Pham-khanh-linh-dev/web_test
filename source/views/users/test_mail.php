<?php
require '../../config/mail.php';

$to = 'pklinhbl9848@gmail.com';
$subject = 'Test Email từ POS System';
$message = 'Chào bạn, đây là đường dẫn đăng nhập vào hệ thống POS của bạn, thời gian hết hạn của đường dẫn này là 1 phút';

if (sendMail($to, $subject, $message)) {
    echo "Email đã gửi thành công!";
} else {
    echo "Gửi email thất bại!";
}
?>
