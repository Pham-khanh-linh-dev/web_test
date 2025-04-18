<?php
require_once __DIR__ . '/../config/db.php';

class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = getDbConnection();
    }

    // define select cho các hàm sau gọi đến
    public function select($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database select error: " . $e->getMessage());
            return [];
        }
    }

    // chỉnh sửa thông tin nhân viên: employee-detail.php
    public function getEmployeeById($id) {
        $query = "SELECT * FROM users WHERE id = :id AND role = 'employee'";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching employee: " . $e->getMessage());
            return false;
        }
    }
    // Updata status
    public function updateEmployeeStatus($id, $status) {
        $query = "UPDATE users SET status = :status WHERE id = :id AND role = 'employee'";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([
                ':id' => $id,
                ':status' => $status
            ]);
    
            // Trả về kết quả mà không cần gọi logActivity
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating employee status: " . $e->getMessage());
            return false;
        }
    }
    
    // getallEmployee
    public function getAllEmployees() {
        $query = "SELECT * FROM users WHERE role = 'employee' ORDER BY created_at DESC";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching employees: " . $e->getMessage());
            return [];
        }
    }

    public function insert($email, $fullname) {
        $username = strstr($email, '@', true);
        $role = 'employee';
        
        $query = "INSERT INTO users (fullname, email, username, role) VALUES (:fullname , :email, :username, :role)";
        
        $stmt = $this->pdo->prepare($query); // tránh bị sql injection

        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':username' => $username,
            ':role' => $role
        ]);
    }

    public function insertAdmin($email, $fullname, $password) {
        $username = strstr($email, '@', true);
        $status = 'active';

        $role = 'admin';
        
        $query = "INSERT INTO users (fullname, email, username, password, role, status) VALUES (:fullname , :email, :username,  :password , :role, :status)";
        
        $stmt = $this->pdo->prepare($query); // tránh bị sql injection

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':fullname' => $fullname,
                ':email' => $email,
                ':username' => $username,
                ':password' => $password,
                ':role' => $role,
                ':status' => $status
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error when inserting admin: " . $e->getMessage());
            throw $e; // Re-throw to maintain current error handling
        }
    }


    // cách này cũng tránh đc sql injection 
    public function checkEmailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $params = ['email' => $email];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function checkAdmin($username, $password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password AND role = 'admin' AND status = 'active'";
        $params = ['username' => $username, 'password' => $password];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function checkUser($username, $password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password AND role = 'employee' AND status = 'active'";
        $params = ['username' => $username, 'password' => $password];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function checkActive($username, $temporary_password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND temporary_password = :temporary_password AND role = 'employee' AND status = 'inactive'";
        $params = ['username' => $username, 'temporary_password' => $temporary_password];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function changePass($username, $temporary_password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND temporary_password = :temporary_password AND role = 'employee' AND status = 'active'";
        $params = ['username' => $username, 'temporary_password' => $temporary_password];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function checkLocked($username, $password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password AND status = 'locked'";
        $params = ['username' => $username, 'password' => $password];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    public function updateStatus($email) {
        $query = "UPDATE users SET status = 'active' WHERE email = :email AND status = 'inactive'";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email]);
        } catch (PDOException $e) {
            die("Lỗi khi thực hiện UPDATE: " . $e->getMessage());
        }
    }

    public function deleteEmployee($id) {
        $query = "DELETE FROM users WHERE id = :id AND role = 'employee'";
        $params = ['id' => $id];
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            
            // Check if any rows were affected
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting employee: " . $e->getMessage());
            return false;
        }
    }

    public function firstLogin($email, $newpassword) {
        $query = "UPDATE users SET password  = :newpassword WHERE email = :email";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':email' => $email , ':newpassword' => $newpassword]);
        } catch (PDOException $e) {
            die("Lỗi khi thực hiện UPDATE: " . $e->getMessage());
        }
    }

    // check password
    public function checkPassword($username, $password) {
        $query = "SELECT COUNT(*) FROM users WHERE username = :username AND password = :password";
        $params = [
            ':username' => $username, 
            ':password' => $password
        ];
        $result = $this->select($query, $params);
        return $result[0]['COUNT(*)'] > 0;
    }

    // update password
    public function updatePass($user, $newpassword) {
        $query = "UPDATE users SET password  = :newpassword WHERE username = :username";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':username' => $user , ':newpassword' => $newpassword]);
            return true;

        } catch (PDOException $e) {
            die("Lỗi khi thực hiện UPDATE: " . $e->getMessage());
            return false;
        }
    }
    // hàm trả về name và role của người dùng được hiển thị trên header trong mỗi session
    public function getUserNameAndRole($username) {
        $query = "SELECT fullname, role FROM users WHERE username = :username";
        $params = ['username' => $username];
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Format: Username (Role)
                return '<span style="color: green; font-weight: bold;">' . htmlspecialchars($user['fullname']) . " <small>- " . ucfirst(htmlspecialchars($user['role'])) . "</small>" . '</span>';
            } else {
                // Return a default if user not found
                return htmlspecialchars($username) . " <small>(Không xác định)</small>";
            }
        } catch (PDOException $e) {
            // Log error but don't die - return something safe
            error_log("Lỗi khi lấy thông tin người dùng: " . $e->getMessage());
            return htmlspecialchars($username);
        }
    

    }

    // resent email for employee
    public function resendActivationEmail($id){
        $query = "SELECT * FROM users WHERE id = :id AND role = 'employee'";
    
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $employee['email'];


            
            $activation_token = bin2hex(random_bytes(16));
            $expires = time() + 60;
            $link = "https://localhost/laptrinhweb_da19_hk2_2425/source/api/url.php?token=$activation_token&email=$email&expires=$expires";


            $subject = 'Test Email from POS System';  
            $message = '
                <html>
                <head>
                <title>Kích hoạt tài khoản</title>
                </head>
                <body>
                <p>Chào bạn,</p>
                <p>Tài khoản của bạn đã kích hoạt thành công. Vui lòng nhấp vào link dưới đây để kích hoạt tài khoản hệ thống:</p>
                <p><a href="' . $link . '" target="_blank">Nhấp vào đây để kích hoạt</a></p>
                <p>Liên kết này sẽ hết hạn sau 1 phút.</p>
                </body>
                </html>
            '; 
            require_once __DIR__ . '/../config/mail.php';

            $result = sendMail($email, $subject, $message);
            return ($result == "Email đã được gửi thành công!");

        }catch (PDOException $e) {
                error_log("Error in resendActivationEmail: " . $e->getMessage());
                return false;
            }
        
    }
}
?>
