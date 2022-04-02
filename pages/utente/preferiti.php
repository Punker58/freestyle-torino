<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    if($_SESSION['id'] == null){echo'<script> location.replace("../../"); </script>';}
    
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
    <title>I miei Preferiti | Sito ufficiale FreestyleConceptStore</title>
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
                <p>I MIEI PREFERITI</p>
            </div>
          </div>

        </div>
      </div>

    </section>

    <section>
        <div class="container bg-black">
            <div class="row utente">

                <?php 
                        $s=$conn->prepare("SELECT l.id_utente, l.prodotto,
                                            p.nome, p.descrizione, p.categoria, p.prezzo,
                                            pf.foto1
                                            FROM likes AS l
                                            JOIN prodotti AS p ON p.id_prodotto = l.prodotto
                                            JOIN prodotti_foto AS pf ON pf.id_prodotto = l.prodotto
                                            WHERE l.id_utente = ?");
                        $s->bind_param('i', $_SESSION['id']);		
                        $s->execute();  
                        $r = $s->get_result();

                        if ($r->num_rows > 0) {

                            while ($row = $r->fetch_assoc()) {

                                $nome = $row['nome'];
                                $foto1 = $row['foto1'];
                                $categoria = $row['categoria'];
                                $descrizione = $row['descrizione'];
                                $prodotto = $row['prodotto'];
                                $prezzo = $row['prezzo'];

                                echo '
                                <div class="col-12 text-center mb-3 mt-3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 col-xxl-2"><img class="img-fluid mb-5 ns1" src="../../images/articoli/'.$categoria.'/'.$foto1.'"  alt=""></div>
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4"><h1 class="t-dettagli mb-3">'.$nome.'</h1></div>
                                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mt-3" style="overflow-x:auto !important;"">
                                      <table class="table t-carrello">
                                        <thead>
                                        <td>Descrizione</td>
                                        <td>Prezzo</td>
                                        <td>Azione</td>
                                        </thead>
                                        <tbody>
                                            <td data-label="Descrizione">'.$descrizione.'</td>
                                            <td data-label="Prezzo">'.$prezzo.' €</td>
                                            <td data-label="Azione">
                                                <form action="../../config/server/action" method="POST">
                                                    <input type="hidden" name="prodotto" value="'.$prodotto.'">
                                                    <button type="submit" name="eliminaLike" class="btn btn-light">RIMUOVI</button>
                                                </form>
                                            </td>
                                        </tbody>
                                      </table>
                                    </div>
                                </div>
                              </div>  
                                    ';
                            }

                        }else{
                            echo '
                            <div class="col-12 text-center mb-3 mt-3">
                                <p class="testoUtente">
                                    La tua lista preferiti è vuota.
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

    <!-- login -->
    <?php modalLogin2();?>

    <!-- registrazione-->
    <?php modalRegistrazione2();?>        

    <?php
        if(isset($_SESSION['notificaStato']) && $_SESSION['notificaStato'] == 1)
        {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Like rimosso con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";

            unset($_SESSION['notificaStato']);
        }
    ?>    

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>

  <!-- Extra JS -->

  </body>
</html>