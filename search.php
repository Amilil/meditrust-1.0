<?php
include 'config/database.php';
include 'config/crypto.php';

$queryValue = trim($_GET['q'] ?? '');
echo "<h1>Hasil Pencarian Pasien:</h1>";

if ($queryValue === '') {
    echo "<p>Silakan masukkan nama pasien untuk mencari.</p>";
    return;
}

$searchParam = "%{$queryValue}%";
$stmt = mysqli_prepare($conn, "SELECT name, nik FROM patients WHERE name LIKE ?");
mysqli_stmt_bind_param($stmt, 's', $searchParam);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = escape($row['name']);
        $nik = escape(decryptValue($row['nik']));
        echo "<p>Nama: {$name} | NIK: {$nik}</p>";
    }
} else {
    echo "<p>Tidak ada pasien ditemukan untuk kata kunci yang dimasukkan.</p>";
}
?>