<?php

class msifranti extends CI_Model {
    
    function getIzpis_ena() {    
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
            // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.001');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista potnih nalogov', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 14);
        $header = array('Št. naloga', 'Namen', 'Vozilo', 'Izdan','Vrnjen');
            // data loading
            //fiter podatkov
        $omejitev = '';
        if( $this->session->userdata('inputstnaloga') != 'Izberi..' )  {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.stevilkapn = '.'"'.$this->session->userdata('inputstnaloga').'"';         
            }
            else {
                $omejitev = 'a.stevilkapn = '.'"'.$this->session->userdata('inputstnaloga').'"';
            }
        }
        if ( $this->session->userdata('inputvozilo') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.id_vozila = '.$this->session->userdata('inputvozilo');      
            }
            else {
                $omejitev = 'a.id_vozila = '.$this->session->userdata('inputvozilo');
            }
        }       
        if ( $this->session->userdata('inputvrnjen') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.vrnjen = '.'"'.$this->session->userdata('inputvrnjen').'"';        
            }
            else {
                $omejitev = 'a.vrnjen = '.'"'.$this->session->userdata('inputvrnjen').'"';
            }
        }          
        if ( $this->session->userdata('inputnamen') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.id_nameniuporabe = '.$this->session->userdata('inputnamen');
            }
            else {
                $omejitev = 'a.id_nameniuporabe = '.$this->session->userdata('inputnamen');
            }
        }        
        if ( $this->session->userdata('inputizdan') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.izdan = '.'"'.$this->session->userdata('inputizdan').'"';
            }
            else {
                $omejitev = 'a.izdan = '.'"'.$this->session->userdata('inputizdan').'"';
            }
        }              
        
        $this->db->select("a.stevilkapn,b.namenuporabe,c.znamka, DATE_FORMAT(a.izdan,'%d.%m.%Y %h:%i') as izdan, DATE_FORMAT(a.vrnjen,'%d.%m.%Y %h:%i') as vrnjen ",FALSE);
        $this->db->from('izposoje as a');
        $this->db->join('nameniuporabe as b','a.id_nameniuporabe = b.id_nameniuporabe','inner');
        $this->db->join('vozila as c','a.id_vozila = c.id_vozila','inner');
        $this->db->order_by('a.id_izposoje');    
        if ( $omejitev != '' ) {
            $this->db->where($omejitev);        
        }    
        $data = $this->db->get();  
        
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
            // Header
        $w = array(33, 37, 30, 40, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            if ($i > 0 ) {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
            }
            else {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);    
            }
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->stevilkapn, 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->namenuporabe, 'LR', 0, 'C', $fill);
            $pdf->Cell($w[2], 6, $row->znamka, 'LR', 0, 'C', $fill);
            $Weddingdate = new DateTime($row->izdan);
            $pdf->Cell($w[3], 6, date_format($Weddingdate,'d.m.Y H:i'), 'LR', 0, 'C', $fill);
            $Weddingdate = new DateTime($row->vrnjen);
            $pdf->Cell($w[4], 6, date_format($Weddingdate,'d.m.Y H:i'), 'LR', 0, 'C', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Nalogi.pdf', 'I');  
            
    }
    
    function getIzpis_dva() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Rezervacije');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, rezervacije, lista');      
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_REZ.002');      
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);              
        // add a page
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista rezervacij ', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('Helvetica', '', 12);
        $header = array('Vozilo', 'Oseba', 'Cas prevzema', 'Cas vrnitve');
        // data loading
        //fiter podatkov
        $omejitev = '';
        if ( $this->session->userdata('inputvozilo1') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.id_vozila = '.$this->session->userdata('inputvozilo1');      
            }
            else {
                $omejitev = 'a.id_vozila = '.$this->session->userdata('inputvozilo1');
            }
        }       
        if ( $this->session->userdata('inputoseba') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.id_osebe = '.'"'.$this->session->userdata('inputoseba').'"';        
            }
            else {
                $omejitev = 'a.id_osebe = '.'"'.$this->session->userdata('inputoseba').'"';
            }
        }          
        if ( $this->session->userdata('inputprevzet') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.casod = '.'"'.$this->session->userdata('inputprevzet').'"';
            }
            else {
                $omejitev = 'a.casod = '.'"'.$this->session->userdata('inputprevzet').'"';
            }
        }        
        if ( $this->session->userdata('inputvrnitev') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.casdo = '.'"'.$this->session->userdata('inputvrnitev').'"';
            }
            else {
                $omejitev = 'a.casod = '.'"'.$this->session->userdata('inputvrnitev').'"';
            }
        }          
        $this->db->select("a.casod, a.casdo, c.znamka, Concat(b.ime,' ' ,b.priimek, ',  ',b.naslov,',  ',d.postnastevilka ,' ',d.kraj ) as oseba ",FALSE);
        $this->db->from("rezervacije as a");
        $this->db->join('osebe as b','a.id_osebe = b.id_osebe','inner');
        $this->db->join('vozila as c','a.id_vozila = c.id_vozila','inner');
        $this->db->join('poste as d','b.id_poste = d.id_poste','inner');
        $this->db->order_by('a.id_osebe'); 
        if ( $omejitev != '' ) {
            $this->db->where($omejitev);        
        }   
        $data = $this->db->get();                
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(30, 84, 33, 33);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            if ($i > 1 ) {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
            }
            else {
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);    
            }
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;      
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->znamka, 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->oseba, 'LR', 0, 'L', $fill);
            $Weddingdate = new DateTime($row->casod);
            $pdf->Cell($w[2], 6, date_format($Weddingdate,'d.m.Y H:i'), 'LR', 0, 'C', $fill);
            $Weddingdate = new DateTime($row->casdo);
            $pdf->Cell($w[3], 6, date_format($Weddingdate,'d.m.Y H:i'), 'LR', 0, 'C', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Rezervacije.pdf', 'I');           
    }
    
    function getIzpis_tri() {
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Rezervacije');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, rezervacije, lista');         
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_STN.003');      
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);           
        $pdf->AddPage('L');
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista stanj', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);      
        $pdf->SetFont('helvetica', '', 12);
        $header = array('Stanje', 'KM', 'Gorivo', 'Obv.opr.','Okr. pok.','Antena','Serv.knj.','Drugo','Cistoca','Cas pregleda');
        // data loading
        
        //fiter podatkov
        $omejitev = '';
     
        if ( $this->session->userdata('inputstanje') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and b.vrstastanja = '.'"'.$this->session->userdata('inputstanje').'"';        
            }
            else {
                $omejitev = 'b.vrstastanja = '.'"'.$this->session->userdata('inputstanje').'"';
            }
        }          
        if ( $this->session->userdata('inputgorivo') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.gorivo = '.'"'.$this->session->userdata('inputgorivo').'"';
            }
            else {
                $omejitev = 'a.gorivo = '.'"'.$this->session->userdata('inputgorivo').'"';
            }
        }        
        if ( $this->session->userdata('inputpregled') != 'Izberi..' ) {
            if ( $omejitev != '' ) {
                $omejitev = $omejitev.' and a.pregledanoob = '.'"'.$this->session->userdata('inputpregled').'"';
            }
            else {
                $omejitev = 'a.pregledanoob = '.'"'.$this->session->userdata('inputpregled').'"';
            }
        }         
        $this->db->select('b.vrstastanja, a.km, a.gorivo,a.obveznaoprema , a.okrasnipokrovi, a.antena, a.servisnaknjiga, a.drugo, a.cistoca, a.pregledanoob',FALSE) ;
        $this->db->from("stanja as a");
        $this->db->join('vrstestanj as b','a.id_vrstestanj = b.id_vrstestanj','inner');
        $this->db->order_by('a.id_stanja'); 
        if ( $omejitev != '' ) {
            $this->db->where($omejitev);        
        }       
        $data = $this->db->get();               
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(37, 20, 24, 20, 20, 20, 20, 43, 28, 35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            switch ($i) {
                case 0:
                case 1:
                case 2:
                case 7:               
                    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
                    break;
                case 3:
                case 4:
                case 5:    
                case 6:
                case 8:                      
                case 9:                        
                    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
                    break;
            }    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('Helvetica', '', 9);
        $fill = '0';
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->vrstastanja, 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->km, 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->gorivo, 'LR', 0, 'L', $fill);    
            $tekst = '';
            switch ( $row->obveznaoprema ) {
                case 1:
                    $tekst = 'DA';
                    break;
                case  2:
                    $tekst = 'NE';
                    break;
                default:
                    $tekst = 'NE';
                    break;
            }
            $pdf->Cell($w[3], 6, $tekst, 'LR', 0, 'C', $fill);
            switch ( $row->okrasnipokrovi ) {
                case 1:
                    $tekst = 'DA';
                    break;
                case  2:
                    $tekst = 'NE';
                    break;
                default:
                    $tekst = 'NE';
                    break;
            }            
            $pdf->Cell($w[4], 6, $tekst, 'LR', 0, 'C', $fill);
             switch ( $row->antena ) {
                case 1:
                    $tekst = 'DA';
                    break;
                case  2:
                    $tekst = 'NE';
                    break;
                case  3:
                    $tekst = 'OKVARA';
                    break;                
                default:
                    $tekst = 'NE';
                    break;
            }             
            $pdf->Cell($w[5], 6, $tekst, 'LR', 0, 'C', $fill);
             switch ( $row->servisnaknjiga ) {
                case 1:
                    $tekst = 'DA';
                    break;
                case  2:
                    $tekst = 'NE';
                    break;
                case  3:
                    $tekst = 'OKVARA';
                    break;                
                default:
                    $tekst = 'NE';
                    break;
            }             
            $pdf->Cell($w[6], 6, $tekst, 'LR', 0, 'C', $fill);       
            $pdf->Cell($w[7], 6, $row->drugo, 'LR', 0, 'L', $fill);            
            $pdf->Cell($w[8], 6, $row->cistoca, 'LR', 0, 'C', $fill); 
            $Weddingdate = new DateTime($row->pregledanoob);
            $pdf->Cell($w[9], 6, date_format($Weddingdate,'d.m.Y H:i'), 'LR', 0, 'C', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Stanja.pdf', 'I'); 
    }
    
    function getIzpis_stiri() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');      
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.004');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista podjetji', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 10);
        $header = array('Naziv', 'Oznaka', 'Naslov', 'IDDDV','Skupina');
        // data loading
        $this->db->select("a.nazivpodjetja, a.oznakapodjetja, CONCAT (a.naslovpodjetja, ' ',b.postnastevilka, ' ', b.kraj ) as posta , a.idzaddv, a.podjetjacol ",FALSE);
        $this->db->from('podjetja as a');
        $this->db->join('poste as b','a.id_poste = b.id_poste','inner');
        $this->db->order_by('a.id_podjetja');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(45, 20, 75, 20, 20);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, 'L', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->nazivpodjetja, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->oznakapodjetja, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->posta, '', 0, 'L', $fill);
            $pdf->Cell($w[3], 6, $row->idzaddv, '', 0, 'L', $fill);
            $pdf->Cell($w[4], 6, $row->podjetjacol, '', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Podjetja.pdf', 'I');    
    }
    
    function getIzpis_pet() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.005');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista pošt', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 14);
        $header = array('Številka', 'Kraj', 'Drzava');
        // data loading
        $this->db->select("a.postnastevilka, a.kraj, 'Slovenija' as drzava ",FALSE);
        $this->db->from('poste as a');
        $this->db->order_by('a.postnastevilka asc');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(50, 90, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, 'L', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->postnastevilka, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->kraj, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->drzava, '', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;      
            
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Poste.pdf', 'I');   
    }
    
    function getIzpis_sest() {
        $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.006');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage('L');
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista oseb ', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 10);
        $header = array('Ime in priimek', 'Naslov', 'Telefon','Email', 'Št. dokumenta', 'Velj. dok.', 'Uporabnik', 'Geslo');
        // data loading
        $this->db->select("concat(a.ime, ' ', a.priimek) as ime, concat(a.naslov,' ', b.postnastevilka,' ', b.kraj) as naslov, a.telefon, a.elektronskaposta, a.stevilkaosebnegadok, a.veljavnostosdok, a.uporabniskoime, a.geslo",FALSE);
        $this->db->from('osebe as a');
        $this->db->join('poste as b','a.id_poste = b.id_poste','inner');
        $this->db->join('podjetja as c','a.id_podjetja = c.id_podjetja','inner');
        $this->db->order_by('a.ime');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(37, 50, 23, 40, 43, 20, 27, 27);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, 'L', 1);   
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 8);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->ime, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->naslov, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->telefon, '', 0, 'L', $fill);
            $pdf->Cell($w[3], 6, $row->elektronskaposta, '', 0, 'L', $fill);              
            $pdf->Cell($w[4], 6, $row->stevilkaosebnegadok, '', 0, 'L', $fill);                              
            $Weddingdate = new DateTime($row->veljavnostosdok);
            $pdf->Cell($w[5], 6, date_format($Weddingdate,'d.m.Y'), '', 0, 'L', $fill); 
            $pdf->Cell($w[6], 6, $row->uporabniskoime, '', 0, 'L', $fill);    
            $pdf->Cell($w[7], 6, $row->geslo, '', 0, 'L', $fill);                                     
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Osebe.pdf', 'I');     
    }
    
    function getIzpis_sedem() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.007');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage('L');
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista vozil', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 10);
        $header = array('Znamka', 'Oznaka', 'Tip', 'Regist. do','Registrska', 'Oseba');
        // data loading
        $this->db->select("a.znamka, a.oznakavozila, a.tipvozila, a.registrirando, a.registrska, concat (b.ime, ' ', b.priimek, ' ', b.naslov) as oseba",FALSE);
        $this->db->from('vozila as a');
        $this->db->join('osebe as b','a.id_osebe = b.id_osebe','inner');
        $this->db->order_by('a.id_vozila');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(43, 45, 45, 35, 34, 65);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, '', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->znamka, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->oznakavozila, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->tipvozila, '', 0, 'L', $fill);
            $Weddingdate = new DateTime($row->registrirando);
            $pdf->Cell($w[3], 6, date_format($Weddingdate,'d.m.Y'), '', 0, 'L', $fill);
            $pdf->Cell($w[4], 6, $row->registrska, '', 0, 'L', $fill);
            $pdf->Cell($w[5], 6, $row->oseba, '', 0, 'L', $fill);            
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Vozila.pdf', 'I');    
    }
    
    function getIzpis_osem() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.008');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista vrste stanj', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 12);
        $header = array('Id', 'Vrsta stanja');
        // data loading
        $this->db->select('a.id_vrstestanj, a.vrstastanja');
        $this->db->from('vrstestanj as a');
        $this->db->order_by('a.id_vrstestanj');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(35, 145);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, '', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->id_vrstestanj, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->vrstastanja, '', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Vrste_stanj.pdf', 'I');    
    }
    
    function getIzpis_devet() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.009');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista namenov uporabe', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 14);
        $header = array('Id.', 'Namen', 'Opis namena');
        // data loading
        $this->db->select('a.id_nameniuporabe, a.namenuporabe,a.opisnamenauporabe ');
        $this->db->from('nameniuporabe as a');
        $this->db->order_by('a.id_nameniuporabe');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(35, 65, 80);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, '', 1);   
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->id_nameniuporabe, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->namenuporabe, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->opisnamenauporabe, '', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Nameni_uporabe.pdf', 'I');  
    }
    
    function getIzpis_deset() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.010');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista log oseb', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 14);
        $header = array('Id.', 'Vloga', 'Opis');
        // data loading
        $this->db->select('a.id_vlogeoseb, a.vlogaosebe, a.opisvlogeosebe');
        $this->db->from('vlogeoseb as a');
        $this->db->order_by('a.id_vlogeoseb');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(33, 67, 80);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, '', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->id_vlogeoseb, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->vlogaosebe, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->opisvlogeosebe, '', 0, 'L', $fill);;
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Vlogeoseb.pdf', 'I');        
    }
    
    function getIzpis_enajst() {
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', true);
        $pdf->SetCreator('Marko');
        $pdf->SetAuthor('Marko Novak');
        $pdf->SetTitle('Potni nalogi');
        $pdf->SetSubject('Potni Nalogi');
        $pdf->SetKeywords('TCPDF, PDF, izpisne liste, pontni nalogi, lista');
        // set default header data          
        $pdf->SetHeaderData(PDF_HEADER_LOGO,18, '','IZP_PN.011');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
        require_once (BASEPATH.'../application/language/slv.php');         
        $pdf->setLanguageArray($l);   
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Write(0, 'Lista vlog ', '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, '', '', 0, 'C', 1, 0, false, false, 0);     
        $pdf->SetFont('helvetica', '', 14);
        $header = array('Številka', 'Naziv', 'Opis');
        // data loading
        $this->db->select('a.stevilkavloge, a.nazivvloge, a.opisvloge ');
        $this->db->from('vloge as a');
        $this->db->order_by('a.id_vloge');   
        $data = $this->db->get();           
        $pdf->SetFillColor(254, 400, 500);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(10, 20, 2);
        $pdf->SetLineWidth(0.1);
        // Header
        $w = array(34, 73, 73);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 'TB', 0, '', 1);    
        }
        $pdf->Ln();
        $pdf->SetFillColor(255, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $pdf->SetFont('helvetica', '', 10);
        $fill = '0';
        $j = 0;  
        foreach ($data->result() as $row ) {             
            $pdf->Cell($w[0], 6, $row->stevilkavloge, '', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $row->nazivvloge, '', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, $row->opisvloge, '', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;      
        }
        $pdf->Cell((string)$data->row_count, 6, '', 'T', 0, '', '0');
        $pdf->Output('Vloge.pdf', 'I');        
    }
    
    
}

