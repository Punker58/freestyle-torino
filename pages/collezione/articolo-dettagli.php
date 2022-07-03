<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();

    // ricevo i dati dell'articolo
    $_SESSION['articolo'] = $_GET['id'];
    $s3=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.prezzo_scontato, p.descrizione, p.categoria,
                                pf.id, pf.foto0, pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5, pf.foto6, pf.foto7, pf.foto8, pf.foto9,
                                t.n_taglia, c.n_colore, pv.quantita, p.in_sconto, ti.n_taglia as r
                        FROM prodotti as p
                        JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                        JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                        JOIN taglia as t ON t.id = pv.id_taglia
                        JOIN colore as c ON c.id = pv.id_colore
                        JOIN taglia as ti ON ti.id = p.descrizione2
                        WHERE pv.quantita > 0
                        AND p.id_prodotto = ?");	
    $s3->bind_param("i", $_SESSION['articolo']);	
    $s3->execute();  
    $r = $s3->get_result();

    while ($row = $r->fetch_assoc()) {
 
        $nome = $row['nome'];
        $categoria = $row['categoria'];

        if(isset($row['prezzo_scontato'])){
            $_SESSION['prezzo'] = $row['prezzo_scontato'];
        }else{
            $prezzo_scontato = null;
            $_SESSION['prezzo'] = $row['prezzo'];
        }

        $descrizione = $row['descrizione'];
        $descrizione2 = $row['r'];
        $foto = array($row['foto0'],$row['foto1'],$row['foto2'],$row['foto3'],$row['foto4'],
                    $row['foto5'], $row['foto6'],$row['foto7'],$row['foto8'],$row['foto9']);

    }

    
    // inserisci like
    if(isset($_POST['liked'])){
        //like inesistente quindi inserisco
        $s1=$conn->prepare("INSERT INTO likes (id_utente, prodotto) VALUES (?,?)");	
        $s1->bind_param("ii", $_SESSION['id'], $_POST['art_id']);	
        $s1->execute();  
        $s1->store_result();

        $s2=$conn->prepare("SELECT _like from prodotti WHERE id_prodotto = ?");	
        $s2->bind_param("i", $_POST['art_id']);	
        $s2->execute();  
        $r = $s2->get_result();

        while ($row = $r->fetch_assoc()) {
            $likeDB = $row['_like'];

            $likeFinale = $likeDB + 1;

            $s=$conn->prepare("UPDATE prodotti SET _like = ? WHERE id_prodotto = ?");	
            $s->bind_param("ii", $likeFinale, $_POST['art_id']);	
            $s->execute();  
            $s->store_result();
        }

    }  
    
    // rimuovi like
    if(isset($_POST['unliked'])){
        //like esistente quindi cancello
        $s1=$conn->prepare("DELETE FROM likes WHERE id_utente = ? AND prodotto = ?");	
        $s1->bind_param("ii", $_SESSION['id'], $_POST['art_id']);	
        $s1->execute();  
        $s1->store_result();

        $s2=$conn->prepare("SELECT _like from prodotti WHERE id_prodotto = ?");	
        $s2->bind_param("i", $_POST['art_id']);	
        $s2->execute();  
        $r = $s2->get_result();

        while ($row = $r->fetch_assoc()) {
            $likeDB = $row['_like'];

            $likeFinale = $likeDB - 1;

            $s=$conn->prepare("UPDATE prodotti SET _like = ? WHERE id_prodotto = ?");	
            $s->bind_param("ii", $likeFinale, $_POST['art_id']);	
            $s->execute();  
            $s->store_result();
        }

    }
    
?>

<!doctype html>
<html lang="it">
  <head>

    <?php 
        //meta tags + seo + css + js
        metaTags();
        seoTags();
        linkCss2();
        favicon2();
    ?>
    <title><?php echo $nome; ?> | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarCatalogo2(); navbarCatalogoMobile2(); freestyleLogo2(); ?>

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
                <p><?php echo $nome; ?></p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container text-center">
            <div class="row">

                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 bg-black">
                        <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                           
                                <?php

                                    echo '
                                        <div class="carousel-item active pt-5 pb-5" data-bs-interval="10000">
                                            <img class="zoom-dark ns" src="../../images/articoli/'.$categoria.'/'.$foto[0].'" alt="">
                                        </div>
                                        ';

                                    for($x=1; $x<10; $x++){
                                        if(isset($foto[$x])){
                                            echo'
                                                <div class="carousel-item pt-5 pb-5" data-bs-interval="10000">
                                                    <img class="zoom-dark ns" src="../../images/articoli/'.$categoria.'/'.$foto[$x].'" alt="">
                                                </div>
                                            ';
                                        }
                                    }
                                  
                                ?>

                <?php echo'
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>    
                    
                
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 bg-black">
                        <h1 class="mt-3 mb-3 t-dettagli">'.$nome.'<span class="float-end">'.$_SESSION['prezzo'].' €</span></h1>
                        <span>'.$descrizione.'</span></br>
    
                            <form action="../../config/server/action" method="post">    

                                <div class="row text-center">

                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6"><p class="fs-1 mt-5 t-dettagli">COLORE</p>
                                
                                    <select class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 form-select form-select-lg mt-5" aria-label=".form-select-lg example" name="id_colore" id="id_colore" required>
                            ';    

                                    echo '<option selected="true" hidden>SELEZIONA COLORE</option>';

                                    $s3=$conn->prepare("SELECT pv.id_prodotto, pv.quantita, pv.id_taglia, pv.id_colore,
                                                            t.n_taglia, c.n_colore
                                                        FROM prodotti_varianti as pv
                                                        JOIN taglia as t ON t.id = pv.id_taglia
                                                        JOIN colore as c ON c.id = pv.id_colore
                                                        WHERE pv.quantita > 0
                                                        AND pv.id_prodotto = ?
                                                        GROUP by c.n_colore");	
                                    $s3->bind_param("i", $_SESSION['articolo']);	
                                    $s3->execute();  
                                    $r = $s3->get_result();

                                    while ($row = $r->fetch_assoc()) {

                                    $_SESSION['articolo'] = $row['id_prodotto'];
                                    $_SESSION['id_colore'] = $row['id_colore'];
                                    $colore = $row['n_colore']; 
                                    $quantita = $row['quantita'];

                                    
                                    echo '<option value="'.$_SESSION['id_colore'].'">'.$colore.'</option>';
                                    }
                                        
                            echo '
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6" id="articolo">
                                        <div><p class="fs-1 mt-5 t-dettagli">TAGLIA</p>
                                            <select class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 form-select form-select-lg mt-5" aria-label=".form-select-lg example" disabled>
                                                <option selected>SELEZIONA PRIMA IL COLORE</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mt-5 mb-5">

                                        <input type="hidden" name="id" id="id" value="'.$_SESSION['articolo'].'" />
                                        <input type="hidden" name="prezzo" id="prezzo" value="'.$_SESSION['prezzo'].'" />
                                        <button type="submit" name="inserisciCarrello" class="btn bt-cy btn-lg">AGGIUNGI AL CARRELLO</button>
                                       
                                    </div>    

                                    <span class="mb-5">Il ragazzo nella foto indossa una '.$descrizione2.' ed è alto 1.70 con un peso di 70 kg</span>
                            </form>                
                                  
                </div>

            </div>';?>
           
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

    <!-- JS -->
    <script src="../../scripts/richiesta-articolo.js"></script>
    <?php 
      linkJs();
      jsInline2();
    ?>

  </body>
</html>