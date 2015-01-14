<!DOCTYPE html>
<html>  
<head>  
    <meta  http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Potni nalogi</title>	 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />	
    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">   
    <link rel="icon" href="<?php echo base_url('application/images/parrot.jpg'); ?>" type="image/jpg">    
    <?php require_once 'funkcije_izpisi.html'; ?>   
    <?php foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
        <?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <?Php require_once 'jezik.php'; ?>

    <script src="<?php echo base_url();?>js/bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/style.js" type="text/javascript"></script>
</head>
<body background="<?php echo base_url('application/images/ozadje.jpg'); ?> " >
    <div class="row container "> 
        <div  id="headers">		
            <div class="panel panel-primary " id="panprim">
                <ul class="pager">
                    <div class="col-xs-6 col-md-6">
                        <li class="pagerlih"><img  src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="40"> </li>
                        <li><h3 class="pagerlig">Nalogi</h3></li>
                    </div>                    
                    <div class="col-xs-6 col-md-6">
                    <li class="pagerlif"><a href='<?php $_SESSION['pot'] = current_url(); echo site_url('sifranti/crd_ger')?>'><img src="<?php echo base_url('application/images/german.jpg'); ?>" alt="Nemsko" width="25"></a></li>                    
                    <li class="pagerlif"><a href='<?php $_SESSION['pot'] = current_url(); echo site_url('sifranti/crd_ang');?>'><img src="<?php echo base_url('application/images/english.jpg'); ?>" alt="Anglesko" width="25"></a></li> 
                    <li class="pagerlif"><a href='<?php echo site_url('sifranti/crd_slo')?>'><img src="<?php echo base_url('application/images/slo.jpg'); ?>" alt="Slovensko" width="25"></a></li>
                    </div>
                </ul>        
            <div class="panel-heading" id="panhed">
                <div class="navigation" id="navig" >  
                    <div class="panel-body" id="panb">
                        <ul class="nav nav-pills " id="navpis">
                            <li><a href='<?php echo site_url('sifranti/crd_izposoje')?>'><?php echo $domov;?></a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $Sifranti;?><span class="caret"></span></a>
                                <ul class="dropdown-menu" >
                                    <li><a  href='<?php echo site_url('sifranti/crd_podjetje')?>'><?php echo $UrejanjePodjetja;?></a></li>
                                    <li><a href='<?php echo site_url('sifranti/crd_poste')?>'><?php echo $UrejanjePost;?></a></li>
                                    <li class="divider"></li>
                                    <li><a href='<?php echo site_url('sifranti/crd_osebe')?>'><?php echo $UrejanjeOsebe;?></a></li>
                                    <li><a href='<?php echo site_url('sifranti/crd_vozila')?>'><?php echo $UrejanjeVozila;?></a></li>                                                                                    
                                    <li><a href='<?php echo site_url('sifranti/crd_vrste_stanj')?>'><?php echo $UrejanjeVrsteStanj;?></a></li>  
                                    <li><a href='<?php echo site_url('sifranti/crd_namen_porabe')?>'><?php echo $UrejanjeNamenauporabe;?></a></li>
                                    <li class="divider"></li>
                                    <li><a href='<?php echo site_url('sifranti/crd_vloge_oseb')?>'><?php echo $UrejanjevlogeOseb;?></a></li>  
                                    <li><a href='<?php echo site_url('sifranti/crd_vloge')?>'><?php echo $Urejanjevloge;?></a></li> 
                                    <li class="divider"></li>
                                    <li><a href='<?php echo site_url('sifranti/crd_stanja')?>'><?php echo $Stanja;?></a></li>
                                </ul>
                            </li>
                            <li><a href='<?php echo site_url('sifranti/crd_izposoje')?>'><?php echo $Nalogi;?></a></li>
                            <li><a href='<?php echo site_url('sifranti/crd_rezervacije')?>'><?php echo $Rezervacije;?></a></li>
                            <li class="dropdown" id="dropdli">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $Servis;?><span class="caret"></span></a>
                                    <ul class="dropdown-menu" >
                                        <li><a class="btn-lg" data-toggle="modal" data-target="#myModal"><?php echo $OIzdelku;?></a></li>
                                        <li><a class="btn-lg" data-toggle="modal" data-target="#myModal2"><?php echo $Kontakt;?></a></li>
                                        <li class="divider"></li>
                                        <li><a id="logi" class="btn-lg" data-toggle="modal" data-target="#Logprijava"><?php echo $Prijava;?></a></li>
                                        <li><a class="btn-lg" data-toggle="modal" data-target="#myModal3"><?php echo $Odjava;?></a></li>
                                        <li class="divider"></li>
                                        <li><a href='<?php echo site_url('sifranti/crd_koncaj')?>'><?php echo $Koncaj;?></a></li>                                        
                                    </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $Izpisi;?><span class="caret"></span></a>
                                    <ul class="dropdown-menu" >
                                        <li><a onclick="$('#myModal4').modal('show')"><?php echo $Izpis1;?></a></li></>
                                        <li><a onclick="$('#myModal5').modal('show')"><?php echo $Izpis2;?></a></li>
                                        <li><a onclick="$('#myModal6').modal('show')"><?php echo $Izpis3;?></a></li>                                   
                                        <li class="divider"></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_stiri')?>' > <?php echo $Izpis4;?></a></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_pet')?>' ><?php echo $Izpis5;?></a></li>
                                        <li class="divider"></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_sest')?>'><?php echo $Izpis6;?></a></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_sedem')?>'><?php echo $Izpis7;?></a></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_osem')?>'><?php echo $Izpis8;?></a></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_devet')?>'><?php echo $Izpis9;?></a></li>
                                        <li class="divider"></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_deset')?>'><?php echo $Izpis10;?></a></li>
                                        <li><a target='_blank' href='<?php echo site_url('sifranti/crd_izpis_enajst')?>'><?php echo $Izpis11;?></a></li>
                                    </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div> 
                <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100">
                            <span class="modal-title" id="myModalLabel" ><?php echo $OIzdelku;?> </span>
                        </div>
                        <div class="modal-body">
                            <span class="spanmb"><?php echo $Opis2;?></span> 
                            <br>
                            <br>
                            <p><?php echo $Opis3;?></p>
                            <p><?php echo $Opis4;?></p>
                            <br>
                            <br>
                            <p><?php echo $Opis5;?></p>
                         </div>
                        <div class="modal-footer">
                            <span class="spanmf"><?php echo $Opis6;?></span>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Zapri;?></button>
                        </div>
                        </div>
                    </div>
                </div>
              <!-- Modal end-->	          
                <!-- Modal prijava -->
                <div class="modal fade in" id="Logprijava" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100">
                            <span class="modal-title" id="myModalLabel" ><?php echo $Prijava;?></span>
                        </div>
                        <div class="modal-body">
                            <form  method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputuporabnik" class="col-sm-3 control-label">Uporabnik</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="prijavauporabnik" placeholder="uporabniško ime" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputgeslo" class="col-sm-3 control-label">Geslo</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name="prijavageslo" placeholder="geslo" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-10">
                                        <button  type="submit" value="SUBMIT" class="btn"><?php echo $Opis8;?></button>
                                    </div>
                                </div>
                                <?php    
                                    if ( isset($_POST['prijavauporabnik']) ) {    
                                        $_SESSION['prijavljen'] = "FALSE";
                                        $uporabnik = $_POST['prijavauporabnik'];
                                        $geslo = $_POST['prijavageslo'];
                                        $array = array('uporabnik' => $uporabnik, 'geslo' => $geslo);
                                        $this->db->where($array); 
                                        $query = $this->db->get('prijava');
                                        if ($query->num_rows() > 0) {
                                            $data_prijava = $query->result("array");
                                            $_SESSION['vloga'] = $data_prijava[0]['opomba'];
                                            $_SESSION['uporabnik'] = $data_prijava[0]['uporabnik'];
                                            $_SESSION['prijavljen'] = "TRUE";
//                                            $_SESSION['timeout'] = time();
//                                            $st = $_SESSION['timeout'] + 60; //session time is 1 minute
                                            $_SESSION['pot'] = current_url();
                                            header("Refresh:0");
                                        }  
                                        else {
                                            $_SESSION['prijavljen'] = "FALSE";
                                        }                            
                                    }       
                                ?>  
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Zapri;?></button>
                        </div>
                        </div>
                    </div>
                </div>
              <!-- Modal prijava end-->	
                <!-- Modal odjava -->
                <div class="modal fade in" id="myModal3" tabindex="-3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100" height="auto">
                            <span class="modal-title" id="myModalLabel" ><?php echo $Odjava;?></span>
                        </div>
                        <div class="modal-body">
                            <form  method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputuporabnik" class="col-sm-3 control-label">Uporabnik</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="odjavauporabnik" id="odjavauporabnik" placeholder="<?php echo $_SESSION['uporabnik'];?>" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputgeslo" class="col-sm-3 control-label">Geslo</label>
                                    <div class="col-sm-4">
                                        <input type="password" class="form-control" name="odjavageslo" id="odjavageslo" placeholder="geslo" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-10">
                                        <button  type="submit" value="SUBMIT1" class="btn" ><?php echo $Opis9;?></button>
                                    </div>
                                </div>
                                <?php       
                                    if ( isset( $_POST['odjavauporabnik'] ) ) { 
                                        $_SESSION['prijavljen'] = "TRUE";
                                        $uporabnik1 = $_POST['odjavauporabnik'];
                                        $geslo1 = $_POST['odjavageslo'];
                                        $array1 = array('uporabnik' => $uporabnik1, 'geslo' => $geslo1);
                                        $this->db->where($array1); 
                                        $query1 = $this->db->get('prijava');                                       
                                        if ($query1->num_rows() > 0) {
                                            $_SESSION['prijavljen'] = "FALSE";
                                            $_SESSION['vloga'] = "";    
                                            $_SESSION['uporabnik'] = "";
                                        } 
                                        else {
                                            $_SESSION['prijavljen'] = "TRUE";                               
                                        }                               
                                    }             
                                ?>            
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Zapri;?></button>
                        </div>
                        </div>
                    </div>
                </div>
              <!-- Modal odjava end-->	
                <!-- Modal kontakt -->
                <div class="modal fade in" id="myModal2"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100" height="auto">
                            <span class="modal-title" id="myModalLabel" ><?php echo $Kontakt;?></span>
                        </div>
                        <div class="modal-body">
                            <form  method="POST" class="form-horizontal" action="#">
                                <div class="form-group">
                                    <label for="inputimepriimek" class="col-sm-3 control-label">Ime in priimek:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="kontaktimepriimek" name="kontaktimepriimek" placeholder="ime in priimek" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputemail" class="col-sm-3 control-label">Email:</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="kontaktemail" name="kontaktemail" placeholder="elektronski naslov" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputsporocilo" class="col-sm-3 control-label">Sporočilo:</label>
                                    <div class=" col-sm-8">
                                        <input type="text" class="form-control" id="kontaktsporocilo" name="kontaktsporocilo" placeholder="sporočilo" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-4 ">
                                        <button  type="submit"  value="SUBMIT" class="btn" ><?php echo $Opis7;?></button>
                                    </div>
                                </div>
                                 <?php     
                                    if ( isset( $_POST['kontaktimepriimek']) ) {
                                        $imeinpriimek =  $_POST['kontaktimepriimek'];                 
                                        $email =  $_POST['kontaktemail']; 
                                        $sporocilo = $_POST['kontaktsporocilo'];
                                        $podatki = array(
                                            'imepriimek' => $imeinpriimek,
                                            'email' => $email,
                                            'sporocilo' => $sporocilo
                                        );    
                                        $this->db->insert('sporocila', $podatki); 
                                    }                        
                                ?>           
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Zapri;?></button>
                        </div>
                        </div>
                    </div>
                </div>
              <!-- Modal kontakt end-->	 
                <!-- Modal izbira myModal4" -->
                <div class="modal fade in" id="myModal4" tabindex="-4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100" height="auto">
                            <span class="modal-title" id="myModalLabel" >Filter izpisa</span>
                        </div>
                        <div class="modal-body">
                            <form  method="POST"  class="form-horizontal" role="panel" >
                                <div class="form-group">
                                    <label for="inputstnaloga" class="col-sm-3 control-label">Številka naloga:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="inputstnaloga" name="stnaloga">
                                             <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select a.stevilkapn as stevilkapn, a.izdan from izposoje a order by a.stevilkapn");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['stevilkapn'].'">'.$naldata['stevilkapn'].'</option>  ';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputnamen" class="col-sm-3 control-label">Namen:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="inputnameni" name="namen">
                                                <option>Izberi..</option>
                                                    <?php
                                                    $data = mysql_query("select id_nameniuporabe, opisnamenauporabe FROM  nameniuporabe  order by id_nameniuporabe;");
                                                    while($naldata = mysql_fetch_array( $data )) { 
                                                    echo '<option value="'.$naldata['id_nameniuporabe'].'">'.$naldata['id_nameniuporabe'].' '.$naldata['opisnamenauporabe'].'</option>  ';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputvozilo" class="col-sm-3 control-label">Vozilo:</label>
                                        <div class=" col-sm-8">
                                            <select class="form-control" id="inputvozilo" name="vozilo">
                                                <option>Izberi..</option>
                                                    <?php
                                                    $data = mysql_query("select id_vozila, znamka, registrska FROM  vozila  order by id_vozila");
                                                    while($naldata = mysql_fetch_array( $data )) { 
                                                    echo '<option value="'.$naldata['id_vozila'].'">'.$naldata['id_vozila'].' '.$naldata['znamka'].$naldata['registrska'].'</option>  ';
                                                    }
                                                    ?>
                                            </select>
                                        </div>  
                                </div>
                                <div class="form-group">
                                    <label for="inputvrnjen" class="col-sm-3 control-label">Vrnjen:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="inputvrnjen" name="vrnjen">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select distinct DATE_FORMAT(a.vrnjen,'%d.%m.%Y %h:%i') as vrnjen from izposoje a order by a.vrnjen;");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['vrnjen'].'">'.$naldata['vrnjen'].'</option>  ';
                                                }
                                                ?>
                                            </select>                      
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputizdan" class="col-sm-3 control-label">Izdan:</label>
                                        <div class=" col-sm-4">
                                            <select class="form-control" id="inputizdan" name="izdan">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select distinct DATE_FORMAT(a.izdan,'%d.%m.%Y %h:%i') as izdan from izposoje a order by a.izdan;");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['izdan'].'">'.$naldata['izdan'].'</option>  ';
                                                }
                                                ?>
                                            </select>                              
                                        </div>
                                </div>                        
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-4" >
                                        <button  type="submit" onclick="izpisilisto()" value="Reset" name="reset" class="btn btn-default"><?php echo $Izpisprn;?> </button>           
                                    </div>
                                </div>
                            </form>                       
                        </div>
                            <div class="modal-footer">
                                <button type="button" onclick="cistifilter()" class="btn btn-default"><?php echo $Cistifilter;?></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel;?></button>
                            </div>                    
                        </div>
                    </div>
                </div>
              <!-- Modal izbira myModal4" end-->              
               <!-- Modal filter izbira za listo end-->	
                <!-- Modal izbira myModal5" -->
                <div class="modal fade in" id="myModal5" tabindex="-4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100" height="auto">
                            <span  class="modal-title" id="myModalLabel" >Filter izpisa</span>
                        </div>
                            <div class="modal-body">
                                <form  method="POST"  class="form-horizontal" role="panel">
                                    <div class="form-group">
                                        <label for="inputnamen" class="col-sm-3 control-label">Oseba:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="inputoseba" name="oseba">
                                                <option>Izberi..</option>
                                                    <?php
                                                    $data = mysql_query("select id_osebe, ime, priimek, naslov FROM  osebe  order by id_osebe;");
                                                    while($naldata = mysql_fetch_array( $data )) { 
                                                    echo '<option value="'.$naldata['id_osebe'].'">'.$naldata['id_osebe'].' '.$naldata['ime'].' '.$naldata['priimek'].' '.$naldata['naslov'].'</option>  ';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputvozilo" class="col-sm-3 control-label">Vozilo:</label>
                                        <div class=" col-sm-8">
                                            <select class="form-control" id="inputvozilo1" name="vozilo1">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select id_vozila, znamka, registrska FROM  vozila  order by id_vozila");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['id_vozila'].'">'.$naldata['id_vozila'].' '.$naldata['znamka'].$naldata['registrska'].'</option>  ';
                                                }
                                                ?>
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="form-group">
                                        <label for="inputvrnjen" class="col-sm-3 control-label">Prevzet:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="inputprevzet" name="prevzet">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select distinct DATE_FORMAT(a.casod,'%d.%m.%Y %h:%i') as prevzet from rezervacije a order by a.casod;");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['prevzet'].'">'.$naldata['prevzet'].'</option>  ';
                                                }
                                                ?>
                                                </select>                      
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputizdan" class="col-sm-3 control-label">Vrnitev:</label>
                                            <div class=" col-sm-4">
                                                <select class="form-control" id="inputvrnitev" name="vrnitev">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select distinct DATE_FORMAT(a.casdo,'%d.%m.%Y %h:%i') as vrnitev from rezervacije a order by a.casdo;");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['vrnitev'].'">'.$naldata['vrnitev'].'</option>  ';
                                                }
                                                ?>
                                            </select>                              
                                            </div>
                                    </div>                        
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-4" >
                                            <button  type="submit" onclick="izpisilisto_ena()" value="Reset1" name="reset1" class="btn btn-default"><?php echo $Izpisprn;?> </button>           
                                        </div>
                                    </div>
                                </form>                       
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="cistifilter_ena()" class="btn btn-default"><?php echo $Cistifilter;?></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel;?></button>
                            </div>                    
                        </div>
                    </div>
                </div>
              <!-- Modal izbira myModal5" end-->     
                <!-- Modal izbira myModal6" -->
                <div class="modal fade in" id="myModal6" tabindex="-4" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img class="img_style" src="<?php echo base_url('application/images/parrot.jpg'); ?>" alt="kocka" width="100" height="auto">
                            <span  class="modal-title" id="myModalLabel" >Filter izpisa</span>
                        </div>
                        <div class="modal-body">
                            <form  method="POST"  class="form-horizontal" role="panel" >
                                <div class="form-group">
                                    <label for="inputvozilo" class="col-sm-3 control-label">Stanje:</label>
                                        <div class=" col-sm-8">
                                            <select class="form-control" id="inputstanje" name="stanje">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select id_vrstestanj, vrstastanja FROM  vrstestanj  order by id_vrstestanj");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['vrstastanja'].'">'.$naldata['vrstastanja'].'</option>  ';
                                                }
                                                ?>
                                            </select>
                                        </div>  
                                </div>
                                <div class="form-group">
                                    <label for="inputvrnjen" class="col-sm-3 control-label">Gorivo:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="inputgorivo" name="gorivo">
                                            <option>Izberi..</option>
                                            <?php
                                            $data = mysql_query("select distinct gorivo from stanja a order by gorivo;");
                                            while($naldata = mysql_fetch_array( $data )) { 
                                            echo '<option value="'.$naldata['gorivo'].'">'.$naldata['gorivo'].'</option>  ';
                                            }
                                            ?>
                                            </select>                      
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputizdan" class="col-sm-3 control-label">Čas pregleda:</label>
                                        <div class=" col-sm-4">
                                            <select class="form-control" id="inputpregled" name="pregled">
                                                <option>Izberi..</option>
                                                <?php
                                                $data = mysql_query("select distinct DATE_FORMAT(a.pregledanoob,'%d.%m.%Y %h:%i') as pregled from stanja a order by a.pregledanoob;");
                                                while($naldata = mysql_fetch_array( $data )) { 
                                                echo '<option value="'.$naldata['pregled'].'">'.$naldata['pregled'].'</option>  ';
                                                }
                                                ?>
                                            </select>                              
                                        </div>
                                </div>                        
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-4" >
                                        <button  type="submit" onclick="izpisilisto_dva()" value="Reset2" name="reset2" class="btn btn-default"><?php echo $Izpisprn;?> </button>           
                                    </div>
                                </div>
                            </form>                       
                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="cistifilter_dva()" class="btn btn-default"><?php echo $Cistifilter;?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $Cancel;?></button>
                        </div>                    
                        </div>
                    </div>
                </div>
              <!-- Modal izbira myModal6" end-->                  
        </div><!-- #header --> 
        <div id="contents">
            <?php 
                if ($_SESSION['prijavljen'] == 'TRUE' ) {   
                    echo $output; 
                }
                else 
                    echo "<script type='text/javascript'>$('#Logprijava').modal('show'); </script>"; 
            ?> 
        </div><!-- #content -->	
        <div id="footers">
            <div class="col-xs-6 col-md-12">
                <div class="panel panel-primary" id="footpanel">
                    <div class="panel-header" id="footpanelheader" >
                        <span> <?php echo $Opis; ?></span>
                        <span class="footspan_ena"> <?php echo $Opis1.$_SESSION['vloga']; ?></span>
                        <span class="footspan_dva"><?php echo $Predloga;?></span>
                    </div>
                </div>        
            </div>    
          </div><!-- #footer -->    
    </div> <!-- #wrapper -->
</body>





</html>