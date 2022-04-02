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

    // ordini recenti
    $s=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale,
                                u.nome, u.cognome,
                                ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email
                        FROM ordini AS o
                        JOIN utente AS u ON u.id = o.id_utente
                        JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente 
                        $i
                        LIMIT 20");		
    $s->execute();  
    $r = $s->get_result();
    
    // numero ordini
    $ss=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale,
                                u.nome, u.cognome,
                                ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email
                        FROM ordini AS o
                        JOIN utente AS u ON u.id = o.id_utente
                        JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente 
                        ORDER BY o.id DESC");		
    $ss->execute();  
    $rr = $ss->store_result();
    $o = $ss->num_rows;

    // Numero articoli
    $s1=$conn->prepare("SELECT id FROM prodotti");		
    $s1->execute();  
    $r1 = $s1->store_result();
    $a = $s1->num_rows;

    // Numero utente
    $s2=$conn->prepare("SELECT id FROM utente");		
    $s2->execute();  
    $r2 = $s2->store_result();
    $u = $s2->num_rows;

    // guadagni
    $s3=$conn->prepare("SELECT sum(o.prezzo_totale) AS tot
                        FROM ordini AS o");		
    $s3->execute();  
    $r3 = $s3->get_result();

    while ($row = $r3->fetch_assoc()) {
        $tot = $row['tot'];
    }
           
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
    <title>Dashboard</title>
  </head>

  <body>

  <div class="d-flex" id="wrapper">

    <?php sidebarAdmin2(); ?>

        <div id="page-content-wrapper">
 
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Dashboard</h2>
                </div>
            </nav> 

        <div class="container-fluid px-4">

            <div class="row g-3 my-2">
                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded icon-admin">
                        <div>
                            <h3 class="fs-2"><?php echo $a;?></h3>
                            <p class="fs-5">Articoli</p>
                        </div>
                        <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $o; ?></h3>
                            <p class="fs-5">Ordini</p>
                        </div>
                        <i class="fas fa-truck fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $tot;?>€</h3>
                            <p class="fs-5">Guadagni</p>
                        </div>
                        <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $u;?></h3>
                            <p class="fs-5">Utenti</p>
                        </div>
                        <i class="fas fa-user fs-1 primary-text border rounded-full bg-danger p-3"></i>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <h3 class="fs-4 mb-3 text-light">Ordini recenti</h3>
                <div class="col-12">
                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 float-end mb-5">
                        <select class="form-select form-select-lg" aria-label="Large select" onchange="location = this.value;">
                            <option <?php if(!isset($_GET['order']) && !isset($_GET['price'])){ echo 'selected';} ?> disabled hidden>FILTRO</option>
                            <option <?php if(isset($_GET['order']) && $_GET['order'] == 'DESC'){ echo 'selected';} ?> value="dashboard?order=DESC">Più recenti</option>
                            <option <?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'selected';} ?> value="dashboard?order=ASC">Meno recenti</option>
                            <option <?php if(isset($_GET['price']) && $_GET['price'] == 'DESC'){ echo 'selected';} ?> value="dashboard?price=DESC">Prezzo alto</option>
                            <option <?php if(isset($_GET['price']) && $_GET['price'] == 'ASC'){ echo 'selected';} ?> value="dashboard?price=ASC">Prezzo basso</option>
                        </select>
                    </div>
                </div>
                <div class="t1 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <table class="table bg-white rounded shadow-sm  table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">ID</th>
                                <th>Data</th>                  
                                <th scope="col">Utente</th>
                                <th>Indirizzo</th>
                                <th scope="col">Articoli</th>    
                                <th scope="col">Costo totale</th>
                            </tr>
                        </thead>
                        <tbody>                           
                            <?php
                            
                                while ($row = $r->fetch_assoc()) {

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
                                    $provincia= $row['provincia'];
                                    $campanello= $row['nome_campanello'];
                                    $telefono= $row['telefono'];
                                    $email= $row['email'];

                                    echo
                                        '
                                        <tr>
                                            <th scope="row">'.$id_ordine.'</th>
                                            <td>'.$data.'</td>
                                            <td class="text-capitalize">'.$nome.' '.$cognome.'</td>
                                            <td>'.$indirizzo.'</td>
                                            <td>'.$prodotti.'</td>
                                            <td>'.$prezzo.'€</td>    
                                        </tr>                                
                                        ';
                                
                                }
                            ?>                      
                        </tbody>
                    </table>
                </div>
            </div>

            </div>

        </div>

    </div>
    <!-- /#page-content-wrapper -->

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

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function(){
            setInterval(function(){
                $("#not").load(window.location.href + " #not" );
                $("#not2").load(window.location.href + " #not2" );
            }, 10000);
        });
    </script>

  </body>
</html>