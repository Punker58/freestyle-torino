<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    cod_sconto();
  
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
    <title>Aiuto e FAQ | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarGenerico2(); navbarGenericoMobile2();?>

    <section>
      <div class="container bg-black mt-5">
        <div class="row politiche">
          <div class="col-12 d-flex justify-content-center">
            <h1 class="t-dettagli">Aiuto e FAQ</h1>
          </div>
          <div class="col-12">
            <h3 class="t-dettagli">quali sono i metodi di pagamento accettati?</h3>
            <span>
              Su www.freestyleconceptstore paghi come preferisci.<br>
              Accettiamo carte di credito e debito, Postepay e Paypal.
            </span>
          </div>
          <div class="col-12">
            <h3 class="t-dettagli">come funzionano i cambi?</h3>
            <span>
              Per poter ottenere un cambio è necessario contattarci tramite whatsapp oppure tramite la nostra email, allegando la fotografia del prodotto. <br>
              Dovranno essere indicati i motivi del cambio e deve essere necessario che la merce scelta per la sostituzione sia disponibile.<br>
            </span>
          </div>
          <div class="col-12">
            <h3 class="t-dettagli">come funzionano i resi?</h3>
            <span>
              Per poter ottenere un reso è necessario contattarci tramite whatsapp oppure tramite la nostra email, allegando la fotografia del prodotto. <br>
              Dovranno essere indicati i motivi del reso e spedire l'articolo/gli articoli al negozio.<br>
              Una volta accettato il tuo reso ti verrà addebitata la somma del/dei articolo/i.
            </span>
          </div>
          <div class="col-12">
            <h3 class="t-dettagli">In quanto tempo viene spedito il mio ordine?</h3>
            <span>
              Il tuo ordine verra consegnato in 2-3 giorni lavorativi, nel caso un tuo ordine venga processato di venerdì sera, (oppure la sera prima di un giorno festivo)<br>
              l'ordine verrà consegnato al corriere il primo giorno lavorativo disponibile (in questo caso Lunedì).     
            </span>
          </div>

        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <?php footerIndex(); ?>
    </div>

    <!-- SEZIONE MODAL -->

    <!-- login -->
    <?php modalLogin2();?>

    <!-- registrazione-->
    <?php modalRegistrazione2();?>   
    
    <!-- Recupero password -->
    <?php recuperoPssw2();?>


    <!-- Notifiche -->
    <?php
      if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 1)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  text: 'Registazione avvenuta con successo',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['utenteNotifica']);
      }
      else if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 2)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'Inserire tutti i campi',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['utenteNotifica']);
      }
      else if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 3)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'Utente già registrato',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['utenteNotifica']);
      }
      else if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 4)
      {
          echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  text: 'Login effettuato con successo',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
          ";

          unset($_SESSION['utenteNotifica']);
      }
      else if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 5)
      {
          echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Credenziali errate',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
          ";

          unset($_SESSION['utenteNotifica']);
      }elseif (isset($_SESSION['resetPsswd']) && $_SESSION['resetPsswd'] == 0){

        echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'email inesistente',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
        ";

        unset($_SESSION['resetPsswd']);
      }elseif (isset($_SESSION['resetPsswd2']) && $_SESSION['resetPsswd2'] == 0){

        echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'codice errato',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
        ";

        unset($_SESSION['resetPsswd2']);
      }elseif (isset($_SESSION['resetPsswd3']) && $_SESSION['resetPsswd3'] == 1){

        echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  text: 'password cambiata con successo',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
        ";

        unset($_SESSION['resetPsswd3']);
      }elseif (isset($_SESSION['resetPsswd3']) && $_SESSION['resetPsswd3'] == 0){

        echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  text: 'le password non combaciano',
                  timer: 2000,
                  showConfirmButton: false});
          </script>
        ";

        unset($_SESSION['resetPsswd3']);
      }
    ?>    

  <!-- Extra JS -->

  </body>
</html>