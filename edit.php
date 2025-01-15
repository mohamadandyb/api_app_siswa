<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

// Koneksi ke database
$koneksi = new mysqli('localhost', 'root', 'mysql123', 'db_siswa');

// Mengecek apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data dari request
$id = $_POST["id"] ?? null; // Mendapatkan ID yang diterima
$nisn = $_POST['nisn'] ?? '';
$nama = $_POST['nama'] ?? '';
$alamat = $_POST['alamat'] ?? '';

// Memastikan data tidak kosong
if (empty($id) || empty($nisn) || empty($nama) || empty($alamat)) {
    echo json_encode(["message" => "Semua kolom harus diisi!"]);
    exit();
}

// Menyiapkan query SQL untuk update data ke dalam tabel
$query = "UPDATE siswa SET nisn=?, nama=?, alamat=? WHERE id=?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("sssi", $nisn, $nama, $alamat, $id); // Mengikat parameter

// Eksekusi query
if ($stmt->execute()) {
    echo json_encode(["message" => "Data berhasil diperbarui!"]);
} else {
    echo json_encode(["message" => "Gagal edit data: " . $stmt->error]);
}

// Menutup koneksi
$stmt->close();
$koneksi->close();
?>