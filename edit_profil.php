<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'config/database.php';
include 'includes/header.php';

$user_id = $_SESSION['user']['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_username = trim($_POST['username'] ?? '');
    if ($new_username !== '') {
        $stmt = mysqli_prepare($conn, "UPDATE users SET username = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'si', $new_username, $user_id);
        mysqli_stmt_execute($stmt);
        echo "Profil berhasil diperbarui!";
        $_SESSION['user']['username'] = $new_username;
    }
}

$stmt = mysqli_prepare($conn, "SELECT username FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
?>

<h2>Edit Profil Pengguna</h2>
<form method="POST">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($data['username'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
    <button type="submit">Simpan</button>
</form>

<?php include 'includes/footer.php'; ?>