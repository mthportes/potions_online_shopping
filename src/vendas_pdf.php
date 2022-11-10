<?php 
    include 'host.php'; 
    require "../api/fpdf/fpdf.php";

    $db = new PDO('mysql:host=localhost; dbname=potions', 'root', '');

    class myPDF extends FPDF{
        function header(){
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(276, 5, 'RELATORIO DE VENDAS', 0,0,'C');
            $this->Ln(20);
        }
        function footer(){
            $this->SetY(-15);
            $this->SetFont('Arial', '', 8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            $this->Ln();
        }
        function headerTable(){
            $this->SetFont('Times', 'B', 12);
            $this->Cell(50,10,'',0,0,'C');
            $this->Cell(40,10,'Data',1,0,'C');
            $this->Cell(30,10,'Total',1,0,'C');
            $this->Cell(60,10,'Produto',1,0,'C');
            $this->Cell(40,10,'Cliente',1,0,'C');
            $this->Ln();
        }
        function viewTable($db){
            $this->SetFont('Times', '',12);
            $stmt = $db->query('SELECT data, total, produto, cliente FROM venda');
            while($venda = $stmt->fetch(PDO::FETCH_OBJ)){
                $this->Cell(50,10,'',0,0,'C');
                $this->Cell(40,10,$venda->data,1,0,'C');
                $this->Cell(30,10,$venda->total,1,0,'C');
                $this->Cell(60,10,$venda->produto,1,0,'C');
                $this->Cell(40,10,$venda->cliente,1,0,'C');
                $this->Ln();
            }
        }

    }

    $pdf = new myPDF();
    $pdf->AliasNbPAges();
    $pdf->AddPage('L', 'A4', 0);
    $pdf->headerTable();
    $pdf->viewTable($db);
    $pdf->Output();

?>