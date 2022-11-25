<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    //if($_SESSION['id'] == null){header('Location: ../../');}
    
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
                <p>CARRELLO</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">
            <div class="row utente">
              <?php 
                    $complessivo = 0;
                    $s=$conn->prepare("SELECT c.id as riga, c.id_utente, c.id_prodotto, c.id_colore, c.id_taglia, c.n_quantita,
                                          t.n_taglia, t.id,
                                          co.n_colore, co.id,
                                          p.nome, p.descrizione, p.categoria, p.prezzo, p.prezzo_scontato,
                                          pf.foto0                              
                                        FROM carrello as c
                                        JOIN taglia as t ON t.id = c.id_taglia
                                        JOIN colore as co ON co.id = c.id_colore
                                        JOIN prodotti as p ON p.id_prodotto = c.id_prodotto
                                        JOIN prodotti_foto as pf ON pf.id_prodotto = c.id_prodotto
                                        WHERE c.id_utente = ?");
                    $s->bind_param('s', $_SESSION['cod_carrello']);		
                    $s->execute();  
                    $r = $s->get_result();

                    if ($r->num_rows > 0) {

                      echo 
                        '
                          <div class="col-12 text-center mb-3 mt-3">
                            <h1 class="float-end">Articoli:'.$r->num_rows.'</h1>
                          </div>                    
                        ';

                      while ($row = $r->fetch_assoc()) {

                      $riga = $row['riga']; //id riga
                      $id_prodotto = $row['id_prodotto'];
                      $id_colore = $row['id_colore'];
                      $colore = $row['n_colore'];
                      $id_taglia = $row['id_taglia'];
                      $taglia = $row['n_taglia'];

                      if(isset($row['prezzo_scontato'])){
                        $prezzo_singolo = $row['prezzo_scontato'];
                      }elseif(isset($_SESSION['complessivoScontato'])){
                          $prezzo_singolo = $_SESSION['complessivoScontato'];
                      }else{
                          $prezzo_scontato = null;
                          $prezzo_singolo = $row['prezzo'];
                      }

                      $quantita = $row['n_quantita'];
                      $prezzo_totale = $prezzo_singolo * $quantita;
                      $nome = $row['nome'];
                      $descrizione = $row['descrizione'];
                      $foto1 = $row['foto0'];
                      $categoria = $row['categoria'];

                      echo 
                        '
                          <div class="col-12 text-center mb-3 mt-3">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 col-xxl-2"><img class="img-fluid mb-5 ns1" src="../../images/articoli/'.$categoria.'/'.$foto1.'" height="300vh" width="220vh" alt=""></div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4"><h1 class="t-dettagli mb-3">'.$nome.'</h1><span class="mb-5">'.$descrizione.'</span></div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-3" style="overflow-x:auto !important;"">
                                  <table class="table t-carrello">
                                    <thead>
                                      <tr>
                                        <td scope="col" class="t-dettagli">colore</td>
                                        <td scope="col">taglia</td>
                                        <td scope="col" class="t-dettagli">prezzo singolo</td>
                                        <td scope="col">quantità</td>
                                        <td scope="col" class="t-dettagli">prezzo totale</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td scope="row" data-label="Colore" class="t-dettagli">'.$colore.'</td>
                                        <td data-label="Taglia">'.$taglia.'</td>
                                        <td data-label="P. singolo" class="t-dettagli">'.$prezzo_singolo.' €</td>

                                        <td data-label="Quantità"> 
                                        
                                          <form action="../../config/server/action" method="post">
                                            <input type="hidden" name="riga" value="'.$riga.'">
                                            <input type="hidden" name="id" value="'.$id_prodotto.'">
                                            <input type="hidden" name="quantita" value="'.$quantita.'">
                                            <input type="hidden" name="prezzo" value="'.$prezzo_singolo.'">
                                            <button class="btn fas fa-minus-circle b58" name="diminuisciQuantita"></button> 
                                          </form>
                                          '.$quantita.'
                                          <form action="../../config/server/action" method="post">
                                            <input type="hidden" name="riga" value="'.$riga.'">
                                            <input type="hidden" name="id" value="'.$id_prodotto.'">
                                            <input type="hidden" name="quantita" value="'.$quantita.'">
                                            <input type="hidden" name="prezzo" value="'.$prezzo_singolo.'">
                                            <button class="btn fas fa-plus-circle b58" name="incrementaQuantita"></button> 
                                          </form>
                                        
                                        </td>

                                        <td data-label="Prezzo Totale" class="t-dettagli">'; ?> <?php if($prezzo_totale < 0) { echo '0 (SCONTO)';}else{ echo number_format($prezzo_totale,2);} ?> <?php echo'€</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>
                        ';

                        $complessivo += $prezzo_totale;
                        $complessivo2 = $complessivo + 7;
                      }

                      echo 
                      '
                      <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-8"></div>
                      <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-4 mt-3 mb-5 float-end" style="overflow-x:auto !important;"">
                        <table class="table t-carrello">
                          <tbody>
                            <tr>
                              <td class="t-dettagli">TOTALE</td>
                              <td ">'.number_format($complessivo,2).' €</td>
                            </tr>
                            <tr>
                              <td class="t-dettagli">SPEDIZIONE</td>
                              <td >7.00 €</td>
                            </tr>
                            <tr>
                              <td class="t-dettagli">COMPLESSIVO</td>
                              <td> '.number_format($complessivo2,2).' €</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-5 text-center">
                          <a href="../../pages/carrello/checkout" class="btn btn-lg btn-light mb-5"> PROCEDI ALL\'ORDINE</a>
                        </div>


                      ';

                    }
                    
                  else

                    {

                      echo 
                      '
                        <div class="col-12 text-center mb-3 mt-3">
                          <p class="testoUtente">
                              il carrello è vuoto.
                          </p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-5 text-center">
                            <a href="../../pages/collezione/tutta-la-collezione" class="btn btn-lg btn-light"> CONTINUA LO SHOPPING</a>
                        </div>
                      
                      ';
                    }

              ?>

            </div>
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