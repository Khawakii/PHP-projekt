<?php

class Authenticate {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // login
    public function login($username, $password) {
        $query = "SELECT * FROM admin WHERE username = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $storedPassword = $user['password'];

            // ✅ This is correct: password_verify() checks the plain text password against the hash
            if (password_verify($password, $storedPassword)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $user['username'];
                setcookie('admin_logged_in', '1', time() + 3600, '/');
                return true;
            }
        }

        return false;
    }

    // logout
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = array();
            setcookie('admin_logged_in', '', time() - 3600, '/');

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }

            session_destroy();
        }
    }

    // check login
    public function isLoggedIn() {
        return (
            (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) ||
            (isset($_COOKIE['admin_logged_in']) && $_COOKIE['admin_logged_in'] === '1')
        );
    }

    // require login
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }
    }

    // require admin
    public function requireAdmin() {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }

        $query = "SELECT * FROM admin WHERE username = ?";
        $stmt = mysqli_prepare($this->db, $query);
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['admin_username']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result || mysqli_num_rows($result) !== 1) {
            header("Location: no_access.php");
            exit;
        }
    }
}
?>