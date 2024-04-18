<?php
// Include library FPDF
require('../fpdf/fpdf.php');

// Mulai session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "user") {
    // Jika pengguna belum login atau bukan pengguna, alihkan ke halaman login
    header("Location: login_user.php");
    exit();
}

// Include koneksi ke database
include_once '../includes/koneksi.php';

// Ambil ID sertifikat dari parameter URL
if (isset($_GET['certificate_id'])) {
    $certificate_id = $_GET['certificate_id'];

    // Query untuk mengambil detail sertifikat
    $queryCertificate = "SELECT * FROM certificates WHERE certificate_id = :certificate_id";
    $stmtCertificate = $pdo->prepare($queryCertificate);
    $stmtCertificate->bindParam(':certificate_id', $certificate_id);
    $stmtCertificate->execute();
    $certificate = $stmtCertificate->fetch(PDO::FETCH_ASSOC);

    // Buat objek PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    
    // Judul
    $pdf->Cell(0,10,'Certificate',0,1,'C');
    $pdf->Ln(10);

    // Isi sertifikat
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Participant Name: '.$certificate['participant_name'],0,1);
    $pdf->Cell(0,10,'Event Name: '.$certificate['event_name'],0,1);
    $pdf->Cell(0,10,'Event Date: '.$certificate['event_date'],0,1);
    $pdf->Cell(0,10,'Certificate Text: '.$certificate['certificate_text'],0,1);

    // Output PDF
    $pdf->Output();
} else {
    // Jika parameter certificate_id tidak diberikan, alihkan ke halaman sebelumnya
    header("Location: view_certificates.php");
    exit();
}
?>
