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

    $s=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                            u.nome, u.cognome,
                            ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email
                    FROM ordini AS o
                    JOIN utente AS u ON u.id = o.id_utente
                    JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente 
                    $i");		
    $s->execute();  
    $rm = $s->get_result();  

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
    <title>Dettagli</title>
  </head>

  <body>

  <div class="d-flex" id="wrapper">

    <?php sidebarAdminOrdini2(); ?>

        <div id="page-content-wrapper">
 
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Dettagli</h2>
                </div>
            </nav> 

        <div class="container-fluid px-4">

            <div class="row my-5">   
                
                <div class="col-12">

                <!-- GENERA PDF DI TUTTI GLI ORDINI -->
                <div class="col-md-3 mb-5">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" onclick="PDF()" type="button">
                        <div>
                            <p class="fs-5">GENERA PDF</p>
                        </div>
                            <i class="fas fa-file-pdf fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>  
    
                    <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xxl-5 d-flex justify-content-center mb-5 bd-highlight mb-2">
                        <select class="form-select form-select-lg" aria-label="Large select" id="r58">
                            <option selected  disabled hidden>SELEZIONA ORDINE</option>
                            <?php
                            
                                //check ordini + data minore o uguale a 5 giorni dalla creazione
                                $s1=$conn->prepare("SELECT * FROM ordini
                                                    WHERE data_pagamento <= '".date("Y-m-d", strtotime("+5 days"))."'       
                                                    ORDER BY id DESC");	
                                $s1->execute();  
                                $r = $s1->get_result(); 

                                while ($row = $r->fetch_assoc()) {

                                    $id = $row['id'];
                                    $utente = $row['id_utente'];
                                    $prodotti = $row['prodotti'];
                                    $data = $row['data_pagamento'];
                                    $prezzo = $row['prezzo_totale'];


                                    echo '<option value="'.$id.'">ID: '.$id.' | DATA: '.$data.' | UTENTE: '.$utente.' ';
                                }                            
                            
                            
                            ?>
                        </select>
                    </div>
                </div>
                <div class="t1 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <h1 class="text-center text-light mb-5">Anteprima PDF</h1>

                        <div id="zpdf">
                            <div class="container">

                                <div class="row justify-content-center bg-light">
                                        
                                    <div class="col-9 mt-5">

                                        <div class="col-3 float-start">
                                            <h2>FreestyleConceptStore</h2>
                                            <span>Via Giuseppe Giacosa 2,</span><br>
                                            <span>Nichelino 10042 (TO)</span><br>
                                            <span>Telefono</span><br>
                                            <span>P.iva</span><br>
                                        </div>

                                        <div class="col-3 float-end">
                                            <img src="../../images/logo/freestyle2.png" class="img-fluid" alt="">
                                        </div>

                                    </div>    

                                    <div class="col-9 mt-5">

                                        <div class="col-3 float-start">
                                            <p>Indirizzo di fatturazione</p>
                                            <p>NOME COGNOME</p>
                                            <p>INDIRIZZO</p>
                                            <p>TELEFONO</p>
                                            <p>EMAIL</p>
                                        </div>

                                        <div class="col-3 float-start">
                                            <p>Indirizzo di spedizione</p>
                                            <p>NOME COGNOME</p>
                                            <p>INDIRIZZO</p>
                                            <p>TELEFONO</p>
                                            <p>EMAIL</p>
                                        </div>                                    

                                        <div class="col-3 float-end">
                                            <p>N.Fattura: 58</p>
                                            <p>Data: DATA DI OGGI</p>
                                        </div>     

                                    </div>   

                                    <div class="col-9 mt-5">

                                        <h3>Informazioni sull'ordine</h3>
                                        <p>Data ordine: XX XXXX XXXX</p> 
                                        <p>N.Ordine: XXXX XXXXX XXXX</p>

                                    </div>                                 
                                    
                                    <div class="col-9 mt-5">

                                        <table class="table">
                                            <thead>
                                                <tr class="table-dark">
                                                <th scope="col">Articolo</th>
                                                <th scope="col">Descrizione</th>
                                                <th scope="col">Quant.</th>
                                                <th scope="col">Prezzo Totale</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Sciarpa Blu</th>
                                                    <td>100% cotone</td>
                                                    <td>1</td>
                                                    <td>10€</td>
                                                </tr>
                                            </tbody>
                                        </table>  

                                        <div class="col-4 mt-2 float-end">
                                            <h2>Totale ricevuta  10€</h2> 
                                        </div>

                                    </div> 

                                    <div class="col-9 mt-5 mb-5">
                                        <span>
                                            Questo documento non è valido come fattura e non può essere usato per detrarre l'IVA.
                                            Operazione non soggetta all'obbligo di emissione della fattura (ai sensi dell'art. 22, c. 1, n. 1 DPR 633/72) né
                                            all'obbligo di certificazione fiscale (art 2, lett oo), DPR 696/96.
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>

                </div>
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

        $(document).ready(function(){
            $("#r58").change(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/user/ricerca-dettagli',
                    data:{ id:$("#r58").val(),},
                    success:function(data){
                        $("#zpdf").html(data);
                    }
                });
            });
        });

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