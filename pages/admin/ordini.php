<?php 
    include '../../config/server/action.php';
    include '../../config/link/function.php';
    cookieAdmin();
    
    if( $_SESSION['ruolo'] != 10) {echo'<script> location.replace("../../"); </script>';}

    
    if(isset($_GET['order']) && $_GET['order'] == 'DESC') {
        $i = 'ORDER BY o.id DESC';
    }
    elseif (isset($_GET['order']) && $_GET['order'] == 'ASC'){
        $i = 'ORDER BY o.id ASC';
    }
    elseif (isset($_GET['price']) && $_GET['price'] == 'DESC'){
        $i = 'ORDER BY o.prezzo_totale DESC';
    }
    elseif (isset($_GET['price']) && $_GET['price'] == 'ASC'){
        $i = 'ORDER BY o.prezzo_totale ASC';
    }
    else {
        $i = 'ORDER BY o.id DESC';
    }

    $rpp = 50; // numero ordini a schermo
    $s=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                            u.nome, u.cognome,
                            ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email
                    FROM ordini AS o
                    JOIN utente AS u ON u.id = o.id_utente
                    JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente 
                    $i");		
    $s->execute();  
    $rm = $s->get_result();
    $r1 = $rm->num_rows;  

    //determino il totale delle pagina disponibili
    $nop = ceil($r1/$rpp);
    //determino la pagina corrente
    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }
    $fr = ($page-1)*$rpp;



?>

<!doctype html>
<html lang="it">
  <head>

    <?php 
        //funzioni invocate
        metaTags();
        linkCssAdmin();
        linkJs();
        favicon2();
    ?>
    <title>Ordini</title>
  </head>

  <body>

  <div class="d-flex" id="wrapper">

    <?php sidebarAdminOrdini2(); ?>

        <div id="page-content-wrapper">
 
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Ordini</h2>
                </div>
            </nav> 

        <div class="container-fluid px-4">

            <div class="row my-5">

                <!-- CODICE TRACKING NON REGISTRATO -->
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded mb-3" type="button" data-bs-toggle="modal" data-bs-target="#art1">
                        <div>
                            <p class="fs-5">Codice tracking<br>(utente non registrato)</p>
                        </div>
                            <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>
                
                <div class="modal fade" id="art1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invia codice tracking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="../../config/server/action" method="POST" autocomplete="off">

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="id" placeholder="Modifica Ordine">

                                        <?php

                                            $s=$conn->prepare("SELECT o.id, o.utente_veloce, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                                                                    u.nome, u.cognome, u.email, u.indirizzo, u.cap, u.citta, u.telefono,
                                                                    p.nome_province
                                                                FROM ordini AS o
                                                                JOIN utente_veloce AS u ON o.utente_veloce = u.id
                                                                JOIN province AS p ON p.id_province = u.provincia                
                                                                WHERE stato = 0");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $prodotti = $row['prodotti'];
                                                $id_utente = $row['utente_veloce'];
                                                $data = $row['data_pagamento'];
                                                $indirizzo = $row['indirizzo'];
                                                $citta = $row['citta'];
                                                $cap = $row['cap'];
                                                $provincia = $row['nome_province'];
                                                $telefono = $row['telefono'];
                                                $email = $row['email'];
                                                $nome = $row['nome'];
                                                $cognome = $row['cognome'];
                                                $prezzo = $row['prezzo_totale'];
                                            
                                                echo '
                                                        <option class="fs-3" value="'.$id.'|'.$prodotti.'|'.$id_utente.'|'.$data.'|'.$indirizzo.'|'.$citta.'|'.$cap.'|'.$provincia.'|'.$telefono.'|'.$email.'|'.$nome.'|'.$cognome.'|'.$prezzo.'">
                                                            ID:'.$id.' - UTENTE:'.$id_utente.' - DATA:'.$data.'
                                                        </option>

                                                    ';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingCategoria">Selezionare il numero ordine</label>

                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="codice" placeholder="name@example.com" required>
                                    <label for="floatingInput">Codice Tracking</label>
                                </div>

                        </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="modificaStatoOrdine2">INVIA</button>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>  

                <!-- CODICE TRACKING REGISTRATO -->
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded mb-3" type="button" data-bs-toggle="modal" data-bs-target="#art2">
                        <div>
                            <p class="fs-5">Codice tracking<br>(utente registrato)</p>
                        </div>
                            <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>
                
                <div class="modal fade" id="art2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invia codice tracking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="../../config/server/action" method="POST" autocomplete="off">

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="id" placeholder="Modifica Ordine">

                                        <?php

                                            $s=$conn->prepare("SELECT o.id, o.prodotti, o.id_utente, o.data_pagamento, o.prezzo_totale,
                                                                    ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email,
                                                                    u.nome, u.cognome          
                                                                FROM ordini AS o 
                                                                JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente        
                                                                JOIN utente AS u ON u.id = o.id_utente                
                                                                WHERE stato = 0");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $prodotti = $row['prodotti'];
                                                $id_utente = $row['id_utente'];
                                                $data = $row['data_pagamento'];
                                                $indirizzo = $row['indirizzo'];
                                                $citta = $row['citta'];
                                                $cap = $row['cap'];
                                                $provincia = $row['provincia'];
                                                $campanello = $row['nome_campanello'];
                                                $telefono = $row['telefono'];
                                                $email = $row['email'];
                                                $nome = $row['nome'];
                                                $cognome = $row['cognome'];
                                                $prezzo = $row['prezzo_totale'];
                                            
                                                echo '
                                                        <option class="fs-3" value="'.$id.'|'.$prodotti.'|'.$id_utente.'|'.$data.'|'.$indirizzo.'|'.$citta.'|'.$cap.'|'.$provincia.'|'.$campanello.'|'.$telefono.'|'.$email.'|'.$nome.'|'.$cognome.'|'.$prezzo.'">
                                                            ID:'.$id.' - UTENTE:'.$id_utente.' - DATA:'.$data.'
                                                        </option>

                                                    ';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingCategoria">Selezionare il numero ordine</label>

                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingInput" name="codice" placeholder="name@example.com" required>
                                    <label for="floatingInput">Codice Tracking</label>
                                </div>

                        </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="modificaStatoOrdine">INVIA</button>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>                  

                <!-- GENERA PDF DI TUTTI GLI ORDINI -->
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded mb-3" onclick="PDF()" type="button">
                        <div>
                            <p class="fs-5">Stampa tutti gli ordini</p>
                        </div>
                            <i class="fas fa-file-pdf fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>      
                
                <!-- DETTAGLI ORDINI -->
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" onclick="javascript:location.href='dettagli'" type="button">
                        <div>
                            <p class="fs-5">Stampa etichetta</p>
                        </div>
                            <i class="fas fa-file-pdf fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>                 

                <div class="col-12 mt-5">
                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 float-end mb-5">
                        <select class="form-select form-select-lg" aria-label="Large select" onchange="location = this.value;">
                            <option <?php if(!isset($_GET['order']) && !isset($_GET['price'])){ echo 'selected';} ?> disabled hidden>FILTRO</option>
                            <option <?php if(isset($_GET['order']) && $_GET['order'] == 'DESC'){ echo 'selected';} ?> value="ordini?page=1&order=DESC">Più recenti</option>
                            <option <?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'selected';} ?> value="ordini?page=1&order=ASC">Meno recenti</option>
                            <option <?php if(isset($_GET['price']) && $_GET['price'] == 'DESC'){ echo 'selected';} ?> value="ordini?page=1&price=DESC">Prezzo alto</option>
                            <option <?php if(isset($_GET['price']) && $_GET['price'] == 'ASC'){ echo 'selected';} ?> value="ordini?page=1&price=ASC">Prezzo basso</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <p class="text-light">ORDINI CON UTENTI CON REGISTRAZIONE</p>
                </div>
                <div class="t1 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <table class="table bg-white rounded shadow-sm  table-hover" id="zpdf">
                        <thead>
                            <tr>
                                <th scope="col" width="50">ID</th>
                                <th>Data</th>                  
                                <th scope="col">Utente</th>
                                <th>Indirizzo</th>
                                <th scope="col">Articoli</th>    
                                <th scope="col">Costo totale</th>
                                <th>Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                            $s=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                                                u.nome, u.cognome,
                                                ui.indirizzo, ui.citta, ui.cap, ui.nome_campanello, ui.telefono, ui.email,
                                                p.nome_province
                                                FROM ordini AS o
                                                JOIN utente AS u ON u.id = o.id_utente
                                                JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente
                                                JOIN province AS p ON p.id_province = ui.provincia
                                                $i
                                                LIMIT ".$fr.','.$rpp);		
                            $s->execute();  
                            $rm = $s->get_result();
                            $r1 = $rm->num_rows;                        
                            
                            while ($row = $rm->fetch_assoc()) {

                                $id_ordine= $row['id'];
                                $id= $row['id_utente'];
                                $prodotti= $row['prodotti'];
                                $data= date("d-m-Y", strtotime($row['data_pagamento']));
                                $prezzo= $row['prezzo_totale'];
                                $nome= $row['nome'];
                                $cognome= $row['cognome'];
                                $indirizzo= $row['indirizzo'];
                                $citta= $row['citta'];
                                $cap= $row['cap'];
                                $provincia= $row['nome_province'];
                                $campanello= $row['nome_campanello'];
                                $telefono= $row['telefono'];
                                $email= $row['email'];
                                $stato= $row['stato'];

                                echo
                                    '
                                    <tr>
                                        <th scope="row">'.$id_ordine.'</th>
                                        <td>'.$data.'</td>
                                        <td class="text-capitalize">ID:'.$id.' - '.$nome.' '.$cognome.'</td>
                                        <td>'.$indirizzo.' ('.$cap.') '.$citta.' - '.$provincia.'</td>
                                        <td>'.$prodotti.'</td>
                                        <td>'.$prezzo.'€</td>
                                        ';?><td><?php if($stato == 0) { echo "Presa in carico";}elseif($stato == 1){echo "Spedito";}?></td> <?php echo'
                                    </tr>                                
                                    ';
                            
                            }
                        ?>   
                        </tbody>
                    </table>
                </div>

                <div class="col-12">
                    <p class="text-light">ORDINI CON UTENTI SENZA REGISTRAZIONE</p>
                </div>
                <div class="t1 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <table class="table bg-white rounded shadow-sm  table-hover" id="zpdf">
                        <thead>
                            <tr>
                                <th scope="col" width="50">ID</th>
                                <th>Data</th>                  
                                <th scope="col">Utente</th>
                                <th>Indirizzo</th>
                                <th scope="col">Articoli</th>    
                                <th scope="col">Costo totale</th>
                                <th>Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                            $s=$conn->prepare("SELECT o.id, o.utente_veloce, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                                                    u.nome, u.cognome, u.email, u.indirizzo, u.cap, u.citta, u.telefono,
                                                    p.nome_province
                                                FROM ordini AS o
                                                JOIN utente_veloce AS u ON o.utente_veloce = u.id
                                                JOIN province AS p ON p.id_province = u.provincia
                                                $i
                                                LIMIT ".$fr.','.$rpp);		
                            $s->execute();  
                            $rm = $s->get_result();
                            $r1 = $rm->num_rows;                        
                            
                            while ($row = $rm->fetch_assoc()) {

                                $id_ordine= $row['id'];
                                $id= $row['id'];
                                $prodotti= $row['prodotti'];
                                $data= date("d-m-Y", strtotime($row['data_pagamento']));
                                $prezzo= $row['prezzo_totale'];
                                $nome= $row['nome'];
                                $cognome= $row['cognome'];
                                $indirizzo= $row['indirizzo'];
                                $citta= $row['citta'];
                                $cap= $row['cap'];
                                $provincia= $row['nome_province'];
                                $telefono= $row['telefono'];
                                $email= $row['email'];
                                $stato= $row['stato'];

                                echo
                                    '
                                    <tr>
                                        <th scope="row">'.$id_ordine.'</th>
                                        <td>'.$data.'</td>
                                        <td class="text-capitalize">ID:'.$id.' - '.$nome.' '.$cognome.'</td>
                                        <td>'.$indirizzo.' ('.$cap.') '.$citta.' - '.$provincia.'</td>
                                        <td>'.$prodotti.'</td>
                                        <td>'.$prezzo.'€</td>
                                        ';?><td><?php if($stato == 0) { echo "Presa in carico";}elseif($stato == 1){echo "Spedito";}?></td> <?php echo'
                                    </tr>                                
                                    ';
                            
                            }
                        ?>   
                        </tbody>
                    </table>
                </div>    
                
                    <nav aria-label="...">
                        <ul class="pagination pagination-lg float-end mt-5">
                            <li class="page-item active" aria-current="page">
                                <?php
                                    if(isset($_GET['page'])){
                                        $page = $_GET['page'];
                                    }
                                    else{
                                        $page=1;
                                    }    

                                    //mostra link delle pagine
                                    if(isset($nop)){
                                        for($i=1;$i<=$nop;$i++){
                                            if(isset($_GET['order'])){
                                                echo '<li class="page-item"><a class="page-link" href="ordini?page='.$i.'&order='.$_GET['order'].'">'.$i.'</a></li>';
                                            }
                                            elseif(isset($_GET['price'])){
                                                echo '<li class="page-item"><a class="page-link" href="ordini?page='.$i.'&price='.$_GET['price'].'">'.$i.'</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="ordini?page='.$i.'">'.$i.'</a></li>';                                                
                                            }
                                        }
                                    } 
                                ?>
                            </li> 
                        </ul>
                    </nav>
                </div>
            </div>

        </div>

    </div>

    <!--  SEZIONE MODAL -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div id="not2" class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notifiche</h5>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Testo</th>
                        <th scope="col">Articolo</th>
                        <th scope="col">Azione</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $w=$conn->prepare("SELECT n.id, n.id_ordine, n.stato,
                                                t.id_testo, t.testo
                                            FROM notifiche AS n
                                            JOIN testo AS t ON t.id_testo = n.testo
                                            WHERE stato = 0
                                            ORDER by n.id DESC");
                        $w->execute();  
                        $r = $w->get_result();

                        while($row = $r->fetch_assoc()) {

                            $id = $row['id'];
                            $id_ordine = $row['id_ordine'];
                            $testo = $row['testo'];
                            $id_testo = $row['id_testo'];

                            if($id_testo <= 3){

                                echo '
                                    <tr>
                                        <th scope="row">'.$id.'</th>
                                        <td>'.$testo.'</td>
                                        <td>'.$id_ordine.'</td>
                                        <td><form action="../../config/server/action" method="post">
                                                <input type="hidden" name="id" value="'.$id.'"/>
                                                <input type="hidden" name="link" value="'.substr(basename($_SERVER['PHP_SELF']),0,-4).'"/>
                                                <button type="submit" class="btn btn-success" name="cancellaNotifica"><i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    ';
                                }
                                elseif($id_testo = 4){
                                    echo '
                                        <tr>
                                            <th scope="row">'.$id.'</th>
                                            <td>'.$testo.'</td>
                                            <td>'.$id_ordine.'</td>
                                            <td><form action="../../config/server/action" method="post">
                                                    <input type="hidden" name="id" value="'.$id.'"/>
                                                    <input type="hidden" name="link" value="'.substr(basename($_SERVER['PHP_SELF']),0,-4).'"/>
                                                    <button type="submit" class="btn btn-success" name="cancellaNotifica"><i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    ';
                                }
                            }

                        ?>
                    </tbody>
                </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <form action="../../config/server/action" method="post">
                    <input type="hidden" name="link" value="<?php $xyz = substr(basename($_SERVER['PHP_SELF']),0,-4); echo $xyz;?>"/>
                    <button type="submit" name="cancellaNotifica2" class="btn btn-success">Segna tutti come letto</button>
                </form>    
            </div>
            </div>
        </div>
    </div>      

    <!-- SEZIONE NOTIFICHE -->
    <?php
        if(isset($_SESSION['notificaStato']) && $_SESSION['notificaStato'] == 0){// successo

            echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        text: 'Stato dell\'ordine modificato.',
                        timer: 2000,
                        showConfirmButton: false});
                </script>
            ";
            unset($_SESSION['notificaStato']);  
        }
        elseif(isset($_SESSION['notificaStato']) && $_SESSION['notificaStato'] == 1){//errore

            echo "
                <script>
                    Swal.fire({
                        icon: 'errore',
                        text: 'Errore nella fase di modifica stato.',
                        timer: 2000,
                        showConfirmButton: false});
                </script>
            ";
            unset($_SESSION['notificaStato']);  
        }
    
    ?>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>

    <!-- PDF  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function PDF() {
            var element = document.getElementById('zpdf');
            html2pdf()
            .from(element)
            .save();
        }

    </script>

    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#not").load(window.location.href + " #not" );
                $("#not2").load(window.location.href + " #not2" );
            }, 10000);
        });
    </script>

  </body>
</html>