<?php 

    include 'config/link/function.php';
    include 'config/server/action.php';
    cookieUtente();
    cod_sconto();
    carrello();
    unset($_SESSION['articolo']);

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
    <title>Home | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarIndex(); navbarIndexMobile(); freestyleLogoIndex();?>

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

              <?php
              
                  $s2=$conn->prepare("SELECT sconto, descrizione from banner_home");	
                  $s2->execute();  
                  $r = $s2->get_result();
          
                  while ($row = $r->fetch_assoc()) {

                      $sconto = $row['sconto'];
                      $descrizione = $row['descrizione'];
          
                      echo '<p>'.$sconto.'% '.$descrizione.'</p>';
                  }
              
              ?>

            </div>
          </div>

        </div>
      </div>

    </section>

    <!-- ULTIMI ARRIVI -->
    <section id="margine20">
      <div class="container mt-5 mb-5">
        <h1>Ultimi arrivi</h1>
          <div class="row g-3">

          <?php

              $s=$conn->prepare("SELECT p.id, p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                      pf.id, pf.foto0,
                                      pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto
                                  FROM prodotti as p
                                  JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                                  JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                                  WHERE pv.quantita > 0
                                  GROUP by pf.id
                                  ORDER by p.id_prodotto DESC
                                  LIMIT 6
                                  ");		
              $s->execute();  
              $r = $s->get_result(); 

              while ($row = $r->fetch_assoc()) {

              $idr = $row['id'];
              $id = $row['id_prodotto'];
              $nome = $row['nome'];
              $prezzo = $row['prezzo'];
              $descrizione = $row['descrizione'];
              $categoria = $row['categoria'];
              $foto0 = $row['foto0'];
              $in_sconto = $row['in_sconto'];      
              
              echo '

              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4 text-center" style="cursor: pointer;" onclick="window.location=\'pages/collezione/articolo-dettagli?id='.$id.'&nome='.$nome.'\';">
                  <div class="card gap-3 mx-4">
                      <img class="card-img ns1" src="images/articoli/'.$categoria.'/'.$foto0.'" alt="articolo:'.$id.'" >
                          <div class="info">
                              <div class="text" onclick="window.location=\'pages/collezione/articolo-dettagli?id='.$id.'&nome='.$nome.'\';">

                                  <h3 class="text-uppercase">'.$nome.'</h3>
                                  <h3>'.$prezzo.' € </h3>

                              '; 

              echo'             
                          </div>
                      </div>
                  </div>    
              </div>';
          }

              ?>

          </div>
      </div>
    </section>

    <!-- TENDENZA -->
    <section id="margine20">
      <div class="container mt-5">
        <h1>Tendenza</h1>
          <div class="row">

            <?php

                $s=$conn->prepare("SELECT p.id, p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                        pf.id, pf.foto0,
                                        pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto
                                    FROM prodotti as p
                                    JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                                    JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                                    WHERE pv.quantita > 0
                                    GROUP by pf.id
                                    ORDER by p._like DESC
                                    LIMIT 3");		
                $s->execute();  
                $r = $s->get_result(); 

                while ($row = $r->fetch_assoc()) {

                $idr = $row['id'];
                $id = $row['id_prodotto'];
                $nome = $row['nome'];
                $prezzo = $row['prezzo'];
                $descrizione = $row['descrizione'];
                $categoria = $row['categoria'];
                $foto0 = $row['foto0'];
                $in_sconto = $row['in_sconto'];      
                
                echo '

                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4 text-center" style="cursor: pointer;" onclick="window.location=\'pages/collezione/articolo-dettagli?id='.$id.'&nome='.$nome.'\';">
                    <div class="card gap-3 mx-4">
                        <img class="card-img ns1" src="images/articoli/'.$categoria.'/'.$foto0.'" alt="articolo:'.$id.'" >
                            <div class="info">
                                <div class="text" style="cursor: pointer;" onclick="window.location=\'pages/collezione/articolo-dettagli?id='.$id.'&nome='.$nome.'\';">
  
                                    <h3 class="text-uppercase">'.$nome.'</h3>
                                    <h3>'.$prezzo.' € </h3>
  
                                '; 
  
                echo'             
                            </div>
                        </div>
                    </div>    
                </div>';
            }

            ?>

          </div>
      </div>
    </section>

    <!-- SOCIAL --->
    <section>

      <div class="container-fluid mt-5">
        <div class="row text-center">
          <div class="bg-black">
            <div class="row social">

              <div class="col-12"><h1>seguici su</h1></div>

              <div class="col-6">
                <a href="https://www.facebook.com/Freestyle_store_torino-106656785147597/"><i class="fab fa-facebook-square"></i></a>
              </div>

              <div class="col-6">
                <a href="https://www.instagram.com/freestyle_store_torino"><i class="fab fa-instagram"></i></a>
              </div>

            </div>
          </div>

            <div class="col-12">
              <div class="custom-shape-divider-top-1644926969">
                  <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                      <path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>
                  </svg>
              </div>
            </div>
        </div>

      </div>

    </section>

    <!-- MAPPA -->
    <section id="margine20">

      <div class="container mb-5 mt-5">
        <div class="row indirizzo">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-5">
            <img class="img-fluid zoom-dark" src="images/mappa.jpg" alt="mappa">
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 text-center">
            <h1>Il Negozio</h1>
            <p>Via Giuseppe Giacosa 2, Nichelino 10042 (TO)</p>
            <h1>Orari</h1>
            <table class="table">
              <thead>
              <tr>
                <td>Lun</td>
                <td>Mar/Ven</td>
                <td>Sab</td>
              </tr>
              </thead>
              <tbody>
                <tr>
                  <td data-label="Lun">15.00 - 19.30</td>
                  <td data-label="Mar-Ven">10.00 - 12.30/</br>15.00 - 19.30</td>
                  <td data-label="Sab">10.00 - 19.30</td>
                </tr>
              </tbody>
          </table>

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
    <?php 
      jsInline();
    ?>

  </body>
</html>