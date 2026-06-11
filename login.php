<?php
include 'config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        echo "Login Gagal!";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'role' => $row['role']
                ];
                header("Location: dashboard.php");
                exit();
            }
        }

        echo "Login Gagal!";
    }
}
?>
<form method="POST" autocomplete="off">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>