<?php
// memanggil library FPDF
require('fpdf186/fpdf.php');
include 'fungsi.php';
 

$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
 
$pdf->SetFont('Times','B',14);
$pdf->Cell(200,10,'DATA PENGGUNA',0,0,'C');
 
$pdf->Cell(10,15,'',0,1);
$pdf->SetFont('Times','B',9);
$pdf->Cell(20,7,'ID USER',1,0,'C');
$pdf->Cell(90,7,'NAMA',1,0,'C');
$pdf->Cell(70,7,'STATUS',1,0,'C');
 
 
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Times','',10);
$no=1;
$data = mysqli_query($koneksi,"SELECT  * FROM user");
while($d = mysqli_fetch_array($data)){
  $pdf->Cell(20,6, $d['iduser'],1,0,'C');
  $pdf->Cell(90,6, $d['username'],1,0);  
  $pdf->Cell(70,6, $d['status'],1,1);
}
 
$pdf->Output();
 
?>