<?php
// Include koneksi ke database
include_once '../includes/koneksi.php';
// Include library FPDF
require_once('../fpdf/fpdf.php');

// Fungsi untuk mengambil data sertifikat dari database berdasarkan certificate_id
function getCertificateData($pdo, $certificate_id) {
    $queryCertificate = "SELECT * FROM certificates WHERE certificate_id = :certificate_id";
    $stmtCertificate = $pdo->prepare($queryCertificate);
    $stmtCertificate->bindParam(':certificate_id', $certificate_id);
    $stmtCertificate->execute();
    return $stmtCertificate->fetch(PDO::FETCH_ASSOC);
}

// Ambil certificate_id dari parameter GET
if(isset($_GET['certificate_id']) && !empty($_GET['certificate_id'])) {
    $certificate_id = $_GET['certificate_id'];
    
    // Ambil data sertifikat
    $certificate = getCertificateData($pdo, $certificate_id);
    
    // Jika sertifikat ditemukan
    if($certificate) {
        // Set nama file untuk PDF
        $pdf_filename = "certificate_".$certificate_id.".pdf";
        
        // Membuat instance FPDF
        class PDF extends FPDF {
            function Header(){
                // Pindah ke posisi 1.5 cm dari atas
                $this->SetY(15);
                // Judul
                $this->SetFont('Arial','B',18);
                $this->Cell(0,10,'Certificate',0,1,'C');
                $this->Ln(10);
            }
            function Footer(){
                // Posisi 1.5 cm dari bawah
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',8);
                // Nomor halaman
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }
        }
        
        // Membuat objek PDF
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // Tambahkan konten sertifikat
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,'Participant Name: '.$certificate['participant_name'],0,1,'C');
        $pdf->Cell(0,10,'Event Name: '.$certificate['event_name'],0,1,'C');
        $pdf->Cell(0,10,'Event Date: '.$certificate['event_date'],0,1,'C');
        $pdf->Cell(0,10,'Certificate Text: '.$certificate['certificate_text'],0,1,'C');
        
        // Output PDF ke browser
        $pdf->Output($pdf_filename, 'I');
    } else {
        // Sertifikat tidak ditemukan, tampilkan pesan error
        echo 'Certificate not found.';
    }
} else {
    // Parameter certificate_id tidak diberikan, tampilkan pesan error
    echo 'Certificate ID is missing.';
}
?>
