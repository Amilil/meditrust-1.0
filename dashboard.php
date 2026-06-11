<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'config/database.php';
include 'includes/header.php';
?>

<h2>Dashboard Dokter</h2>
<p>Selamat bekerja, Dokter <?php echo isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : ''; ?>!</p>

<h3>Daftar Pasien Terbaru:</h3>
<ul>
<?php
$stmt = mysqli_prepare($conn, "SELECT id, name FROM patients");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li>" . htmlspecialchars($row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " - <a href='detail_pasien.php?id=" . intval($row['id']) . "'>Lihat Detail</a></li>";
}
?>
</ul>

<?php include 'includes/footer.php'; ?>