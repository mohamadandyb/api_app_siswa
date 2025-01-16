<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

// Koneksi ke database
$servername = "localhost"; // Ganti dengan hostname database Anda
$username = "root"; // Ganti sesuai username database
$password = "mysql123"; // Ganti sesuai password database
$dbname = "db_siswa"; // Ganti dengan nama database Anda
$port = 8889; // Ganti dengan port yang sesuai jika diperlukan

// Koneksi ke database
$koneksi = new mysqli($servername, $username, $password, $dbname, $port);

// Mengecek apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mengambil data dari request
$data = json_decode(file_get_contents("php://input"), true); // Mengambil dan mendecode data JSON
$id = $data['id'] ?? null; // Mendapatkan ID yang diterima
$nisn = $data['nisn'] ?? '';
$nama = $data['nama'] ?? '';
$alamat = $data['alamat'] ?? '';

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