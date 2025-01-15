<?php
$koneksi = new mysqli('localhost', 'root', 'mysql123', 'db_siswa');

// Mengecek apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$nisn = $_POST['nisn'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];

// Menyiapkan query SQL untuk memasukkan data ke dalam tabel
$query = "INSERT INTO siswa (nisn, nama, alamat) VALUES ('$nisn', '$nama', '$alamat')";

// Eksekusi query
if (mysqli_query($koneksi, $query)) {
    echo json_encode([
        'pesan' => 'Sukses'
    ]);
} else {
    echo json_encode([
        'pesan' => 'Gagal'
    ]);
}

// Menutup koneksi
$koneksi->close();
?>