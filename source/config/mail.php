

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "PHPMailer/src/PHPMailer.php"; 
require "PHPMailer/src/SMTP.php"; 
require 'PHPMailer/src/Exception.php';


function sendMail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    try {

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP Server
        $mail->SMTPAuth = true;
        $mail->Username = 'khanhbl9848@gmail.com';  // Email của bạn
        $mail->Password = 'szbr qpru fncc zgju';  // Sử dụng mật khẩu ứng dụng
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Thiết lập địa chỉ người gửi và người nhận
        $mail->setFrom('khanhbl9848@gmail.com', 'POS System');
        $mail->addAddress($to);

        // Cấu hình nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Gửi email
        if ($mail->send()) {
            return "Email đã được gửi thành công!";
        } else {
            return "Không thể gửi email.";
        }
    } catch (Exception $e) {
        return "Lỗi gửi email: {$mail->ErrorInfo}";
    }
}


// Thử gửi email
// $to = 'nguyennhat7102@gmail.com';  // Địa chỉ email người nhận
// $subject = 'Test Email from POS System';  // Chủ đề email
// $message = 'This is a test email from the POS system.';  // Nội dung email

// // Gọi hàm gửi email và trả về kết quả
// $result = sendMail($to, $subject, $message);
// echo $result;  // In kết quả trả về từ hàm gửi email




?>
