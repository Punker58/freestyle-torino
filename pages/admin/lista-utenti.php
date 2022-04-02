<?php 
    include '../../config/server/action.php';
    include '../../config/link/function.php';
    cookieAdmin();
    
    if( $_SESSION['ruolo'] != 10) {echo'<script> location.replace("../../"); </script>';}

    if(isset($_GET['order']) && $_GET['order'] == 'DESC') {
        $i = 'ORDER BY u.id DESC';
    }
    elseif (isset($_GET['order']) && $_GET['order'] == 'ASC'){
        $i = 'ORDER BY u.id ASC';
    }
    else {
        $i = 'ORDER BY u.id DESC';
    }

    $rpp = 50; // numero utenti a schermo
    $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                            ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.telefono, ui.email
                        FROM utente as u
                        JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
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
    <title>Utente</title>
  </head>

  <body>

  <div class="d-flex" id="wrapper">

    <?php sidebarAdminUtente2(); ?>

        <div id="page-content-wrapper">
 
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Utente</h2>
                </div>
            </nav> 

            <div class="container-fluid px-4">

                <div class="row my-5">
                    <div class="col-12">
                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 float-end mb-5">
                            <select class="form-select form-select-lg" aria-label="Large select" onchange="location = this.value;">
                                <option <?php if(!isset($_GET['order']) && !isset($_GET['price'])){ echo 'selected';} ?> disabled hidden>FILTRO</option>
                                <option <?php if(isset($_GET['order']) && $_GET['order'] == 'DESC'){ echo 'selected';} ?> value="lista-utenti?page=1&order=DESC">Più recenti</option>
                                <option <?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'selected';} ?> value="lista-utenti?page=1&order=ASC">Meno recenti</option>
                            </select>
                        </div>
                    </div>
                    <div class="t1 col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Iscrizione</th>
                                    <th scope="col">Utente</th>
                                    <th>Indirizzo</th>
                                    <th>Nome sul campanello</th>
                                    <th scope="col">Telefono</th>    
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 

                                $s=$conn->prepare("SELECT u.id, u.data_iscrizione, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                                                        ui.indirizzo, ui.nome_campanello, ui.citta, ui.cap, ui.telefono, ui.email,
                                                        p.nome_province
                                                    FROM utente as u
                                                    JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                                                    JOIN province as p ON p.id_province = ui.provincia
                                                    $i
                                                    LIMIT ".$fr.','.$rpp);		
                                $s->execute();  
                                $r = $s->get_result();                            

                                while ($row = $r->fetch_assoc()) {

                                    $id = $row['id'];
                                    $data = $row['data_iscrizione'];
                                    $data = date("d-m-Y",strtotime($data));
                                    $nome = $row['nome'];
                                    $cognome = $row['cognome'];
                                    $indirizzo = $row['indirizzo'];
                                    $campanello = $row['nome_campanello'];
                                    $citta = $row['citta'];
                                    $cap = $row['cap'];
                                    $provincia = $row['nome_province'];
                                    $telefono = $row['telefono'];
                                    $email = $row['email'];

                                    echo '

                                        <tr>
                                        <th scope="row">'.$id.'</th>
                                        <th scope="col">'.$data.'</th>
                                        <td class="text-capitalize">'.$nome.' '.$cognome.'</td>
                                        <td>'.$indirizzo.', ('.$cap.') '.$citta.' - '.$provincia.'</td>
                                        <td>'.$campanello.'</td>
                                        <td>'.$telefono.'</td>
                                        <td>'.$email.'</td>
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
                                                echo '<li class="page-item"><a class="page-link" href="lista-utenti?page='.$i.'&order='.$_GET['order'].'">'.$i.'</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="lista-utenti?page='.$i.'">'.$i.'</a></li>';                                                
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