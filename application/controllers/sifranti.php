<?php

class Sifranti extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
        
        session_start();  
        $status = session_status();
        if ($status == PHP_SESSION_NONE) {           
            $_SESSION['prijavljen'] = "FALSE";
            $_SESSION['uporabnik'] = '';
            $_SESSION['vloga'] = '';

        }       

        if ( ! isset($_SESSION['vloga'] ) ) {
            $_SESSION['vloga'] = '';
        }    
        if ( ! isset($_SESSION['uporabnik'] ) ) {
            $_SESSION['uporabnik'] = '';
        }  
        if ( ! isset($_SESSION['prijavljen'] ) ) {
            $_SESSION['prijavljen'] = FALSE;
        }
         $timeout = 180; // 3 minute čaka na ukaz sicer odlogira

        if(isset($_SESSION['timeout'])) {

            $duration = time() - (int)$_SESSION['timeout'];
            if($duration > $timeout) {
                session_unset();
                $_SESSION['prijavljen'] = "FALSE";
                $_SESSION['vloga'] = "";    
                $_SESSION['uporabnik'] = "";
            }
        }
        $_SESSION['timeout'] = time();          
    }    
    
    function crd_slo() {
               
        $jezik = 'slovenian';       
        $this->session->set_userdata('jezik',$jezik);   
        $pot = $_SESSION['pot'];
        echo "<script>location.href='$pot'</script>";
        
    }
    
    function crd_ang() {        
        $jezik = 'english';     
        $this->session->set_userdata('jezik',$jezik); 
        $pot = $_SESSION['pot'];
        echo "<script>location.href='$pot'</script>";
    }
    
    function crd_ger() {
        
        $jezik = 'german';     
        $this->session->set_userdata('jezik',$jezik);   
        $pot = $_SESSION['pot'];
        echo "<script>location.href='$pot'</script>";
    }    
   
    function index() {  
        if ( ! isset($_SESSION['vloga'] ) ) {
            $_SESSION['vloga'] = ' ';
        }    
        if ( ! isset($_SESSION['uporabnik'] ) ) {
            $_SESSION['uporabnik'] = ' ';
        }  
        if ( ! isset($_SESSION['prijavljen'] ) ) {
            $_SESSION['uporabnik'] = FALSE;
        }  
        $jezik = 'slovenian';       
        $this->session->set_userdata('jezik',$jezik);       
        require_once ('jezik.php'); 
        $this->crd_rezervacije();
        redirect(site_url('sifranti/crd_izposoje'));   

    }
    
    function crd_koncaj() {  
        $jezik = 'slovenian';       
        $this->session->set_userdata('jezik',$jezik); 
        $_SESSION['vloga'] = "";    
        $_SESSION['uporabnik'] = "";
        $_SESSION['prijavljen'] = "FALSE";
        session_unset();
        exit();
    }    
    
    function crd_o_Izdelku() {
        $this->load->view('contact');
    }
    function crd_odjava() {
        $this->session->set_flashdata('uporabnik','NE');
        echo 'Lep Pozdrav!';
        $this->index();
    }
    
    function crd_izpis_ena()  {
        $this->msifranti->getIzpis_ena();
    }
   
    function crd_izpis_dva()  {
        $this->msifranti->getIzpis_dva();
    }

    function crd_izpis_tri()  {
      $this->msifranti->getIzpis_tri();  
    }
 
    function crd_izpis_stiri()  {
        $this->msifranti->getIzpis_stiri(); 
    }    
    
    function crd_izpis_pet()  {
        $this->msifranti->getIzpis_pet();
    }

    function crd_izpis_sest()  {
        $this->msifranti->getIzpis_sest();
    }

    function crd_izpis_sedem()  {
        $this->msifranti->getIzpis_sedem();
    }    
    
    function crd_izpis_osem()  {
        $this->msifranti->getIzpis_osem();
    }    
  
    function crd_izpis_devet()  {
        $this->msifranti->getIzpis_devet();
    }    
    
    function crd_izpis_deset()  {
        $this->msifranti->getIzpis_deset();
    }

    function crd_izpis_enajst()  {
        $this->msifranti->getIzpis_enajst();
    }
    
    function crd_podjetje() {      
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_table('podjetja');
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_subject('podjetja'); 
        $this->grocery_crud->columns('nazivpodjetja','oznakapodjetja','naslovpodjetja','idzaddv','id_poste');
        $this->grocery_crud->display_as('nazivpodjetja','Naziv');
        $this->grocery_crud->display_as('oznakapodjetja','Oznaka');
        $this->grocery_crud->display_as('naslovpodjetja','Naslov');
        $this->grocery_crud->display_as('idzaddv','DDV');
        $this->grocery_crud->display_as('id_poste','Pošta');        
        $this->grocery_crud->set_relation('id_poste','poste','id_poste'); 
        $this->grocery_crud->set_relation('id_poste','poste','{postnastevilka}, {kraj}');     
        $this->grocery_crud->set_subject('Podjetje');
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);   
        $this->grocery_crud->required_fields('id_poste','podjetjacol');
        $this->grocery_crud->set_rules('idzaddv', 'DDV','trim|required|xss_clean|callback_podjetje_check');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }  
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();
        $this->load->view('sifranti/crv_sifrant',$output);     
    }
    
    function podjetje_check($str) { 
        $this->db->where("idzaddv", $str);
        $queryp = $this->db->get('podjetja');
        $status = $this->grocery_crud->getState();
        $this->form_validation->set_message('podjetje_check', $status);
        if (( $queryp->num_rows() > 0) && ( $status == 'insert_validation' )) {
            $this->form_validation->set_message('podjetje_check', 'DDV številka '.$status.$str.' že obstaja!');
            return FALSE;
        }
        else  {
            return TRUE;
        }
    } 
    
    function crd_poste() {   
        $this->grocery_crud->limit(10);  
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('poste');
        $this->grocery_crud->columns('postnastevilka','kraj','id_drzave');
        $this->grocery_crud->display_as('postnastevilka','Številka pošte');
        $this->grocery_crud->display_as('kraj','Kraj pošte');
        $this->grocery_crud->display_as('id_drzave','Država');
        $this->grocery_crud->set_subject('poste');
        $this->grocery_crud->unset_delete();
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);
        $this->grocery_crud->set_subject('Posta');
        $this->grocery_crud->required_fields('id_drzave','postnastevilka');
        $this->grocery_crud->set_rules('postnastevilka', 'Številka pošte','trim|required|xss_clean|callback_poste_check');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add();           
        }        
        $output = $this->grocery_crud->render();
        $this->load->view('sifranti/crv_sifrant',$output);  
    }
    
    function poste_check($str) {
        $this->db->where("postnastevilka", $str);
        $queryp = $this->db->get('poste');
        $status = $this->grocery_crud->getState();
        if (( $queryp->num_rows() > 0) && ( $status == 'insert_validation' )) {
            $this->form_validation->set_message('poste_check', ' številka '.$str.' že obstaja!');
            return FALSE;
        }
        else  {
            return TRUE;
        }        
    } 
 
    function crd_osebe() {      
        $crud = new Grocery_CRUD(); 
        $crud->limit(10);
        $crud->set_theme('flexigrid');
        $crud->set_table('osebe');   
        $crud->columns('ime','priimek','datumrojstva','naslov','id_poste','uporabniskoime','geslo');
        $crud->display_as('ime','Ime');
        $crud->display_as('priimek','Priimek');
        $crud->display_as('datumrojstva','Dat.roj.');
        $crud->display_as('id_poste','Pošta');
        $crud->display_as('id_poste','Pošta');
        $crud->display_as('geslo','Geslo');
        $crud->display_as('uporabniskoime','Uporabnik');
        $crud->display_as('veljavnostvozniske','Vel.osb.izk.');
        $crud->display_as('elektronskaposta','E-mail');
        $crud->display_as('veljavnostosdok','Velj. dok.');
        $crud->display_as('stevilkavozniske','Št.voz.izk.');     
        $crud->set_subject('osebe');    
        $crud->set_relation('id_poste','poste','id_poste'); 
        $crud->set_relation('id_poste','poste','{postnastevilka}, {kraj}');  
        $crud->set_relation('id_podjetja','podjetja','id_podjetja'); 
        $crud->set_relation('id_podjetja','podjetja','{podjetjacol}, {nazivpodjetja}');   
        $jezik=$this->session->userdata('jezik');
        $crud->set_language($jezik);  
        $crud->set_subject('Oseba');   
        $crud->required_fields('id_poste','id_podjetja');  
        $this->session->set_flashdata('grid','crd_osebe');
        $crud->field_type('navaden','dropdown',array('1' => 'da', '2' => 'ne','3' => 'ostalo' ));              
        $crud->set_rules('stevilkaosebnegadok', 'Štev.osb.dok.','trim|required|xss_clean|callback_osbdok_check');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $crud->unset_edit();    
            $crud->unset_add(); 
            $crud->unset_delete();
        }  
        if ( $_SESSION['vloga'] == 'user' ) {
            $crud->unset_delete();
        } 
        $output = $crud->render();
        $this->load->view('sifranti/crv_sifrant',$output);        
    }
    
    function osbdok_check($str) {       
        $this->db->where("stevilkaosebnegadok",trim($str));
        $queryp1 = $this->db->get('osebe');
        $status = $this->grocery_crud->getState();
        if (( $queryp1->num_rows() > 0) && ( $status == 'insert_validation' )) {
         $this->form_validation->set_message('osbdok_check', 'Stevilka osbnega dokumenta '.$str.' že obstaja!');
            return FALSE;
        }
        else  {
            return TRUE;
        }
    }    
    
    function crd_osebe_izposoje() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('osebe_izposoje');
        
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);  
        $this->grocery_crud->set_subject('Izposoja');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        } 
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();       
        $this->load->view('sifranti/crv_sifrant',$output);     
    
    }
    
    function crd_osebe_vloge() {  
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('osebe_vloge');
        
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);
        $this->grocery_crud->set_subject('Vloga osebe');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        } 
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();        
        $this->load->view('sifranti/crv_sifrant',$output);     
    }
    
    function crd_vozila() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vozila');
        $this->grocery_crud->columns('znamka','oznakavozila','tipvozila','registrirando','registrska','id_osebe');
        $this->grocery_crud->display_as('znamka','Znamka vozila');
        $this->grocery_crud->display_as('oznakavozila','Oznaka vozila');
        $this->grocery_crud->display_as('registrirando','Registriran do');
        $this->grocery_crud->display_as('registrska','Registrska številka');
        $this->grocery_crud->display_as('id_osebe','Oseba');
        $this->grocery_crud->display_as('tipvozila','Tip vozila');
        $this->grocery_crud->set_subject('vozila');    
        
        $this->grocery_crud->set_relation('id_osebe','osebe','id_osebe'); 
        $this->grocery_crud->set_relation('id_osebe','osebe','{ime}  {priimek}, {naslov}');
         $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);  
        $this->grocery_crud->set_subject('Vozila');
        $this->grocery_crud->required_fields('id_osebe');
        $this->grocery_crud->set_rules('registrska', 'Registrska številka','trim|required|xss_clean|callback_vozila_check');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();
        $this->load->view('sifranti/crv_sifrant',$output);     

    }
    
    function vozila_check($str) { 
        $this->db->where("registrska", $str);
        $queryp1 = $this->db->get('vozila');
        $status = $this->grocery_crud->getState();
        if (( $queryp1->num_rows() > 0) && ( $status == 'insert_validation' )) {        
         $this->form_validation->set_message('vozila_check', 'Registrska št. '.$str.' že obstaja!');
            return FALSE;
        }
        else  {
            return TRUE;
        }
    }  
    
    function crd_vrste_stanj() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vrstestanj');
        
        $this->grocery_crud->columns('vrstastanja');
        $this->grocery_crud->display_as('vrstastanja','Vrsta stanja');
        $this->grocery_crud->set_subject('vrstestanj');
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);
        $this->grocery_crud->set_subject('Vrsta stanja');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();       
        $this->load->view('sifranti/crv_sifrant',$output);          
    }
       
    function crd_namen_porabe() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('nameniuporabe');   
        $this->grocery_crud->columns('namenuporabe','opisnamenauporabe');
        $this->grocery_crud->display_as('namenuporabe','Namen uporabe');        
        $this->grocery_crud->display_as('opisnamenauporabe','Opis uporabe');  
        $this->grocery_crud->set_subject('nameniuporabe');
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);
        $this->grocery_crud->set_subject('Namen uporabe');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();      
        $title = 'Pregled šifranta namena uporabe';
        $this->load->view('sifranti/crv_sifrant',$output);     
      
    }
 
    function crd_vloge_oseb() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vlogeoseb');
        $this->grocery_crud->columns('vlogaosebe','opisvlogeosebe');
        $this->grocery_crud->display_as('vlogaosebe','Vloga osebe');        
        $this->grocery_crud->display_as('opisvlogeosebe','Opis vloge');  
        $this->grocery_crud->set_subject('vlogeoseb');
         $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);   
        $this->grocery_crud->set_subject('Vloga osebe');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();
        $this->session->set_flashdata('grid','crd_vloge_oseb');
        $this->load->view('sifranti/crv_sifrant',$output);         
    }

  
    function crd_vloge() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vloge');
        $this->grocery_crud->columns('stevilkavloge','nazivvloge','opisvloge');
        $this->grocery_crud->display_as('stevilkavloge','Številka');        
        $this->grocery_crud->display_as('nazivvloge','Naziv');  
        $this->grocery_crud->display_as('opisvloge','Opis');  
        $this->grocery_crud->set_subject('vloge');
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);  
        $this->grocery_crud->set_subject('Vloga');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();
        $this->session->set_flashdata('grid','crd_vloge');
        $this->load->view('sifranti/crv_sifrant',$output);        
    }
 
    function crd_stanja() {
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('stanja');  
        $this->grocery_crud->columns('id_vrstestanj','km','gorivo','obveznaoprema','antena','servisnaknjiga');
        $this->grocery_crud->display_as('id_vrstestanj','Stanje vozila');        
        $this->grocery_crud->display_as('km','KM');  
        $this->grocery_crud->display_as('gorivo','Gorivo'); 
        $this->grocery_crud->field_type('gorivo','dropdown',array('1' => 'Bencin', '2' => 'Nafta','3' => 'Plin', '4' => 'Elektika' ));
        $this->grocery_crud->display_as('obveznaoprema','Obvezna oprema');         
        $this->grocery_crud->display_as('antena','Antena'); 
        $this->grocery_crud->display_as('servisnaknjiga','Servisna knjiga');  
        $this->grocery_crud->display_as('pregledanoob','Pregledan ob');
        $this->grocery_crud->display_as('drugo','Drugo');        
        $this->grocery_crud->display_as('cistoca','Čistoča');  
        $this->grocery_crud->display_as('preglednadanob','Pregled(DD.MM.ll:tt)'); 
        $this->grocery_crud->set_subject('stanja');        
        $this->grocery_crud->set_relation('id_vrstestanj','vrstestanj','id_vrstestanj'); 
        $this->grocery_crud->set_relation('id_vrstestanj','vrstestanj','vrstastanja'); 
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);  
        $this->grocery_crud->set_subject('Stanje');
        $this->grocery_crud->required_fields('id_vrstestanj');
        $this->grocery_crud->field_type('servisnaknjiga','dropdown',array('1' => 'da', '2' => 'ne','3' => 'odtujena' ));
        $this->grocery_crud->field_type('antena','dropdown',array('1' => 'da', '2' => 'ne'));
        $this->grocery_crud->field_type('okrasnipokrovi','dropdown',array('1' => 'da', '2' => 'ne'));
         $this->grocery_crud->field_type('obveznaoprema','dropdown',array('1' => 'da', '2' => 'ne'));
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete();
        }
        if ( $_SESSION['vloga'] == 'user' ) {
            $this->grocery_crud->unset_delete();
        } 
        $output = $this->grocery_crud->render();    
        $this->session->set_flashdata('grid','crd_stanja');
        $this->load->view('sifranti/crv_sifrant',$output);        
    }

    function crd_rezervacije() {
        $this->grocery_crud->limit(10);
        
        $this->grocery_crud->set_theme('flexigrid');
//        $this->grocery_crud->set_theme('twitter-bootstrap');
        $this->grocery_crud->set_table('rezervacije');
        $this->grocery_crud->columns('casod','casdo','id_osebe','id_vozila');
        $this->grocery_crud->display_as('casod','Čas prevzema');        
        $this->grocery_crud->display_as('casdo','Čas vrnitve');  
        $this->grocery_crud->display_as('id_osebe','Oseba');  
        $this->grocery_crud->display_as('id_vozila','Vozilo');        
        $this->grocery_crud->set_subject('rezervacije');        
        $this->grocery_crud->set_relation('id_vozila','vozila','id_vozila'); 
        $this->grocery_crud->set_relation('id_vozila','vozila','{znamka} {oznakavozila} {registrska}'); 
        $this->grocery_crud->set_relation('id_osebe','osebe','id_osebe'); 
        $this->grocery_crud->set_relation('id_osebe','osebe','{ime} {priimek}, {naslov}');
         $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);     
        $this->grocery_crud->required_fields('id_osebe','id_vozila');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('Rezervacija');
        $this->load->view('sifranti/crv_sifrant',$output);     
    }   
  
    function crd_izposoje() {
        $this->grocery_crud->limit(10);
//        $this->grocery_crud->set_theme('datatables');
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('izposoje');
        $this->grocery_crud->columns('izdan','vrnjen','stevilkapn','id_nameniuporabe','id_vozila');
        $this->grocery_crud->display_as('izdan','Izdan');        
        $this->grocery_crud->display_as('vrnjen','Vrnjen');  
        $this->grocery_crud->display_as('stevilkapn','Potni nalog št.');  
        $this->grocery_crud->display_as('id_nameniuporabe','Namen uporabe');    
        $this->grocery_crud->display_as('id_vozila','Vozilo'); 
        $this->grocery_crud->set_subject('izposoje');        
        $this->grocery_crud->set_relation('id_vozila','vozila','id_vozila'); 
        $this->grocery_crud->set_relation('id_vozila','vozila','{znamka} {oznakavozila} {registrska}'); 
        $this->grocery_crud->set_relation('id_nameniuporabe','nameniuporabe','id_nameniuporabe'); 
        $this->grocery_crud->set_relation('id_nameniuporabe','nameniuporabe','{namenuporabe} {opisnamenauporabe}');
        $jezik=$this->session->userdata('jezik');
        $this->grocery_crud->set_language($jezik);
        $this->grocery_crud->set_subject('Izposoja');
        $this->grocery_crud->required_fields('id_vozila','id_nameniuporabe');
        $this->grocery_crud->set_rules('stevilkapn', 'Potni nalog št.','trim|required|xss_clean|callback_izposoje_check');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add();  
            $this->grocery_crud->unset_delete();
        }     
        $output = $this->grocery_crud->render();           
        $this->load->view('sifranti/crv_sifrant',$output);  
        
    } 

    function izposoje_check($str) {       
        $this->db->where("stevilkapn",$str);
        $queryp2 = $this->db->get('izposoje');
        $status = $this->grocery_crud->getState();
        if (( $queryp2->num_rows() > 0) && ( $status == 'insert_validation' )) { 
         $this->form_validation->set_message('izposoje_check', 'Potni nalog št. '.$str.' že obstaja!');
            return FALSE;
        }
        else  {
            return TRUE;
        }
    }  
    
}

