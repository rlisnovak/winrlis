<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
//require_once dirname(__FILE__) . '\tcpdf\tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function LoadData() {
        $con = mysql_connect("localhost:100", "root", "root");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("potninalogi");
        $query = "SELECT izposoje.stevilkapn,nameniuporabe.namenuporabe,vozila.znamka,izposoje.izdan,izposoje.vrnjen".
                 "FROM  izposoje, nameniuporabe, vozila".
                 "WHERE izposoje.id_nameniuporabe=nameniuporabe.id_nameniuporabe and izposoje.id_vozila=vozila.id_vozila".
                 "ORDER BY izposoje.stevilkapn";
        $izposoje_qry = mysql_query($query);
        
        return $izposoje_qry;
    }

	// Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(254, 400, 500);
        $this->SetTextColor(0);
        $this->SetDrawColor(10, 20, 2);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'I');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255, 235, 255);
        $this->SetTextColor(255);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'RL', $fill);
            $this->Cell($w[2], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[1], 'LR', 0, 'RL', $fill);
            $this->Cell($w[4], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill=!$fill;
        }
//        $this->Cell(array_sum($w), 0, '', 'T');
    }
    
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
