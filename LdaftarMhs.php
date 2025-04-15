<?php
// memanggil library FPDF
require('fpdf186/fpdf.php');
include 'fungsi.php';
 

$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
 
$pdf->SetFont('Times','B',14);
$pdf->Cell(200,10,'DATA MAHASISWA',0,0,'C');
 
$pdf->Cell(10,15,'',0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(10,7,'NO',1,0,'C');
$pdf->Cell(50,7,'NIM' ,1,0,'C');
$pdf->Cell(70,7,'NAMA',1,0,'C');
$pdf->Cell(50,7,'EMAIL',1,0,'C');
 
 
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Times','',10);
$no=1;
$data = mysqli_query($koneksi,"SELECT  * FROM mhs");
while($d = mysqli_fetch_array($data)){
  $pdf->Cell(10,6, $no++,1,0,'C');
  $pdf->Cell(50,6, $d['nim'],1,0);
  $pdf->Cell(70,6, $d['nama'],1,0);  
  $pdf->Cell(50,6, $d['email'],1,1);
}
 
$pdf->Output();
 
?>