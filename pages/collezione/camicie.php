<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    
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

    // filtri
    if(!isset($_GET['prezzo']))
    {
        $_GET['prezzo'] = null;
    }
    if(!isset($_GET['nome']))
    {
        $_GET['nome'] = null;
    }
    if(!isset($_GET['filtro']))
    {
        $_GET['filtro'] = null;
    }
    if(!isset($_GET['insconto']))
    {
        $_GET['insconto'] = null;
    }
    if(!isset($_GET['src']))
    {
        $_GET['src'] = null;
    }

    
    $rpp = 30;
    $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                            pf.id, pf.foto0, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                            pv.id, pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto,
                            c.n_categoria
                        FROM prodotti as p
                        JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                        JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                        JOIN categoria as c ON c.id = p.categoria
                        WHERE pv.quantita > 0
                        AND p.categoria = 5
                        GROUP BY p.id
                        ORDER by p.nome ".$_GET['nome'].", p.prezzo ".$_GET['prezzo']."");		
    $s->execute();  
    $r = $s->get_result(); 
    $r1 = $r->num_rows;    

    while ($row = $r->fetch_assoc()) {
        $nome=$row['nome'];
        $n_cat=$row['n_categoria'];
    }

    //determino il totale delle pagina disponibili
    $nop = ceil($r1/$rpp);
    //determino la pagina corrente
    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }
    $fr = ($page-1)*$rpp;
    
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
    <title>Camicie | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarCatalogo2(); navbarCatalogoMobile2(); freestyleLogo2(); ?>

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
                <p>Camicie</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container text-center">
            <div class="row">
            
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6"></div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 text-center">

                        <form action="" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="src" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2" required>
                                <button class="btn btn-dark" type="submit" id="button-addon2">Cerca</button>
                            </div>
                        </form>

                    </div>

                <div class="row">

                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3"><h1 class="text-center text-cat">Categorie</h1></div>
                        
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" onchange="location = this.value;">
                                <option <?php if( !isset($_GET['prezzo']) && !isset($_GET['nome']) && !isset($_GET['filtro']) && !isset($_GET['insconto'])){ echo 'selected';} ?> disabled style="display:none;">FILTRO</option>
                                <option <?php if( isset($_GET['prezzo']) && $_GET['prezzo'] == 'ASC' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&prezzo=ASC">PREZZO CRESCENTE</option>
                                <option <?php if( isset($_GET['prezzo']) && $_GET['prezzo'] == 'DESC' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&prezzo=DESC">PREZZO DECRESCENTE</option>
                                <option <?php if( isset($_GET['nome']) && $_GET['nome'] == 'ASC' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&nome=ASC">ORDINE: A-Z</option>
                                <option <?php if( isset($_GET['nome']) && $_GET['nome'] == 'DESC' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&nome=DESC">ORDINE: Z-A</option>
                                <option <?php if( isset($_GET['filtro']) && $_GET['filtro'] == 'DESC' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&filtro=DESC">ULTIMI ARRIVI</option>
                                <option <?php if( isset($_GET['insconto']) && $_GET['insconto'] == 'SI' ){ echo 'selected';} ?> value="<?php echo strtolower($n_cat); ?>?page=1&insconto=SI">IN SCONTO</option>
                            </select>
                        </div>

                    </div>

                    <p class="text-center fs-1 text-cat2">Categorie</p>
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 mt-5">
                        <div class="cat-categoria">
                            <?php
                                $a="SI";
                                    $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                                    $s->bind_param("s", $a);
                                    $s->execute();  
                                    $r = $s->get_result(); 
                            
                                    while ($row = $r->fetch_assoc()) {
                            
                                        $id = $row['id'];
                                        $n_cat = $row['n_categoria'];
                                        $attiva = $row['attiva'];
                            
                                        echo '
                                            <li><a class="dropdown-item" href="'.strtolower($n_cat).'">'.$n_cat.'</a></li>
                                        ';
                                    }
                            ?>
                        </div>
                    </div>

                    <?php

                        if(isset($_GET['prezzo'])){
                            $i = 'p.prezzo ' . $_GET['prezzo'];
                            $s = null;
                        }
                        elseif(isset($_GET['nome'])){
                            $i = 'p.nome ' . $_GET['nome'];
                            $s = null;
                        }
                        elseif(isset($_GET['filtro'])){
                            $i = 'p.id ' . $_GET['filtro'];
                            $s = null;
                        }
                        elseif(isset($_GET['insconto'])){
                            $s = "AND p.in_sconto = 'SI'";
                            $i = "p.prezzo  ASC";
                        }
                        elseif(isset($_GET['src'])){
                            $s = "AND p.nome LIKE '%".$_GET['src']."%'";
                            $i = "p.prezzo  ASC";
                        }
                        else { $i = 'p.id'; $s = null;}      
                                        
                        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.prezzo_scontato, p.descrizione, p.categoria, p.in_sconto,
                                                pf.id, pf.foto0,
                                                pv.id, pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto,
                                                c.n_categoria
                                            FROM prodotti as p
                                            LEFT JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                                            LEFT JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                                            LEFT JOIN categoria as c ON c.id = p.categoria
                                            WHERE pv.quantita > 0
                                            AND p.categoria = 5
                                            ".$s."
                                            GROUP BY p.id
                                            ORDER by ".$i." 
                                            LIMIT ".$fr.','.$rpp);		
                        $s->execute();  
                        $r = $s->get_result(); 
                        $r2 = $r->num_rows;                      
                    ?>

                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-xxl-9">
                        <div id="output" class="row">
                            
                            <?php
                                if ($r->num_rows > 0) {
                                    
                                    while ($row = $r->fetch_assoc()) {

                                    $idr = $row['id'];
                                    $_SESSION['articolo'] = $row['id_prodotto'];
                                    $nome = $row['nome'];

                                    if(isset($row['prezzo_scontato'])){
                                        $prezzo = $row['prezzo_scontato'];
                                    }else{
                                        $prezzo_scontato = null;
                                        $prezzo = $row['prezzo'];
                                    }

                                    $descrizione = $row['descrizione'];
                                    $_SESSION['categoria'] = $row['categoria'];
                                    $n_cat1 = $row['n_categoria'];
                                    $foto0 = $row['foto0'];
                                    $in_sconto = $row['in_sconto'];

                                    // check like
                                    $s1=$conn->prepare("SELECT p.id_prodotto, l.prodotto, l.id_utente
                                                        FROM likes as l
                                                        JOIN prodotti  as p ON p.id_prodotto =  l.prodotto
                                                        WHERE l.id_utente = ?
                                                        AND l.prodotto = ?
                                                        GROUP BY l.id");	
                                    $s1->bind_param("ii", $_SESSION['id'], $_SESSION['articolo']);	
                                    $s1->execute();  
                                    $s1->store_result(); 

                                    echo '

                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4 text-center" style="cursor: pointer;" onclick="window.location=\'articolo-dettagli?id='.$_SESSION['articolo'].'&nome='.$nome.'\';">
                                        <div class="card gap-3 mx-4">
                                            <img class="card-img ns1" src="../../images/articoli/'.$_SESSION['categoria'].'/'.$foto0.'" alt="articolo:'.$id.'" >
                                                <div class="info">
                                                    <div class="text" style="cursor: pointer;" onclick="window.location=\'articolo-dettagli?id='.$_SESSION['articolo'].'&nome='.$nome.'\';">

                                                        <h5 class="text-uppercase">'.$nome.'</h5>
                                                        <h3>'.$prezzo.' € </h3>

                                                    ';
                                                        if (isset($_SESSION['id'])) {
                                                            if ($s1->num_rows > 0) {
                    
                                                                echo '
                                                                    <span class="unlike ol" data-id="'.$_SESSION['articolo'].'"><i class="fas fa-heart text-black"></i></span>
                                                                    ';
                                                            }
                                                            else{
                                                                echo '
                                                                    <span class="like ol" data-id="'.$_SESSION['articolo'].'"><i class="fas fa-heart"></i></span>
                                                                    ';
                                                            }
                                                        }  

                                    echo'             
                                                </div>
                                            </div>
                                        </div>    
                                    </div>';
                                }
                            ?>
                            
                            <nav aria-label="...">
                                <ul class="pagination pagination-lg float-end mt-5">
                                    <li class="page-item active" aria-current="page">
                                        <?php
                                            if(isset($_GET['page'])){
                                                $page = $_GET['page'];
                                            }
                                            else{
                                                $page=1;
                                            }    

                                            //mostra link delle pagine
                                            if(isset($nop)){
                                                for($i=1;$i<=$nop;$i++){
                                                    if(isset($_GET['prezzo'])){
                                                        echo '<li class="page-item"><a class="page-link" href="'.strtolower($n_cat1.'?page=').''.$i.'&prezzo='.$_GET['prezzo'].'">'.$i.'</a></li>';
                                                    }
                                                    elseif(isset($_GET['nome'])){
                                                        echo '<li class="page-item"><a class="page-link" href="'.strtolower($n_cat1.'?page=').''.$i.'&nome='.$_GET['nome'].'">'.$i.'</a></li>';
                                                    }
                                                    elseif(isset($_GET['filtro'])){
                                                        echo '<li class="page-item"><a class="page-link" href="'.strtolower($n_cat1.'?page=').''.$i.'&filtro='.$_GET['filtro'].'">'.$i.'</a></li>';
                                                    }
                                                    elseif(isset($_GET['insconto'])){
                                                        echo '<li class="page-item"><a class="page-link" href="'.strtolower($n_cat1.'?page=').''.$i.'&insconto='.$_GET['insconto'].'">'.$i.'</a></li>';
                                                    }
                                                    else{
                                                        echo '<li class="page-item"><a class="page-link" href="'.strtolower($n_cat1.'?page=').''.$i.'">'.$i.'</a></li>';                                                
                                                    }
                                                }
                                            } 

                                        }else{
                                            echo '<h2 class="mt-5">Nessun risultato</h2>';
                                        }

                                        ?>
                                    </li> 
                                </ul>
                            </nav>
                        </div> <!-- chiusura row -->    
                    </div>
                </div>
            </div>

    </section>

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>
    <!-- Extra JS -->
    <script type="text/javascript">
        $(document).ready(function(){
            //like
            $('.like').on('click', function(){
                var art_id = $(this).data('id');

                $.ajax({
                    url: '<?php echo strtolower($n_cat1);?>',
                    type: 'post',
                    data: {
                        'liked': 1,
                        'art_id': art_id
                    },
                    success: function(response){
                        location.reload();
                    }
                });
		    });
            // unlike
            $('.unlike').on('click', function(){
                var art_id = $(this).data('id');

                $.ajax({
                    url: '<?php echo strtolower($n_cat1);?>',
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'art_id': art_id
                    },
                    success: function(response){
                        location.reload();
                    }
                });
		    });
        });
    </script>

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
    
  </body>
</html>