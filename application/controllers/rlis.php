<?php
/* 
 * kontroler funkcij za različne prikaze šifrantov in vnosa potnih nalogov
 * Izdelal: Marko Novak
 * 
 */
class rlis extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        session_start();
        $status = session_status();
        if ( $status == PHP_SESSION_NONE ) {
            $_SESSION['podjetje'] = '';
            $_SESSION['oe'] = '';
            $_SESSION['uporabnik'] = '';    
            $_SESSION['vloga'] = '';
        }      
        //add here the class of the buttons you need to open links in a new window $(".YOUR_CLASS_NAME").attr("target", "_blank");
//            $crud->add_action('Preview','IMG_URL','','ui-icon-plus', array($this, 'preview_click'), '_blank'); klic liste iz gumba zapisa
        $timeout = 300; // 5 minute čaka na ukaz sicer odlogira

//        if(isset($_SESSION['timeout'])) {
//
//            $duration = time() - (int)$_SESSION['timeout'];
//            if($duration > $timeout) {
//                session_unset();
//                $_SESSION['prijavljen'] = "FALSE";
//                $_SESSION['vloga'] = "";    
//                $_SESSION['uporabnik'] = "";
//               $timeout = 300; //za ven
//            }
//        }
//        $_SESSION['timeout'] = time();        
    }


    public function index() {
       /* klic strani prijavnega gesla na začetku izvajanja oziroma prikaz pregledov */ 
        echo 'Zivjo!';
        
    }    
    
    function koncaj() {
        
        $_SESSION['podjetje'] = '';
        $_SESSION['oe'] = '';
        $_SESSION['uporabnik'] = '';
        session_unset();
        exit();
    }
    
    function pre_ddvtipp() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('ddvtipn');
        $this->grocery_crud->columns('ddvtipn_id','ddvtipn_sifra','ddvtipn_naziv','stsif_id','stsif_sifra','ddvtipn_opomba');
        $this->grocery_crud->display_as('ddvtipn_sifra','Šifra');        
        $this->grocery_crud->display_as('ddvtipn_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('ddvtipn_opomba','Opomba');        
        $this->grocery_crud->set_subject('ddvtipn');        
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('stsif_sifra');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('ddvtipn');
        $this->load->view('ddvsifranti/crv_osnsifrant',$output);     
    } 
        
    function pre_ddvtipn() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('ddvtipp');
        $this->grocery_crud->columns('ddvtipp_id','ddvtipp_sifra','ddvtipp_naziv','stsif_id','stsif_sifra','ddvtipp_opomba');
        $this->grocery_crud->display_as('ddvtipp_sifra','Šifra');        
        $this->grocery_crud->display_as('ddvtipp_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('ddvtipp_opomba','Opomba');        
        $this->grocery_crud->set_subject('ddvtipp');        
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('stsif_sifra');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('ddvtipp');
        $this->load->view('ddvsifranti/crv_osnsifrant',$output); 
    }
    
    function pre_delevec() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('delavec');
        $this->grocery_crud->columns('podjetje_id','podjetje_sifra','delavec_id','delavec_sifra','delavec_naziv','stsif_id','stsif_sifra','oe_id',
                                     'oe_sifra','strm_id','strm_sifra','delavec_rojen','delavec_ulica','delavec_kraj','posta_id','posta_sifra',
                                     'drzava_id','drzava_sifra','delavec_telefon','delavec_tr','delavec_ziroracun','vozilo_id','vozilo_naziv',
                                     'delavec_delnal','delavec_email','delavec_davstev','delavec_emso');       
        $this->grocery_crud->display_as('podjetje_sifra','Podjetje'); 
        $this->grocery_crud->display_as('delavec_sifra','Šifra'); 
        $this->grocery_crud->display_as('delavec_naziv','Ime in Priimek');         
        $this->grocery_crud->display_as('stsif_sifra','Status');         
        $this->grocery_crud->display_as('oe_sifra','OE'); 
        $this->grocery_crud->display_as('strm_sifra','STRM'); 
        $this->grocery_crud->display_as('delavec_rojen','Rojen'); 
        $this->grocery_crud->display_as('delavec_ulica','Ulica'); 
        $this->grocery_crud->display_as('delavec_kraj','Kraj'); 
        $this->grocery_crud->display_as('posta_sifra','Pošta'); 
        $this->grocery_crud->display_as('drzava_sifra','Država'); 
        $this->grocery_crud->display_as('delavec_telefon','Telefon'); 
        $this->grocery_crud->display_as('delavec_tr','TRR'); 
        $this->grocery_crud->display_as('delavec_ziroracun','Žiro račun'); 
        $this->grocery_crud->display_as('vozilo_naziv','Vozilo'); 
        $this->grocery_crud->display_as('delavec_delnal','Delovni nalog'); 
        $this->grocery_crud->display_as('delavec_email','e-naslov');         
        $this->grocery_crud->display_as('delavec_davstev','Davčna številka');         
        $this->grocery_crud->display_as('delavec_emso','emšo'); 
        $this->grocery_crud->set_subject('delavec'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','drzava_id'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','{drzava_sifra} {drzava_naziv}');   
        $this->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $this->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');   
        $this->grocery_crud->set_relation('posta_id','posta','posta_id'); 
        $this->grocery_crud->set_relation('posta_id','posta','{posta_sifra} {posta_naziv}');   
        $this->grocery_crud->set_relation('strm_id','strm','strm_id'); 
        $this->grocery_crud->set_relation('strm_id','strm','{strm_sifra} {strm_naziv}');   
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');   
        $this->grocery_crud->set_relation('vozilo_id','vozilo','vozilo_id'); 
        $this->grocery_crud->set_relation('vozilo_id','vozilo','{vozilo_sifra} {vozilo_naziv}');               
        $this->grocery_crud->required_fields('delavec_sifra','delavec_naziv','delavec_davstev');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('delavec');
        $this->load->view('splosnisifranti/crv_splosnisifrant',$output);         
        
    }
    
    function pre_drzava() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('drzava');
        $this->grocery_crud->columns('drzava_id','drzava_sifra','drzava_naziv','drzava_mednnaaziv','drzava_oznaka','valuta_id',
                                     'valuta_sifra','valuta_naziv','drzava_poststev','drzava_privzeto');
        $this->grocery_crud->display_as('drzava_sifra','Šifra');        
        $this->grocery_crud->display_as('drzava_naziv','Naziv');  
        $this->grocery_crud->display_as('drzava_mednnaziv','Mednarodni naziv');  
        $this->grocery_crud->display_as('drzava_oznaka','Oznaka');           
        $this->grocery_crud->display_as('valuta_sifra','Šifra valute');        
        $this->grocery_crud->display_as('valuta_naziv','Naziv valute');  
        $this->grocery_crud->display_as('drzava_poststev','poštna številka');  
        $this->grocery_crud->display_as('drzava_privzeto','Privzeta');         
        $this->grocery_crud->set_subject('drzava');        
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->set_relation('valuta_id','valuta','valuta_id'); 
        $this->grocery_crud->set_relation('valuta_id','valuta','{valuta_sifra} {valuta_naziv}');        
        $this->grocery_crud->required_fields('drzava_sifra');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('drzava');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);         
    }
    
    function pre_em() {

        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('em');
        $this->grocery_crud->columns('em_id','em_sifra','em_naziv','stsif_id','stsif_sifra','em_opomba');
        $this->grocery_crud->display_as('em_sifra','Šifra');        
        $this->grocery_crud->display_as('em_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('em_opomba','Opomba');               
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('em_sifra','em_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('em');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);        
        
    }
    
    function pre_mestop($param) {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('mestop');
        $this->grocery_crud->columns('podjetje_id','oe_id','mestop_id','mestop_sifra','mestop_naziv','stsif_id','stsif_sifra','mestop_privzeto','mestop_opomba');
        $this->grocery_crud->display_as('oe_sifra','Šifra OE');        
        $this->grocery_crud->display_as('mestop_sifra','Šifra '); 
        $this->grocery_crud->display_as('mestop_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('mestop_privzeto','Privzeto');         
        $this->grocery_crud->display_as('mestop_opomba','Opomba');               
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');         
        $this->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $this->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');    
        $this->grocery_crud->required_fields('mestop_sifra','mestop_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('mestop');
        $this->load->view('servisnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_obrobd() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('obrobd');
        $this->grocery_crud->columns('obrobd_id','obrobd_sifra','obrobd_naziv','stsif_id','stsif_sifra','obrobd_opomba');
        $this->grocery_crud->display_as('obrobd_sifra','Šifra');        
        $this->grocery_crud->display_as('obrobd_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('obrobd_opomba','Opomba');               
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('obrobd_sifra','obrobd_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('obrobd');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);      
        
    }
    
    function pre_oe() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('oe');
        $this->grocery_crud->columns('podjetje_id','podjetje_sifra','oe_sifra','oe_naziv','stsif_id','stsif_sifra','oe_priveto',
                                     'partnero_id','partnero_sifra','oe_matstev','oe_sifraivz');
        $this->grocery_crud->display_as('podjetje_sifra','Šifra podjetja');        
        $this->grocery_crud->display_as('oe_sifra','Šifra ');          
        $this->grocery_crud->display_as('oe_naziv','Naziv ');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('oe_privzeto','Privzeto');    
        $this->grocery_crud->display_as('partnero_sifra','Šifra partnerja');  
        $this->grocery_crud->display_as('oe_matstev','Matična številka');  
        $this->grocery_crud->display_as('oe_sifraivz','Šifra ivz');   
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}');         
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('oe_sifra','oe_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('eoe');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_podjetje() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('podjetje');
        $this->grocery_crud->columns('podjetje_id','podjetje_sifra','podjetje_naziv','podjetje_privzeto','stsif_id','stsif_sifra','podjetje_opomba');
        $this->grocery_crud->display_as('podjetje_sifra','Šifra');        
        $this->grocery_crud->display_as('podjetje_naziv','Naziv');  
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('podjetje_opomba','Opomba');   
        $this->grocery_crud->display_as('podjetje_privzeto','Privzeto');          
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->required_fields('podjetje_sifra');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('podjetje');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);           
        
    }
    
    function pre_posta() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('posta');
        $this->grocery_crud->columns('posta_id','posta_sifra','posta_naziv','regija_id','regija_sifra','drzava_id','drzava_sifra','stsif_id','stsif_sifra','posta_opomba');
        $this->grocery_crud->display_as('posta_sifra','Šifra pošte');        
        $this->grocery_crud->display_as('posta_naziv','Naziv');  
        $this->grocery_crud->display_as('regija_sifra','Regija');  
        $this->grocery_crud->display_as('posta_opomba','Opomba');   
        $this->grocery_crud->display_as('drzava_sifra','Država');          
        $this->grocery_crud->display_as('stsif_sifra','Status'); 
        $this->grocery_crud->display_as('posta_opomba','Opomba');        
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->set_relation('drzava_id','drzava','drzava_id'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','{drzava_sifra} {drzava_naziv}');           
        $this->grocery_crud->required_fields('posta_sifra', 'posta_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('posta');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);                    
        
    }
    
    function pre_projekt() {
                  
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('projekt');
        $this->grocery_crud->columns('projekt_id','projekt_sifra','projekt_naziv','podjetje_id','podjetje_sifra','oe_id','oe_sifra',
                                     'stsif_id','stsif_sifra','projekt_nazivk','projekt_opomba');
        $this->grocery_crud->display_as('projekt_sifra','Šifra');        
        $this->grocery_crud->display_as('projekt_naziv','Naziv');  
        $this->grocery_crud->display_as('podjetje_sifra','Podjetje');  
        $this->grocery_crud->display_as('posta_opomba','Opomba');   
        $this->grocery_crud->display_as('oe_sifra','Oe');          
        $this->grocery_crud->display_as('stsif_sifra','Status'); 
        $this->grocery_crud->display_as('projekt_opomba','Opomba');        
        $this->grocery_crud->display_as('projekt_nazivk','Naziv klienta');          
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');    
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}');           
        $this->grocery_crud->required_fields('projekt_sifra', 'projekt_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('projekt');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);        
    }
    
    function pre_regija() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('regija');
        $this->grocery_crud->columns('regija_id','regija_sifra','regija_naziv','drzava_id','drzava_sifra');
        $this->grocery_crud->display_as('regija_sifra','Šifra');        
        $this->grocery_crud->display_as('regija_naziv','Naziv');  
        $this->grocery_crud->display_as('drzava_sifra','Država');           
        $this->grocery_crud->set_relation('drzava_id','drzava','drzava_id'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','{drzava_sifra} {drzava_naziv}');    
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('regija');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_strdok() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('stdok');
        $this->grocery_crud->columns('stdok_id','stdok_sifra','podjetje_id','podjetje_sifra','stdok_leto','oe_id',
                                     'oe_sifra','vrsprom_id','vrsprom_sifra','mestop_id','mestop_sifra','stdok_stevec','stdok_kodadok');
        $this->grocery_crud->display_as('stdok_sifra','Šifra');        
        $this->grocery_crud->display_as('podjetje_sifra','Podjetje');  
        $this->grocery_crud->display_as('oe_sifra','Oe');  
        $this->grocery_crud->display_as('vrsprom_sifra','Vrsta prometa');   
        $this->grocery_crud->display_as('mestop_sifra','Mesto prometa');          
        $this->grocery_crud->display_as('stdok_leto','Leto');  
        $this->grocery_crud->display_as('stdok_stevec','Števec');   
        $this->grocery_crud->display_as('stdok_kodadok','Koda dokumenta');            
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}');    
        $this->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $this->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');   
        $this->grocery_crud->set_relation('vrsprom_id','vrsprom','vrsprom_id'); 
        $this->grocery_crud->set_relation('vrsprom_id','vrsprom','{vrsprom_sifra} {vrsprom_naziv}');   
        $this->grocery_crud->set_relation('mestop_id','mestop','mestop_id'); 
        $this->grocery_crud->set_relation('mestop_id','mestop','{mestop_sifra} {mestop_naziv}');           
        $this->grocery_crud->required_fields('stdok_sifra','stdok_leto','stdok_stevec','stdok_kodadok');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('stdok');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_strm() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('strm');
        $this->grocery_crud->columns('strm_id','strm_sifra','podjetje_id','podjetje_sifra','strm_naziv','oe_id',
                                     'oe_sifra','strm_privzeto','strm_opomba','stsif_id','stsif_sifra');
        $this->grocery_crud->display_as('strm_sifra','Šifra');        
        $this->grocery_crud->display_as('podjetj_sifra','Podjetje');  
        $this->grocery_crud->display_as('oe_sifra','Oe');  
        $this->grocery_crud->display_as('strm_naziv','Naziv');   
        $this->grocery_crud->display_as('strm_privzeto','Privzeto');          
        $this->grocery_crud->display_as('stsif_sifra','Status');  
        $this->grocery_crud->display_as('strm_opomba','Opomba');            
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}');    
        $this->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $this->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');   
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');   
         
        $this->grocery_crud->required_fields('strm_sifra','strm_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('strm');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);         
        
    }
    
    function pre_stsif() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('stsif');
        $this->grocery_crud->columns('stsif_id','stsif_sifra','stsif_naziv');
        $this->grocery_crud->display_as('stsif_sifra','Šifra');        
        $this->grocery_crud->display_as('stsif_naziv','Naziv');   
        $this->grocery_crud->required_fields('stsif_sifra','stsif_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('stsif');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_uporabnik() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('uporabnik');
        $this->grocery_crud->columns('uporabnik_id','uporabnik_sifra','uporabnik_prijava','uporabnik_geslo','uporabnik_polozaj',
                                     'uporabnik_opomba','uporabnik_privzeto','stsif_id','stsif_sifra','uporabnik_ime','uporabnik_postaja','uporabnik_geslou');
        $this->grocery_crud->display_as('uporabnik_sifra','Šifra');        
        $this->grocery_crud->display_as('uporabnik_prijava','Prijava');  
        $this->grocery_crud->display_as('uporabnik_geslo','Geslo');  
        $this->grocery_crud->display_as('uporabnik_opomba','Opomba');   
        $this->grocery_crud->display_as('uporabnik_privzeto','Privzeto');          
        $this->grocery_crud->display_as('stsif_sifra','Status'); 
        $this->grocery_crud->display_as('uporabnik_polozaj','Položaj');        
        $this->grocery_crud->display_as('uporabnik_ime','Ime');          
        $this->grocery_crud->display_as('uporabnik_postaja','postaja');  
        $this->grocery_crud->display_as('uporabnik_geslou','GesloU');         
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');            
        $this->grocery_crud->required_fields('uporabnik_sifra', 'uporabnik_naziv','uporabnik_postaja');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('uporabnik');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);           
        
    }
    
    function pre_valuta() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('valuta');
        $this->grocery_crud->columns('valuta_id','valuta_sifra','valuta_naziv','valuta_oznaka','valuta_decenote',
                                     'valuta_sif','stsif_id','stsif_sifra','drzava_id','drzava_sifra');
        $this->grocery_crud->display_as('valuta_sifra','Šifra');        
        $this->grocery_crud->display_as('valuta_naziv','Naziv');  
        $this->grocery_crud->display_as('valuta_oznaka','Oznaka');  
        $this->grocery_crud->display_as('valuta_decenote','Decim. enota');   
        $this->grocery_crud->display_as('valuta_sif','sif');          
        $this->grocery_crud->display_as('stsif_sifra','Status'); 
        $this->grocery_crud->display_as('drzava_sifra','Država');               
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');            
        $this->grocery_crud->set_relation('drzava_id','drzava','drzava_id'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','{drzava_sifra} {drzava_naziv}');          
        $this->grocery_crud->required_fields('valuta_sifra', 'valuta_naziv','valuta_oznaka');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('valuta');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);         
        
    }
    
    function pre_vozilo() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vozilo');
        $this->grocery_crud->columns('vozilo_id','vozilo_sifra','vozilo_znamka','vozilo_oznakavozila','vozilo_tipvozila',
                                     'vozilo_registrirando','vozilo_registrska','delavec_id','delavec_sifra');
        $this->grocery_crud->display_as('vozilo_sifra','Šifra');        
        $this->grocery_crud->display_as('vozilo_znamka','Znamka');  
        $this->grocery_crud->display_as('vozilo_oznakavozila','Oznaka');  
        $this->grocery_crud->display_as('vozilo_tipvozila','Tip');   
        $this->grocery_crud->display_as('vozilo_registrirando','Registrirano do');          
        $this->grocery_crud->display_as('vozilo_registrska','Registrska številka'); 
        $this->grocery_crud->display_as('delavec_sifra','Delavec');               
           
        $this->grocery_crud->set_relation('delavec_id','delavec','delavec_id'); 
        $this->grocery_crud->set_relation('delavec_id','delavec','{delavec_sifra} {delavec_naziv}');          
        $this->grocery_crud->required_fields('vozilo_sifra', 'vozilo_registrska','vozilo_znamka');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('vozilo');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);           
        
    }
    
    function pre_vrsdok() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vrsdok');
        $this->grocery_crud->columns('vrsdok_id','vrsdok_sifra','vrsdok_naziv','vrsdok_opis','vrsdok_privzeto',
                                     'vrsprom_id','vrsprom_sifra','stsif_id','stsif_sifra');
        $this->grocery_crud->display_as('vrsdok_sifra','Šifra');        
        $this->grocery_crud->display_as('vrsdok_naziv','Naziv');  
        $this->grocery_crud->display_as('vrsdok_opis','Opis');  
        $this->grocery_crud->display_as('vrsdok_privzeto','Privzeto');   
        $this->grocery_crud->display_as('vrsprom_sifra','Vrsta prometa');          
        $this->grocery_crud->display_as('stsif_sifra','Status');               
           
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');          
        $this->grocery_crud->set_relation('vrsprom_id','vrsprom','vrsprom_id'); 
        $this->grocery_crud->set_relation('vrsprom_id','vrsprom','{vrsprom_sifra} {vrsprom_naziv}');         
        $this->grocery_crud->required_fields('vrsdok_sifra', 'vrsdok_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('vrsdok');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);        
        
    }
    
    function pre_vrsprev() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vrsprev');
        $this->grocery_crud->columns('vrsprev_id','vrsprev_sifra','vrsprev_naziv','vrsprev_opomba','stsif_id','stsif_sifra');
        $this->grocery_crud->display_as('vrsprev_sifra','Šifra');        
        $this->grocery_crud->display_as('vrsprev_naziv','Naziv');  
        $this->grocery_crud->display_as('vrsprev_opomba','Opomba');           
        $this->grocery_crud->display_as('stsif_sifra','Status');               
           
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');                 
        $this->grocery_crud->required_fields('vrsprev_sifra', 'vrsprev_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('vrsprev');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);          
        
    }
    
    function pre_vrsprom() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('vrsprom');
        $this->grocery_crud->columns('vrsprom_id','vrsprom_sifra','vrsprom_naziv','vrsprom_strank','vrsprev_opomba','vrsprom_privzeto','stsif_id','stsif_sifra');
        $this->grocery_crud->display_as('vrsprom_sifra','Šifra');        
        $this->grocery_crud->display_as('vrsprom_naziv','Naziv');  
        $this->grocery_crud->display_as('vrsprev_opomba','Opomba');           
        $this->grocery_crud->display_as('stsif_sifra','Status');               
        $this->grocery_crud->display_as('vrsprev_strank','Stran knj.');           
        $this->grocery_crud->display_as('vrsprom_privzeto','Privzeto');        
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');                 
        $this->grocery_crud->required_fields('vrsprev_sifra', 'vrsprev_naziv');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('vrsprom');
        $this->load->view('splosnisifranti/crv_osnsifrant',$output);           
        
    }
    
    function pre_partnero() {
        
        $this->grocery_crud->limit(10);
        $this->grocery_crud->set_theme('flexigrid');
        $this->grocery_crud->set_table('partnero');
        $this->grocery_crud->columns('partnero_id','partnero_sifra','podjetje_id','podjetje_sifra','partnero_naziv','stsif_id','stsif_sifra','oe_id',
                                     'oe_sifra','valuta_id','valuta_sifra','partnero_nazivdod1','partnero_nazivdod2','partnero_ulica','partnero_kraj','posta_id','posta_sifra',
                                     'drzava_id','drzava_sifra','partnero_telefon1','partnero_telefon2','partnero_fax','partnero_email','ddvtipn_id','ddvtipn_naziv',
                                     'ddvtipp_id','ddvtipp_naziv','partnero_davstev','partnero_matstev','partnero_ziroracun','partnero_www','partnero_zavddv');       
        $this->grocery_crud->display_as('podjetje_sifra','Podjetje'); 
        $this->grocery_crud->display_as('partnero_sifra','Šifra'); 
        $this->grocery_crud->display_as('partnero_naziv','Ime in Priimek');         
        $this->grocery_crud->display_as('stsif_sifra','Status');         
        $this->grocery_crud->display_as('oe_sifra','Oe'); 
        $this->grocery_crud->display_as('valuta_sifra','Valuta'); 
        $this->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 1'); 
        $this->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 2'); 
        $this->grocery_crud->display_as('partnero_ulica','Ulica'); 
        $this->grocery_crud->display_as('partnero_kraj','Kraj');         
        $this->grocery_crud->display_as('posta_sifra','Pošta'); 
        $this->grocery_crud->display_as('drzava_sifra','Država'); 
        $this->grocery_crud->display_as('partnero_telefon1','Telefon 1'); 
        $this->grocery_crud->display_as('partnero_telefon2','Telefon 2');         
        $this->grocery_crud->display_as('partnero_fax','Fax'); 
        $this->grocery_crud->display_as('partnero_email','E-naslov');  
        $this->grocery_crud->display_as('ddvtipn_sifra','DDVtipn');         
        $this->grocery_crud->display_as('ddvtipp_sifra','DDVtipp');           
        $this->grocery_crud->display_as('partnero_davstev','Davčna številka'); 
        $this->grocery_crud->display_as('partnero_matstev','Matična številka'); 
        $this->grocery_crud->display_as('partnero_ziroracun','TRR'); 
        
        $this->grocery_crud->display_as('partnero_www','www');         
        $this->grocery_crud->display_as('partnero_zavddv','Zavezanec za DDV'); 
        $this->grocery_crud->set_subject('partnero');
        
        $this->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $this->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','stsif_id'); 
        $this->grocery_crud->set_relation('stsif_id','stsif','{stsif_sifra} {stsif_naziv}');  
        $this->grocery_crud->set_relation('drzava_id','drzava','drzava_id'); 
        $this->grocery_crud->set_relation('drzava_id','drzava','{drzava_sifra} {drzava_naziv}');  
        $this->grocery_crud->set_relation('posta_id','posta','posta_id'); 
        $this->grocery_crud->set_relation('posta_id','posta','{posta_sifra} {posta_naziv}');          
        $this->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $this->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');        
        $this->grocery_crud->set_relation('valuta_id','valuta','valuta_id'); 
        $this->grocery_crud->set_relation('valuta_id','valuta','{valuta_sifra} {valuta_naziv}');         
        $this->grocery_crud->set_relation('ddvtipn_id','ddvtipn','ddvtipn_id'); 
        $this->grocery_crud->set_relation('ddvtipn_id','ddvtipn','{ddvtipn_sifra} {ddvtipn_naziv}');   
        $this->grocery_crud->set_relation('ddvtipp_id','ddvtipp','ddvtipp_id'); 
        $this->grocery_crud->set_relation('ddvtipp_id','ddvtipp','{ddvtipp_sifra} {ddvtipp_naziv}');             
        $this->grocery_crud->required_fields('partnero_sifra','partnero_naziv','partnero_ulica');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $this->grocery_crud->unset_edit();    
            $this->grocery_crud->unset_add(); 
            $this->grocery_crud->unset_delete(); 
        }
        $output = $this->grocery_crud->render();    
        $this->grocery_crud->set_subject('partnero');
        $this->load->view('partnerjisifranti/crv_splosnisifrant',$output);          
        
    }
    
    function pre_png() {
        /*lista glave */
        $png = new grocery_CRUD();
        $png->grocery_crud->limit(10);
        $png->grocery_crud->set_theme('flexigrid');
        $png->grocery_crud->set_table('pnp');
        $png->grocery_crud->columns('partnero_id','partnero_sifra','podjetje_id','podjetje_sifra','partnero_naziv','stsif_id','stsif_sifra','oe_id',
                                     'oe_sifra','valuta_id','valuta_sifra','partnero_nazivdod1','partnero_nazivdod2','partnero_ulica','partnero_kraj','posta_id','posta_sifra',
                                     'drzava_id','drzava_sifra','partnero_telefon1','partnero_telefon2','partnero_fax','partnero_email','ddvtipn_id','ddvtipn_naziv',
                                     'ddvtipp_id','ddvtipp_naziv','partnero_davstev','partnero_matstev','partnero_ziroracun','partnero_www','partnero_zavddv');       
        $png->grocery_crud->display_as('podjetje_sifra','Podjetje'); 
        $png->grocery_crud->display_as('partnero_sifra','Šifra'); 
        $png->grocery_crud->display_as('partnero_naziv','Ime in Priimek');         
        $png->grocery_crud->display_as('stsif_sifra','Status');         
        $png->grocery_crud->display_as('oe_sifra','Oe'); 
        $png->grocery_crud->display_as('valuta_sifra','Valuta'); 
        $png->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 1'); 
        $png->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 2'); 
        $png->grocery_crud->display_as('partnero_ulica','Ulica'); 
        $png->grocery_crud->display_as('partnero_kraj','Kraj');         
        $png->grocery_crud->display_as('posta_sifra','Pošta'); 
        $png->grocery_crud->display_as('drzava_sifra','Država'); 
        $png->grocery_crud->display_as('partnero_telefon1','Telefon 1'); 
        $png->grocery_crud->display_as('partnero_telefon2','Telefon 2');         
        $png->grocery_crud->display_as('partnero_fax','Fax'); 
        $png->grocery_crud->display_as('partnero_email','E-naslov');  
        $png->grocery_crud->display_as('ddvtipn_sifra','DDVtipn');         
        $png->grocery_crud->display_as('ddvtipp_sifra','DDVtipp');           
        $png->grocery_crud->display_as('partnero_davstev','Davčna številka'); 
        $png->grocery_crud->display_as('partnero_matstev','Matična številka'); 
        $png->grocery_crud->display_as('partnero_ziroracun','TRR'); 
        $png->grocery_crud->display_as('partnero_www','www');         
        $png->grocery_crud->display_as('partnero_zavddv','Zavezanec za DDV'); 
        $png->grocery_crud->set_subject('partnero');      
        $png->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $png->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}'); 
        $png->grocery_crud->set_relation('strm_id','strm','strm_id'); 
        $png->grocery_crud->set_relation('strm_id','strm','{strm_sifra} {strm_naziv}');  
        $png->grocery_crud->set_relation('obrobd_id','obrobd','obrobd_id'); 
        $png->grocery_crud->set_relation('obrobd_id','obrobd','{obrobd_sifra} {obrobd_naziv}');  
        $png->grocery_crud->set_relation('uporabnik_id','uporabnik','uporabnik_id'); 
        $png->grocery_crud->set_relation('uporabnik_id','uporabnik','{uporabnik_sifra} {uporabnik_naziv}');          
        $png->grocery_crud->set_relation('vrsdok_id','vrsdok','vrsdok_id'); 
        $png->grocery_crud->set_relation('vrsdok_id','vrsdok','{vrsdok_sifra} {vrsdok_naziv}');        
        $png->grocery_crud->set_relation('vrsprom_id','vrsprom','vrsprom_id'); 
        $png->grocery_crud->set_relation('vrsprom_id','vrsprom','{vrsprom_sifra} {vrsprom_naziv}');         
        $png->grocery_crud->set_relation('mestop_id','mestop','mestop_id'); 
        $png->grocery_crud->set_relation('mestop_id','mestop','{mestop_sifra} {mestop_naziv}');   
        $png->grocery_crud->set_relation('partnero_id','partnero','partnero_id'); 
        $png->grocery_crud->set_relation('partnero_id','partnero','{partnero_sifra} {partnero_naziv}');             
        $png->grocery_crud->set_relation('delavec_id','delavec','delavec_id'); 
        $png->grocery_crud->set_relation('delavec_id','delavec','{delavec_sifra} {delavec_naziv}'); 
        $png->grocery_crud->set_relation('projekt_id','projekt','projekt_id'); 
        $png->grocery_crud->set_relation('projekt_id','projekt','{projekt_sifra} {projekt_naziv}'); 
        $png->grocery_crud->set_relation('vrsprev_id','vrsprev','vrsprev_id'); 
        $png->grocery_crud->set_relation('vrsprev_id','vrsprev','{vrsprev_sifra} {vrsprev_naziv}'); 
        $png->grocery_crud->set_relation('vozilo_id','vozilo','vozilo_id'); 
        $png->grocery_crud->set_relation('vozilo_id','partnero','{vozilo_sifra} {vozilo_naziv}');         
        $png->grocery_crud->required_fields('png_dokument','png_zapstdok','stdok_leto');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $png->grocery_crud->unset_edit();    
            $png->grocery_crud->unset_add(); 
            $png->grocery_crud->unset_delete(); 
        }
        //$output = $png->grocery_crud->render();    
        $pnp->grocery_crud->set_subject('png');
        $pnp->load->view('nalogisifranti/crv_prepng',$output);          
        /* lista zaspisi */
        $pnp->grocery_crud->limit(10);
        $pnp->grocery_crud->set_theme('flexigrid');
        $pnp->grocery_crud->set_table('pnp');
        $pnp->grocery_crud->columns('pnp_id','podjetje_id','podjetje_sifra','stsif_id','stsif_sifra','oe_id',
                                     'oe_sifra','valuta_id','valuta_sifra','partnero_nazivdod1','partnero_nazivdod2',
                                     'partnero_ulica','partnero_kraj','posta_id','posta_sifra','drzava_id',
                                     'drzava_sifra','partnero_telefon1','partnero_telefon2','partnero_fax',
                                     'partnero_email','ddvtipn_id','ddvtipn_naziv','ddvtipp_id','ddvtipp_naziv',
                                     'partnero_davstev','partnero_matstev','partnero_ziroracun','partnero_www','partnero_zavddv');       
        $pnp->grocery_crud->display_as('podjetje_sifra','Podjetje'); 
        $pnp->grocery_crud->display_as('partnero_sifra','Šifra'); 
        $pnp->grocery_crud->display_as('partnero_naziv','Ime in Priimek');         
        $pnp->grocery_crud->display_as('stsif_sifra','Status');         
        $pnp->grocery_crud->display_as('oe_sifra','Oe'); 
        $pnp->grocery_crud->display_as('valuta_sifra','Valuta'); 
        $pnp->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 1'); 
        $pnp->grocery_crud->display_as('partnero_nazivdod1','Dodatni naziv 2'); 
        $pnp->grocery_crud->display_as('partnero_ulica','Ulica'); 
        $pnp->grocery_crud->display_as('partnero_kraj','Kraj');         
        $pnp->grocery_crud->display_as('posta_sifra','Pošta'); 
        $pnp->grocery_crud->display_as('drzava_sifra','Država'); 
        $pnp->grocery_crud->display_as('partnero_telefon1','Telefon 1'); 
        $pnp->grocery_crud->display_as('partnero_telefon2','Telefon 2');         
        $pnp->grocery_crud->display_as('partnero_fax','Fax'); 
        $pnp->grocery_crud->display_as('partnero_email','E-naslov');  
        $pnp->grocery_crud->display_as('ddvtipn_sifra','DDVtipn');         
        $pnp->grocery_crud->display_as('ddvtipp_sifra','DDVtipp');           
        $pnp->grocery_crud->display_as('partnero_davstev','Davčna številka'); 
        $pnp->grocery_crud->display_as('partnero_matstev','Matična številka'); 
        $pnp->grocery_crud->display_as('partnero_ziroracun','TRR');        
        $pnp->grocery_crud->display_as('partnero_www','www');         
        $pnp->grocery_crud->display_as('partnero_zavddv','Zavezanec za DDV'); 
        $pnp->grocery_crud->set_subject('pnp');      
        $pnp->grocery_crud->set_relation('podjetje_id','podjetje','podjetje_id'); 
        $pnp->grocery_crud->set_relation('podjetje_id','podjetje','{podjetje_sifra} {podjetje_naziv}'); 
        $pnp->grocery_crud->set_relation('oe_id','oe','oe_id'); 
        $pnp->grocery_crud->set_relation('oe_id','oe','{oe_sifra} {oe_naziv}');  
        $pnp->grocery_crud->set_relation('vrsprom_id','vrsprom','vrsprom_id'); 
        $pnp->grocery_crud->set_relation('vrsprom_id','vrsprom','{vrsprom_sifra} {vrsprom_naziv}');
        $pnp->grocery_crud->set_relation('mestop_id','mestop','mestop_id'); 
        $pnp->grocery_crud->set_relation('mestop_id','mestop','{mestop_sifra} {mestop_naziv}'); 
        $pnp->grocery_crud->set_relation('png_id','png','png_id'); 
        $pnp->grocery_crud->set_relation('png_id','png','{png_id} {png_dokument}');
        $pnp->grocery_crud->set_relation('em_id','em','em_id'); 
        $pnp->grocery_crud->set_relation('em_id','em','{em_id} {em_naziv}');        
        $pnp->grocery_crud->set_relation('uporabnik_id','uporabnik','uporabnik_id'); 
        $pnp->grocery_crud->set_relation('uporabnik_id','uporabnik','{uporabnik_sifra} {uporabnik_naziv}');        
        $pnp->grocery_crud->set_relation('strm_id','strm','strm_id'); 
        $pnp->grocery_crud->set_relation('strm_id','strm','{strm_sifra} {strm_naziv}');         
        $pnp->grocery_crud->required_fields('pnp_dokument','pnp_zapstdok','stdok_leto');
        if ( $_SESSION['vloga'] == 'tester' ) {
            $pnp->grocery_crud->unset_edit();    
            $pnp->grocery_crud->unset_add(); 
            $pnp->grocery_crud->unset_delete(); 
        }
        $pnp->chain_to($png, 'png_id');
        $output = $png->render();    

        $this->load->view('nalogisifranti/crv_prepnp',$output);        

        
    }
    
}

