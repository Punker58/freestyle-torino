<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    if($_SESSION['id'] == null && $_SESSION['cognome'] == null ){echo'<script> location.replace("../../"); </script>';}
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
    <title>I miei dati | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarAccount2(); navbarAccountMobile2(); freestyleLogo2(); ?>

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
                <p>I MIEI DATI</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">
            <div class="row utente">
                <div class="col-12 text-center mb-3 mt-3">
                    <p class="testoUtente">Qui di seguito trovi il riepilogo dei tuoi dati personali.</br>
                        Per gestire e modificare i tuoi dati clicca sul tasto modifica.
                    </p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-5">
                    <?php
                    
                        echo '<p class="t-dettagli d-inline">NOME/COGNOME: </p><p class="d-inline">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</p></br>';
                        echo '<p class="t-dettagli d-inline">E-MAIL: </p><p class="d-inline">'.$_SESSION['email'].'</p></br>';
                        echo '<p class="t-dettagli d-inline">NUMERO DI TELEFONO: </p><p class="d-inline">'.$_SESSION['telefono'].'</p></br>';
                        if(isset($_SESSION['campanello'])){echo '<p class="t-dettagli d-inline">NOME SUL CAMPANELLO: </p><p class="d-inline">'.$_SESSION['campanello'].'</p><br>';}
                        echo '<p class="t-dettagli d-inline">INDIRIZZO: </p><p class="d-inline">'.$_SESSION['indirizzo'].', '.$_SESSION['citta'].' '.$_SESSION['cap'].' ('.$_SESSION['provincia'].')</p></br>';
                    ?>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-5">
                    <button type="button" class="btn btn-lg btn-light float-end" data-bs-toggle="modal" data-bs-target="#modal2">MODIFICA</button>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>


    <!-- SEZIONE MODAL -->

    <!-- modifica -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-black border border-warning">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifica</h5>
            <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">

            <form action="../../config/server/action" method="post">

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingnome" name="nome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" >
                  <label for="floatingnome">Nome</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="cognome" name="cognome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" >
                  <label for="cognome">Cognome</label>
                </div>

                <hr>
                <h1>INDIRIZZO DI SPEDIZIONE</h1>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="campanello" name="campanello" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;">
                  <label for="campanello">Nome campanello</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" >
                  <label for="indirizzo">Indirizzo</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="citta" name="citta" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" >
                  <label for="citta">Città</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="cap" name="cap" placeholder="name@example.com" size="5" onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;" >
                  <label for="cap">Cap</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="provincia" name="provincia" placeholder="name@example.com" >
                  <label for="cap">Provincia</label>
                </div>

                <div class="form-floating mb-3">
                  <input type="number" class="form-control" id="telefono" name="telefono" placeholder="name@example.com" size="10" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" >
                  <label for="telefono">Telefono</label>
                </div>

                <div class="form-floating mb-3">
                <button type="submit" class="btn btn-success" name="modificaUtente">Invia</button>
                </div>

              </form>

            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- SEZIONE MODAL -->

    <!-- login -->
    <?php modalLogin2();?>

    <!-- registrazione-->
    <?php modalRegistrazione2();?>    

  <!-- Notifiche -->

  <?php
    if(isset($_SESSION['utenteNotifica']) && $_SESSION['utenteNotifica'] == 1)
    {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                text: 'Modifica avvenuta con successo.',
                timer: 2000,
                showConfirmButton: false});
        </script>
        ";

        unset($_SESSION['utenteNotifica']);
    }
  ?>

  <!-- Extra JS -->

  </body>
</html>