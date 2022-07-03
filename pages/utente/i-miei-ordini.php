<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    if($_SESSION['id'] == null){echo'<script> location.replace("../../"); </script>';}
    
?>

<!doctype html>
<html lang="it">
  <head>

    <?php 
        //meta tags + seo + css + js
        metaTags();
        seoTags();
        linkCss2();
        linkJs();
        favicon2();
    ?>
    <title>I miei ordini | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarGenerico2(); navbarGenericoMobile2(); freestyleLogo2(); ?>

    <!-- BANNER HOME --->
    <section id="margine20">

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="custom-shape-divider-bottom-1644927053">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>
                </svg>
            </div>
          </div>

          <div class="bg-black">
            <div class="banner-home">
                <p>I MIEI ORDINI</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">
            <div class="row utente">

            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-3 text-uppercase" style="overflow-x:auto !important;"">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <td class="t-dettagli">Articoli</td>
                            <td>Totale</td>
                            <td class="t-dettagli">Stato</td>
                            <th class="row">Codice tracking<th>
                        </tr>
                    </thead>
                    <tbody>


                    <?php 
                            $s=$conn->prepare("SELECT o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato, o.tracking
                                            FROM ordini AS o
                                            WHERE o.id_utente = ?");
                            $s->bind_param('i', $_SESSION['id']);		
                            $s->execute();  
                            $r = $s->get_result();

                            if ($r->num_rows > 0) {

                                while ($row = $r->fetch_assoc()) {

                                    $prodotti = $row['prodotti'];
                                    $data = $row['data_pagamento'];
                                    $data2 = date("d-m-Y",strtotime($data));
                                    $prezzo = $row['prezzo_totale'];
                                    $stato = $row['stato'];
                                    $tracking = $row['tracking'];

                                    echo '
                                                <tr>
                                                    <td data-label="Data">'.$data2.'</td>
                                                    <td data-label="Articoli" class="t-dettagli">'.$prodotti.'</td>
                                                    <td data-label="Totale">'.$prezzo.' €</td>
                                                    <td data-label="Stato" class="t-dettagli">';?> 
                                                        <?php if($stato == 1) {echo '<p class="text-uppercase text-success">Spedito<p>';}
                                                            elseif($stato == 0) { echo '<p class="text-uppercase text-primary">In lavorazione<p>';}
                                                            elseif($stato == 9){echo '<p class="text-uppercase text-success">Completato<p>';}
                                                            elseif($stato == 5){echo '<p class="text-uppercase text-danger">Annullato<p>';}
                                                            elseif($stato == 6){echo '<p class="t-dettagli">Rimborsato<p>';}
                                                            elseif($stato == 2){echo '<p class="text-uppercase text-success">Ritiro in negozio<p>';}
                                                        ?> <?php echo '</td>
                                                    <td data-label="C.Tracking">';?> <?php if(!empty($tracking)) {echo '<p class="text-uppercase">'.$tracking.'<p>';}elseif(empty($tracking)) { echo '<p class="text-uppercase" ><ins class="text-secondary">Il codice di tracking sarà disponibile non appena il pacco sarà spedito.</ins><p>';}?> <?php echo '</td>
                                                </tr>  
                                        ';
                                }

                            }else{
                                echo '
                                <div class="col-12 text-center mb-3 mt-3">
                                    <p class="testoUtente">
                                        La tua lista ordini è vuota.
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-5 text-center">
                                    <a href="../../pages/collezione/tutta-la-collezione" class="btn btn-lg btn-light"> CONTINUA LO SHOPPING</a>
                                </div>
                                ';
                            }
                            
                    ?>  
                    
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </section>

    <!-- login -->
    <?php modalLogin2();?>

    <!-- registrazione-->
    <?php modalRegistrazione2();?>        

    <?php
        if(isset($_SESSION['notificaStato']) && $_SESSION['notificaStato'] == 1)
        {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Like rimosso con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";

            unset($_SESSION['notificaStato']);
        }
    ?>    

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>

  <!-- Extra JS -->

  </body>
</html>