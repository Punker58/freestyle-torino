<?php 

    include '../../config/server/action.php';
    if($_SESSION['nome'] == null ){ $_SESSION['av'] = 1; echo'<script> location.replace("../../pages/carrello/acquisto-veloce"); </script>';}  
    include '../../config/link/function.php';
  
    cookieUtente();

    $_SESSION['y'] = bin2hex(random_bytes(24));
    $_SESSION['token'] = password_hash($_SESSION['y'], PASSWORD_BCRYPT);

?>

<!doctype html>
<html lang="it">
  <head>

    <?php 
        //meta tags + seo + css + js
        metaTagsY();
        seoTags();
        linkCss2();
        linkJs();
        favicon2();
        
        //AVBJYFl0nIbaSqUhR3X6LjnGrxxdFoNzTo0hMy3-Lg6_tGpNmn0VKY4oydFQ8XmvaZRk8sFsavmhGv-y
        //Ad1aLAElU1akzKURvmSzk1ydh9KXBq3qjGE7Z2JcWwQ66kJAfigydRF4W8qX7trh78l_gCoLVQ8JNHzv
        echo '  <script src="https://www.paypal.com/sdk/js?client-id=AVBJYFl0nIbaSqUhR3X6LjnGrxxdFoNzTo0hMy3-Lg6_tGpNmn0VKY4oydFQ8XmvaZRk8sFsavmhGv-y&currency=EUR&disable-funding=mybank,sofort"></script>';
    ?>
    <title>Checkout | Sito ufficiale FreestyleConceptStore</title>
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
                <p>CHECKOUT</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">
            <div class="row utente">
              <?php 
                    $_SESSION['complessivo1'] = 0;
                    $s=$conn->prepare("SELECT CONCAT (nome,' ( X ',n_quantita,' ) ', ' ( ',n_colore,' ) ', ' ( ',n_taglia,' ) ')
                                          AS articoli, prezzo_totale, prezzo_sconto, pf.foto1, p.categoria
                                          FROM carrello AS c
                                          JOIN prodotti AS p ON p.id_prodotto = c.id_prodotto
                                          JOIN colore AS co ON co.id = c.id_colore
                                          JOIN taglia as t ON t.id = c.id_taglia
                                          JOIN prodotti_foto as pf ON pf.id_prodotto = p.id_prodotto
                                          JOIN categoria as ca ON ca.id = p.categoria
                                          WHERE id_utente = ?");
                    $s->bind_param('s', $_SESSION['cod_carrello']);		
                    $s->execute();  
                    $r = $s->get_result();

                    if ($r->num_rows > 0) {

                      while ($row = $r->fetch_assoc()) {

                        $articoli[] = $row['articoli'];
                        $foto1 = $row['foto1'];
                        $categoria = $row['categoria'];
                        $psconto = $row['prezzo_sconto'];
                        $_SESSION['complessivo1'] = $_SESSION['complessivo1'] + $row['prezzo_totale'];

                      }

                      if(!empty($psconto)){

                        $_SESSION['complessivo2'] = $psconto + 7;

                      }
                      elseif(empty($psconto)){

                        $_SESSION['complessivo2'] = $_SESSION['complessivo1'] + 7;
                      }

                      $articoli2 = implode("</br></br> ", $articoli);

                      echo 
                        '
                          <div class="col-12 text-center mb-3 mt-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6"><h1 class="t-dettagli mt-5 mb-3">Articoli:</h1></div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-5"">
                                  <h3 class="mb-5 mt-3">'.$articoli2.'</h3>
                                </div>
                            </div>
                          </div>
                        ';

                      }else{
                        echo'<script> location.replace("../../"); </script>';
                      }
                      if(!empty($_SESSION['nome']) && !empty($_SESSION['cognome']) && !empty($_SESSION['indirizzo']) && !empty($_SESSION['citta'])
                      && !empty($_SESSION['cap']) && !empty($_SESSION['telefono']) && isset($_SESSION['avx']) && $_SESSION['avx'] == 1){

                            echo 
                                '
                                  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row">
                                      <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5 text-center">
                                        <h1 class="t-dettagli">Indirizzo di spedizione</h1>
                                        <span class="text-capitalize">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</span></br>
                                        <span>'.$_SESSION['indirizzo'].' ,</span></br>
                                        <span class="text-capitalize">'.$_SESSION['citta'].' '.$_SESSION['cap'].'</span></br>
                                        <span>Telefono: '.$_SESSION['telefono'].'</span><br>
                                        <a href="acquisto-veloce" class="btn btn-lg btn-light">MODIFICA</a>
                                      </div>
                                ';

                           }elseif(!empty($_SESSION['nome']) && !empty($_SESSION['cognome']) && !empty($_SESSION['indirizzo']) && !empty($_SESSION['citta'])
                             && !empty($_SESSION['cap']) && !empty($_SESSION['telefono'])){

                              echo '
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                      <div class="row">

                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5 text-center">
                                          <h1 class="t-dettagli">Indirizzo di spedizione</h1>
                                          <span class="text-capitalize">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</span></br>
                                          <span>'.$_SESSION['indirizzo'].' ,</span></br>
                                          <span class="text-capitalize">'.$_SESSION['citta'].' '.$_SESSION['cap'].'</span></br>
                                          <span>Telefono: '.$_SESSION['telefono'].'</span>
                                        </div>
                                  ';

                             }

                              echo '  
                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 text-center">
                                            <h1 class="t-dettagli">Coupon</h1>
                                              <form action="../../config/server/action" method="post" class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                                                  <input type="text" name="codice" class="form-control mt-3 mb-2">
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-5">
                                                  <button type="submit" name="coupon" class="btn btn-light mt-3">INSERISCI</button
                                                </div>
                                              </form>
                                        </div>
                                        </div>

                                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5 text-center" id="spedizione">
                                              <h2>Articoli: '; ?> <?php if(!empty($psconto) && $_SESSION['complessivo1'] <= 0) { echo '0€';}elseif(!empty($psconto) && $_SESSION['complessivo1'] >= 1){ echo number_format($psconto,2)."€";}else{ echo number_format($_SESSION['complessivo1'],2)."€";} ?><?php echo '</h2>
                                              <h2>Spedizione: 7.00€</h2>
                                              <h1 class="t-dettagli">Totale da pagare: '.number_format($_SESSION['complessivo2'],2).'€</h1>
                                            </div>  

                                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5 text-center" id="inNegozio">
                                                <h2>Articoli: '; echo number_format($_SESSION['complessivo1'],2) . '€'; ?> <?php echo'</h2>
                                                <h2>RITIRO IN NEGOZIO (GRATUITO)</h2>
                                                <h1 class="t-dettagli">Totale da pagare:'; echo number_format($_SESSION['complessivo1'],2) . '€';?> <?php echo '</h1>
                                            </div>

                                          <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5"></div>
                                          <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5 fs-3">

                                            <h1 class="t-dettagli mb-3">TIPO DI CONSEGNA</h1>

                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="radioDefault" checked="" id="spedizioneB">
                                              <label class="form-check-label" for="spedizioneB">SPEDIZIONE (7 €)</label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="radioDefault" id="inNegozioB">
                                              <label class="form-check-label" for="inNegozioB">RITIRO IN NEGOZIO (GRATUITO)</label>
                                            </div>

                                          </div>   

                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5"></div>
                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5"></div>

                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5" id="spedizioneP">
                                          <h1 class="t-dettagli text-center">metodi di pagamento</h1>
                                          <div id="paypal-button-container" class="text-center"></div>
                                        </div> 

                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mb-5" id="inNegozioP">
                                          <h1 class="t-dettagli text-center">metodi di pagamento</h1>
                                          <div id="paypal-button-container2" class="text-center"></div>
                                        </div> 

                                  </div>
                                ';

                        ?>

            </div>
        </div>
    </section>

    <!-- SEZIONE NOTIFICHE --->
    <?php
    
      if(isset($_SESSION['notificaSconto']) && $_SESSION['notificaSconto'] == 1)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  text: 'Codice sconto aggiunto con successo.',
                  timer: 3000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['notificaSconto']);
      }
      elseif(isset($_SESSION['notificaSconto']) && $_SESSION['notificaSconto'] == 0)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'Nessun codice sconto/Codice sconto già in utilizzo.',
                  timer: 4000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['notificaSconto']);
      }     
    
    ?>

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>

  <!-- Extra JS -->

  <script type="text/javascript">

    $(document).ready(function(){

      $("#inNegozio").hide();
      $("#inNegozioP").hide();

      //acquisto con spedizione a casa
      $("#spedizioneB").click(function(){

        $("#inNegozio").hide();
        $("#inNegozioP").hide();
        $("#spedizione").show();
        $("#spedizioneP").show();
        
      });

      //acquisto con ritiro in negozio
      $("#inNegozioB").click(function(){

        $("#spedizione").hide();
        $("#spedizioneP").hide();
        $("#inNegozio").show();
        $("#inNegozioP").show();

      });

    });

    paypal.Buttons({

      // Sets up the transaction when a payment button is clicked
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: <?php echo number_format($_SESSION['complessivo2'],2); ?> // Can reference variables or functions. Example: `value: document.getElementById('...').value`
              }
            }]
          });
        },

      // Finalize the transaction after payer approval
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {

          // When ready to go live, remove the alert and show a success message within this page. For example:
          var element = document.getElementById('paypal-button-container');
          element.innerHTML = '';
          window.location.href='grazie-per-l-acquisto?token=<?php echo str_replace('/', '-', $_SESSION['token']);?>';
        });
      }
    }).render('#paypal-button-container');

    paypal.Buttons({

    // Sets up the transaction when a payment button is clicked
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: <?php echo number_format($_SESSION['complessivo1'],2); ?> // Can reference variables or functions. Example: `value: document.getElementById('...').value`
            }
          }]
        });
      },

    // Finalize the transaction after payer approval
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(orderData) {

        // When ready to go live, remove the alert and show a success message within this page. For example:
        var element = document.getElementById('paypal-button-container');
        element.innerHTML = '';
        window.location.href='grazie-per-l-acquisto?negozio=1&token=<?php echo str_replace('/', '-', $_SESSION['token']);?>';
      });
    }
    }).render('#paypal-button-container2');

    </script>

    <!-- SEZIONE MODAL -->

    <!-- login -->
    <?php modalLogin2();?>

    <!-- registrazione-->
    <?php modalRegistrazione2();?>    

  </body>
</html>