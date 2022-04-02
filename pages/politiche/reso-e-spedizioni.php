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
    <title>Politica della privacy | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarGenerico2(); navbarGenericoMobile2();?>

    <section>
      <div class="container bg-black mt-5">
        <div class="row politiche">
          <div class="col-12 d-flex justify-content-center">
            <h1 class="t-dettagli">Politiche di reso e Spedizione</h1>
          </div>
          <div class="col-12">
            <h3 class="t-dettagli">Politiche di reso</h3>
            <span>
              www.freestyleconceptstore.it consente la restituzione della merce ordinata entro 7 giorni dalla ricezione del prodotto.<br>
              Il cliente può scegliere tra:<br><br>
              <ul>
                <li>Rimborso</li>
                <li>Cambio taglia/colore/capo</li>
              </ul> 
            </span>
            <h3 class="spese mb-5">Le spese per la restituzione del prodotto sono a carico del cliente.</h3>
            <h3 class="t-dettagli">Politiche di spedizione</h3>
            <span>
              Le spedizioni in Italia sono effettuate tramite GLS.<br>
              Come richiesto dalle leggi che regolano il commercio, tutte le spedizioni  sono allegate da fattura ufficiale che dichiara il valore dei singoli articoli in Euro.<br>
              Per gli articoli in saldo la fattura riporta gli importi scontati.<br><br>
              Gli ordini sono spediti da www.freestyleconceptstore.it, dal Lunedì al Venerdì con orario 10:00-19:30.<br>
              Gli ordini effettuati durante il fine settimana saranno gestiti a partire dal Lunedì mattina successivo.<br>
              Gli ordini di articoli già disponibili sono spediti il primo giorno feriale successivo a quello in cui è stato effettuato l’ordine, previa conferma della disponibilità della merce.<br>
              La carta di credito o conto paypal sarà addebitata/o il giorno dell’ordine.<br>
              In tutti i casi www.freestyleconceptstore.it si riserva il diritto di posticipare la spedizione qualora si verifichino eventi con cause di forza maggiore.<br>
              Tutti i Clienti che effettuano un ordine stabiliscono un rapporto commerciale con www.freestyleconceptstore.it e si impegnano pertanto ad accettare la consegna del proprio pacco.<br>
              Se per qualsiasi motivo il cliente rifiuta la consegna della spedizione o richiede la restituzione al mittente ogni spesa di spedizione, addebitata a www.freestyleconceptstore.it, sarà dedotta dall’eventuale rimborso dovuto al Cliente.<br>
              Le spedizioni www.freestyleconceptstore.it sono assicurate gratuitamente contro furto e danno accidentale.<br>
              Una volta che la spedizione giunge a destinazione l’assicurazione perde la sua validità.
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