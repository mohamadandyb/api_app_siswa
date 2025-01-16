<?php
// Menggunakan CORS untuk mengizinkan permintaan dari domain lain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE"); // Ganti dengan DELETE
header("Content-Type: application/json; charset=UTF-8");

// Koneksi ke database
$servername = "localhost"; // Ganti dengan hostname database Anda
$username = "root"; // Ganti sesuai username database
$password = "mysql123"; // Ganti sesuai password database
$dbname = "db_siswa"; // Ganti dengan nama database Anda
$port = 8889; // Ganti dengan port yang sesuai jika diperlukan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Memeriksa koneksi
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

// Mengambil ID yang dikirim dari request
$data = json_decode(file_get_contents("php://input"), true); // Mengambil dan mendecode data JSON
$id = $data['id'] ?? null; // Mendapatkan ID yang diterima

// Memastikan ID tidak kosong
if ($id === null) {
    echo json_encode(["message" => "ID tidak boleh kosong!"]);
    exit();
}

// Menyiapkan query SQL untuk menghapus data
$sql = "DELETE FROM siswa WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // Mengikat parameter (integer)

// Eksekusi query
if ($stmt->execute()) {
    echo json_encode(["message" => "Data berhasil dihapus!"]);
} else {
    echo json_encode(["message" => "Gagal menghapus data: " . $stmt->error]);
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>