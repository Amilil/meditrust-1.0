<?php
include 'config/database.php';
include 'config/crypto.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: dashboard.php');
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT name, nik, diagnosis FROM patients WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<p>Data pasien tidak ditemukan.</p>";
    exit();
}
?>

<h1>Detail Rekam Medis</h1>
<p>Nama: <?php echo escape($row['name']); ?></p>
<p>NIK: <?php echo escape(decryptValue($row['nik'])); ?></p>
<p>Diagnosis: <?php echo nl2br(escape($row['diagnosis'])); ?></p>

<a href="dashboard.php">Kembali</a>