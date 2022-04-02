<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    if(!empty($_SESSION['access'])){echo'<script> location.replace("../../"); </script>';}
    
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
    <title>Carrello | Sito ufficiale FreestyleConceptStore</title>
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
                <p>ACQUISTO VELOCE</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">

          <div class="row">
            <h1 class="t-dettagli text-center mt-5">Indirizzo di spedizione</h1>
            <p class="text-center">I seguenti dati che indicherai serviranno solo per completare l'acquisto.<br>
                Non utilizzeremo mai i tuoi dati per registrarti.
            </p>
          </div>    
          
            <form action="../../config/server/action" method="post">
              <div class="row">

                <div class="form-floating mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-4">
                  <input type="text" class="form-control form-control-sm" id="nome" name="nome" placeholder="name@example.com" required>
                  <label for="nome">Nome *</label>
                </div>
                
                <div class="form-floating mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-4">
                  <input type="text" class="form-control" id="cognome" name="cognome" placeholder="name@example.com" required>
                  <label for="cognome">Cognome *</label>
                </div>                                   

                <div class="form-floating mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-4">
                  <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                  <label for="email">Email *</label>
                </div>    
                
                <div class="form-floating mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-4">
                  <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="name@example.com" required>
                  <label for="indirizzo">Indirizzo *</label>
                </div>  
                
                <div class="form-floating mb-3 col-sm-12 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                  <input type="number" class="form-control" id="cap" name="cap" placeholder="name@example.com" size="5" onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;" required>
                  <label for="cap">Cap *</label>
                </div>   
                
                <div class="form-floating mb-3 col-sm-12 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                  <input type="text" class="form-control" id="citta" name="citta" placeholder="name@example.com" required>
                  <label for="citta">Città *</label>
                </div> 

                <div class="form-floating mb-3 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-2">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="provincia" required>
                      <option selected="" disabled hidden></option>
                
                    <?php

                      $w=$conn->prepare("SELECT id_province, nome_province, sigla_province FROM province");
                      $w->execute();  
                      $r = $w->get_result();

                      while ($row = $r->fetch_assoc()) {
                        echo '<option value="'.$row['id_province'].'">'.$row['nome_province'].' ('.$row['sigla_province'].')</option>';
                      }

                
                    ?>

                    </select>
                    <label for="floatingSelect">Provincia *</label>
                  </div> 
            
                  <div class="form-floating mb-3 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-2">
                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="name@example.com" size="10" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" required>
                    <label for="telfono">Numero di telefono *</label>
                  </div>

                  <div class="form-floating mb-5 col-12 text-center">
                    <button type="submit" name="acquistoVeloce" class="btn btn-lg btn-success">INSERISCI</button>
                  </div>

                </form>

              </div>
    
    </section>

    <!-- FOOTER -->
    <?php footer2(); ?>
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