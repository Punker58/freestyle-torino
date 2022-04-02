<?php 

    include 'config/link/function.php';
    include 'config/server/action.php';
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
        linkCss();
        linkJs();
        favicon();
    ?>
    <title>Mappa del sito | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarIndex(); navbarIndexMobile();?>

    <section>
      <div class="container bg-black mt-5">
        <div class="row">
          <div class="col-12 mt-5 d-flex justify-content-center">
            <h1 class="t-dettagli">Mappa del sito</h1>
          </div>
          <div class="col-12 mt-5 d-flex justify-content-center"> 
          </div>
          <div class="col-12 mt-5 mb-5 ">
            <h3>Home</h3>
            <ul>
              <li>
                <a href="index">Home</a>
              </li>
            </ul>
            <h3>Collezione</h3>
            <ul>
              <li>
                <a href="pages/collezione/tutta-la-collezione">tutta la collezione</a>
              </li>
              <li>
                <a href="pages/collezione/t-shirt">t-shirt</a>
              </li>
              <li>
                <a href="pages/collezione/pantaloni">pantaloni</a>
              </li>
              <li>
                <a href="pages/collezione/jeans">jeans</a>
              </li>
              <li>
                <a href="pages/collezione/maglieria">maglieria</a>
              </li>
              <li>
                <a href="pages/collezione/camicie">camicie</a>
              </li>
              <li>
                <a href="pages/collezione/giubbini">giubbini</a>
              </li>
              <li>
                <a href="pages/collezione/tute">tute</a>
              </li>
              <li>
                <a href="pages/collezione/giacche">giacche</a>
              </li>
              <li>
                <a href="pages/collezione/cappotti">cappotti</a>
              </li>
              <li>
                <a href="pages/collezione/elegante">completo elegante</a>
              </li>
              <li>
                <a href="pages/collezione/t-shirt">accessori</a>
              </li>
              <li>
              <a href="pages/collezione/bermuda">bermuda</a>
              </li>
            </ul>
            <h3>Utente</h3>
            <ul>
              <li>
                <a href="pages/utente/dati">i miei dati</a>
              </li>
              <li>
                <a href="pages/utente/i-miei-ordini">i miei ordini</a>
              </li>
              <li>
                <a href="pages/utente/preferiti">preferiti</a>
              </li>
            </ul>
            <h3>Politiche e Aiuto</h3>
            <ul>
              <li>
                <a href="pages/politiche/aiuto-e-faq">aiuto e faq</a>
              </li>
              <li>
                <a href="pages/politiche/privacy">privacy</a>
              </li>
              <li>
                <a href="pages/politiche/reso-e-spedizioni">reso e spedizioni</a>
              </li>    
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <?php footerIndex(); ?>
    </div>

    <!-- SEZIONE MODAL -->

    <!-- login -->
    <?php modalLogin();?>

    <!-- registrazione-->
    <?php modalRegistrazione();?>    

    <!-- Recupero password -->
    <?php recuperoPssw();?>

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