<?php
// Include koneksi ke database
include_once '../includes/koneksi.php';

// Fungsi untuk mengambil semua event dari database
function getAllEvents($pdo) {
    $query = "SELECT * FROM events";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Memanggil fungsi getAllEvents dan mengembalikan hasilnya sebagai respons JSON
header('Content-Type: application/json');
echo json_encode(getAllEvents($pdo));
?>
