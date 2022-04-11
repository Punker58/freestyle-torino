<?php 

    include '../../config/server/action.php';
    include '../../config/link/function.php';
    cookieAdmin();
    
    if( $_SESSION['ruolo'] != 10) {echo'<script> location.replace("../../"); </script>';}

    if(isset($_GET['order']) && $_GET['order'] == 'DESC') {
        $i = 'ORDER BY p.id DESC';
    }
    elseif (isset($_GET['order']) && $_GET['order'] == 'ASC'){
        $i = 'ORDER BY p.id ASC';
    }
    elseif (isset($_GET['price']) && $_GET['price'] == 'DESC'){
        $i = 'ORDER BY p.prezzo DESC';
    }
    elseif (isset($_GET['price']) && $_GET['price'] == 'ASC'){
        $i = 'ORDER BY p.prezzo ASC';
    }
    elseif (isset($_GET['like']) && $_GET['like'] == 'ASC'){
        $i = 'ORDER BY p._like ASC';
    }
    elseif (isset($_GET['like']) && $_GET['like'] == 'DESC'){
        $i = 'ORDER BY p._like DESC';
    }
    elseif (isset($_GET['qty']) && $_GET['qty'] == 'ASC'){
        $i = 'ORDER BY pv.quantita ASC';
    }
    elseif (isset($_GET['qty']) && $_GET['qty'] == 'DESC'){
        $i = 'ORDER BY pv.quantita DESC';
    }
    else {
        $i = 'ORDER BY p.id DESC';
    }

    $rpp = 50; // numero articoli a schermo
    $s=$conn->prepare("SELECT p.id, p.id_prodotto, p.nome, p.prezzo, p.descrizione,  p.categoria,
                                pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                pv.quantita, p._like, p.in_sconto,
                                c.n_colore,
                                t.n_taglia,
                                ca.n_categoria
                        FROM prodotti as p
                        JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                        JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                        JOIN colore as c ON c.id = pv.id_colore
                        JOIN taglia as t ON t.id = pv.id_taglia
                        JOIN categoria as ca ON ca.id = p.categoria
                        $i");		
    $s->execute();  
    $rm = $s->get_result();
    $r1 = $rm->num_rows;  

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
        //funzioni invocate
        metaTags();
        linkCssAdmin();
        favicon2();
        linkJs();
    ?>
    <title>Articoli</title>
  </head>

  <body>

    <div class="d-flex" id="wrapper">

        <?php sidebarAdminArticoli2(); ?>

        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Articoli</h2>
                </div>
            </nav> 

            <div class="container-fluid px-4">

                <div class="row g-3 my-2">

                    <!-- AGGIUNGI ARTICOLO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art1">
                            <div>
                                <p class="fs-5">Aggiungi Articolo</p>
                            </div>
                                <i class="fas fa-pen fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
              
                    <div class="modal fade" id="art1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiungi articolo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" autocomplete="off">

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="categoria" placeholder="CATEGORIA" required>

                                        <?php

                                            $s=$conn->prepare("SELECT * FROM categoria");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $nome = $row['n_categoria'];
                                            
                                                echo '<option value="'.$id.'">'.$nome.'</option>';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingCategoria">CATEGORIA</label>

                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingId" name="id_prodotto" placeholder="ID">
                                    <label for="floatingId">ID(es. 1000 / utilizzare da 1000 in poi)</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingNome" name="nome" placeholder="NOME">
                                    <label for="floatingNome">NOME</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingDesc" name="descrizione" placeholder="DESCRIZIONE">
                                    <label for="floatingDesc">DESCRIZIONE</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="floatingPrezzo" name="prezzo" placeholder="PREZZO" step=".01">
                                    <label for="floatingPrezzo">PREZZO (es. 10.99)</label>
                                </div>

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingDescrizione2" name="descrizione2" placeholder="DESCRIZIONE2" required>

                                        <?php

                                            $s=$conn->prepare("SELECT * FROM taglia");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $n_taglia = $row['n_taglia'];
                                            
                                                echo '<option value="'.$id.'">'.$n_taglia.'</option>';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingCategoria">IL RAGAZZO INDOSSA:</label>

                                </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="inserisciArticolo">Inserisci</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- AGGIUNGI VARIANTE -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art2">
                            <div>
                                <p class="fs-5">Aggiungi Variante</p>
                            </div>
                                <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiungi Variante</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" autocomplete="off">

                                <div class="form-floating mb-3">

                                    <input type="text" class="form-control mb-3" id="sArticolo2">
                                    <label for="sArticolo2">CERCA ARTICOLO (Scrivere il nome per intero)</label>
                                    

                                    <div id="output2"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>
                                    
                                </div>

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingColore" name="colore" placeholder="COLORE">

                                        <?php

                                            $s=$conn->prepare("SELECT * FROM colore");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $nome = $row['n_colore'];
                                            
                                                echo '<option value="'.$id.'">'.$nome.'</option>';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingColore">COLORE</label>

                                </div>

                                <div class="form-floating mb-3">

                                    <input type="number" class="form-control mb-3" id="sArticolo8" name="slot">
                                    <label for="sArticolo8">SLOT</label>
                                    

                                    <div id="output8"><p style="text-align:center;">Inserisci prima il numero dei slot.</p></div>
                                    
                                </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="inserisciVarArticolo">Inserisci</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- AGGIUNGI FOTO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art3">
                            <div>
                                <p class="fs-5">Aggiungi Foto</p>
                            </div>
                                <i class="fas fa-camera fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiungi Foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" enctype="multipart/form-data" autocomplete="off">

                                    <div class="form-floating mb-3">

                                        <input type="text" class="form-control mb-3" id="sArticolo3">
                                        <label for="sArticolo3">CERCA ARTICOLO (Scrivere il nome per intero)</label>

                                        <div id="output3"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>

                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control" name="foto[]" multiple="multiple" required>                               
                                    </div> 

                                    <div class="form-floating mb-3">
                                        <p>2 FOTO OBBLIGATORIE*</p>
                                        <p>MASSIMO DI FOTO CONSENTITE 10</p>
                                    </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="inserisciFotoArticolo">Inserisci</button>
                                </div>

                                </form>
                                
                            </div>
                        </div>
                    </div>  
                    
                    <!-- ELIMINA FOTO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art8">
                            <div>
                                <p class="fs-5">Elimina Foto</p>
                            </div>
                                <i class="fas fa-trash-alt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art8" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Elimina foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" enctype="multipart/form-data" autocomplete="off">

                                    <div class="form-floating mb-3">

                                        <input type="text" class="form-control mb-3" id="sArticolo9">
                                        <label for="sArticolo9">SELEZIONA ARTICOLO</label>

                                        <div id="output9"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>

                                    </div>

                                    <p>COSA FA:</p>
                                    <ul class="text-danger">
                                        <li>CANCELLA LE FOTO DALLA CARTELLA</li>
                                        <li>CANCELLA LE FOTO DAL DATABASE (DICITURA)</li>
                                    </ul>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="eliminaFoto">Elimina</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>   


                    <!--########################
                    ##### SEZIONE AGGIORNA #####
                    ############################-->


                    <!-- AGGIORNA ARTICOLO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art5">
                            <div>
                                <p class="fs-5">Aggiorna Articolo</p>
                            </div>
                                <i class="fas fa-pen-alt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiorna articolo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" autocomplete="off">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control mb-3" id="sArticolo5">
                                        <label for="sArticolo5">CERCA ARTICOLO (Scrivere il nome per intero)</label>


                                        <div id="output5"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>
                                    </div>

                                    <div class="form-floating mb-3">

                                        <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="categoria" placeholder="CATEGORIA">

                                            <?php

                                                $s=$conn->prepare("SELECT * FROM categoria");
                                                $s->execute();  
                                                $r = $s->get_result(); 

                                                while ($row = $r->fetch_assoc()) {

                                                    $id = $row['id'];
                                                    $nome = $row['n_categoria'];
                                                
                                                    echo '<option style="display:none"></option><option value="'.$id.'">'.$nome.'</option>';

                                                }
                                                
                                            ?>   
                                            
                                        </select>
                                        <label for="floatingCategoria">CATEGORIA</label>

                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingNome" name="nome" placeholder="NOME">
                                        <label for="floatingNome">NOME</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingDesc" name="descrizione" placeholder="DESCRIZIONE">
                                        <label for="floatingDesc">DESCRIZIONE</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingPrezzo" name="prezzo" placeholder="PREZZO">
                                        <label for="floatingPrezzo">PREZZO</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-control "name="sconto" id="floatingSconto">
                                            <option value="NO">NO</option>
                                            <option value="SI">SI</option>
                                        </select>
                                        <label for="floatingSconto">SCONTO</label>
                                    </div>

                            </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="aggiornaArticolo">Aggiorna</button>
                                    </div>

                            </form>
                            </div>
                        </div>
                    </div>   
                    
                    <!-- AGGIORNA VARIANTE -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art6">
                            <div>
                                <p class="fs-5">Aggiorna Variante</p>
                            </div>
                                <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiorna Variante</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" autocomplete="off">

                                <div class="form-floating mb-3">

                                    <input type="text" class="form-control mb-3" id="sArticolo6">
                                    <label for="sArticolo6">CERCA ARTICOLO (Scrivere il nome per intero)</label>
                                    

                                    <div id="output6"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>
                                    
                                </div>

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingTaglia" name="taglia" placeholder="TAGLIA">

                                        <?php

                                            $s=$conn->prepare("SELECT * FROM taglia");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $nome = $row['n_taglia'];
                                            
                                                echo '<option value="'.$id.'">'.$nome.'</option>';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingTaglia">TAGLIA</label>

                                </div>

                                <div class="form-floating mb-3">

                                    <select class="form-select" aria-label="Default select example" id="floatingColore" name="colore" placeholder="COLORE">

                                        <?php

                                            $s=$conn->prepare("SELECT * FROM colore");
                                            $s->execute();  
                                            $r = $s->get_result(); 

                                            while ($row = $r->fetch_assoc()) {

                                                $id = $row['id'];
                                                $nome = $row['n_colore'];
                                            
                                                echo '<option value="'.$id.'">'.$nome.'</option>';

                                            }
                                            
                                        ?>

                                    </select>
                                    <label for="floatingColore">COLORE</label>

                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingQuan" name="quantita" placeholder="QUANTITÀ">
                                    <label for="floatingQuan">QUANTITÀ</label>
                                </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="aggVarArticolo">Inserisci</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>                    
                    
                    <!-- AGGIORNA FOTO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art4">
                            <div>
                                <p class="fs-5">Aggiorna Foto</p>
                            </div>
                                <i class="fas fa-camera-retro fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiorna Foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" enctype="multipart/form-data" autocomplete="off">

                                    <div class="form-floating mb-3">

                                        <input type="text" class="form-control mb-3" id="sArticolo4">
                                        <label for="sArticolo4">CERCA ARTICOLO (Scrivere il nome per intero)</label>

                                        <div id="output4"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>

                                    </div>

                                    <div class="row">

                                        
                                            <?php
                                                for($zi=0; $zi<10; $zi++){
                                                    echo'<div class="form-floating mb-3 col-8">';
                                                    echo   '<input type="file" class="form-control" name="foto'.$zi.'" >';
                                                    echo '</div>';
                                                    $a = $zi+1;
                                                    echo 'SLOT:  '.$a;
                                                }
                                            ?>                                 

                                    </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="aggiornaFotoArticolo">Aggiorna</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div> 
                    
                    <!-- ELIMINA ARTICOLO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art7">
                            <div>
                                <p class="fs-5">Elimina articolo</p>
                            </div>
                                <i class="fas fa-trash-alt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>

                    <div class="modal fade" id="art7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Elimina articolo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST" enctype="multipart/form-data" autocomplete="off">

                                    <div class="form-floating mb-3">

                                        <input type="text" class="form-control mb-3" id="sArticolo7">
                                        <label for="sArticolo7">SELEZIONA ARTICOLO</label>

                                        <div id="output7"><p style="text-align:center;">Usa il campo di ricerca</br> per visualizzare gli articoli.</p></div>

                                    </div>

                                    <p>COSA FA:</p>
                                    <ul class="text-danger">
                                        <li>CANCELLA L'ARTICOLO</li>
                                        <li>CANCELLA OGNI VARIANTE</li>
                                        <li>CANCELLA TUTTE LE FOTO</li>
                                    </ul>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="eliminaTot">Elimina</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>                     

                </div>

            </div>

            <div class="container-fluid px-4">

                <div class="row my-5">
                    <div class="col-12">
                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3 float-end mb-5">
                            <select class="form-select form-select-lg" aria-label="Large select" onchange="location = this.value;">
                                <option <?php if(!isset($_GET['order']) && !isset($_GET['price'])){ echo 'selected';} ?> disabled hidden>FILTRO</option>
                                <option <?php if(isset($_GET['order']) && $_GET['order'] == 'DESC'){ echo 'selected';} ?> value="articoli?order=DESC">Più recenti</option>
                                <option <?php if(isset($_GET['order']) && $_GET['order'] == 'ASC'){ echo 'selected';} ?> value="articoli?order=ASC">Meno recenti</option>
                                <option <?php if(isset($_GET['price']) && $_GET['price'] == 'DESC'){ echo 'selected';} ?> value="articoli?price=DESC">Prezzo alto</option>
                                <option <?php if(isset($_GET['price']) && $_GET['price'] == 'ASC'){ echo 'selected';} ?> value="articoli?price=ASC">Prezzo basso</option>
                                <option <?php if(isset($_GET['like']) && $_GET['like'] == 'DESC'){ echo 'selected';} ?> value="articoli?like=DESC">Più Like</option>
                                <option <?php if(isset($_GET['like']) && $_GET['like'] == 'ASC'){ echo 'selected';} ?> value="articoli?like=ASC">Meno Like</option>
                                <option <?php if(isset($_GET['qty']) && $_GET['qty'] == 'DESC'){ echo 'selected';} ?> value="articoli?qty=DESC">Quantità Maggiore</option>
                                <option <?php if(isset($_GET['qty']) && $_GET['qty'] == 'ASC'){ echo 'selected';} ?> value="articoli?qty=ASC">Quantità Minore</option>
                            </select>
                        </div>
                    </div>
                    <div class="t1 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">ID</th>
                                    <th scope="col">Nome</th>
                                    <th>Prezzo</th>
                                    <th scope="col">Descrizione</th>    
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Colore - Taglia - Quantità</th>
                                    <th scope="col">Like</th>
                                    <th scope="col">Sconto</th>
                                    <th scope="col">Azione</th>
                                </tr>
                            </thead>

                            <?php

                                $s=$conn->prepare("SELECT GROUP_CONCAT(c.n_colore, ' - ',t.n_taglia, ' - ', pv.quantita SEPARATOR '<br>') AS variante,
                                                            GROUP_CONCAT(pv.id) as id,
                                                            p.id_prodotto, p.nome, p.prezzo, p.descrizione,  p.categoria,
                                                            pf.foto0, pf.foto1, pf.foto2,pf.foto3, pf.foto4, pf.foto5, pf.foto6, pf.foto7, pf.foto8, pf.foto9,
                                                            p._like, p.in_sconto, 
                                                            ca.n_categoria
                                                    FROM prodotti as p
                                                    JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                                                    JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                                                    JOIN colore as c ON c.id = pv.id_colore
                                                    JOIN taglia as t ON t.id = pv.id_taglia
                                                    JOIN categoria as ca ON ca.id = p.categoria
                                                    GROUP BY p.id
                                                    $i
                                                    LIMIT ".$fr.','.$rpp);		
                                $s->execute();  
                                $rm = $s->get_result();                              

                                while ($row = $rm->fetch_assoc()) {

                                    $id = $row['id_prodotto'];
                                    $nome = $row['nome'];
                                    $prezzo = $row['prezzo'];
                                    $descrizione = $row['descrizione'];
                                    $categoria = $row['n_categoria'];
                                    $foto = array($row['foto0'], $row['foto1'], $row['foto2'] , $row['foto3'],$row['foto4'],
                                                $row['foto5'], $row['foto6'], $row['foto7'], $row['foto8'], $row['foto9']);
                                    $var = $row['variante'];
                                    $like = $row['_like'];
                                    $in_sconto = $row['in_sconto'];
                                    $id_categoria = $row['categoria'];
                                    $idr = explode(",", $row['id']);
                                    

                                    echo 
                                        '
                                        <tr>
                                            <th scope=\"row\">'.$id.'</th>
                                            <td>'.$nome.'</td>
                                            <td>'.$prezzo.' €</td>
                                            <td>'.$descrizione.'</td>
                                            <td>'.$categoria.'</td>
                                            <td>
                                        ';    
                                ?>
                                        <?php
                                        
                                            for($x = 0; $x < 10; $x++){

                                                if(isset($foto[$x])){
                                                    echo '<img class="zoom" src="../../images/articoli/'.$id_categoria.'/'.$foto[$x].'" alt="foto" width="50" height="50">';
                                                }

                                            }

                                        ?>
                                <?php    
                                    echo'            
                                            </td>
                                            <td class="text-break">'.$var.'</td>
                                            <td>'.$like.'</td>
                                            <td>'.$in_sconto.'</td>
                                        ';

                                        $s1=$conn->prepare("SELECT id FROM prodotti_varianti WHERE id_prodotto = ?");
                                        $s1->bind_param("i", $id);
                                        $s1->execute();  
                                        $s1->store_result(); 
                                        $c = $s1->num_rows;
                                        
                                        for($i = 0; $i < $c; $i++){
                                            if(isset($idr[$i])){
                                                echo '<td>
                                                <form method="POST">
                                                    <input type="hidden" name="idr" value="'.$idr[$i].'"/>
                                                    <button type="submit" class="btn btn-danger btn-sm" name="eliminaVariante"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </form>
                                            </td>';
                                            }
                                        }

                                }
                            ?>

                        </table>
                    </div>
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
                                            if(isset($_GET['order'])){
                                                echo '<li class="page-item"><a class="page-link" href="articoli?page='.$i.'&order='.$_GET['order'].'">'.$i.'</a></li>';
                                            }
                                            elseif(isset($_GET['price'])){
                                                echo '<li class="page-item"><a class="page-link" href="articoli?page='.$i.'&price='.$_GET['price'].'">'.$i.'</a></li>';
                                            }
                                            elseif(isset($_GET['like'])){
                                                echo '<li class="page-item"><a class="page-link" href="articoli?page='.$i.'&like='.$_GET['like'].'">'.$i.'</a></li>';
                                            }
                                            elseif(isset($_GET['qty'])){
                                                echo '<li class="page-item"><a class="page-link" href="articoli?page='.$i.'&qty='.$_GET['qty'].'">'.$i.'</a></li>';
                                            }
                                            else{
                                                echo '<li class="page-item"><a class="page-link" href="articoli?page='.$i.'">'.$i.'</a></li>';                                                
                                            }
                                        }
                                    } 
                                ?>
                            </li> 
                        </ul>
                    </nav>
                </div> 
            </div>
        </div>

    </div>
    <!-- /#page-content-wrapper -->

    <!--  SEZIONE MODAL -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div id="not2" class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notifiche</h5>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Testo</th>
                        <th scope="col">Articolo</th>
                        <th scope="col">Azione</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $w=$conn->prepare("SELECT n.id, n.id_ordine, n.stato,
                                                t.id_testo, t.testo
                                            FROM notifiche AS n
                                            JOIN testo AS t ON t.id_testo = n.testo
                                            WHERE stato = 0
                                            ORDER by n.id DESC");
                        $w->execute();  
                        $r = $w->get_result();

                        while($row = $r->fetch_assoc()) {

                            $id = $row['id'];
                            $id_ordine = $row['id_ordine'];
                            $testo = $row['testo'];
                            $id_testo = $row['id_testo'];

                            if($id_testo <= 3){

                                echo '
                                    <tr>
                                        <th scope="row">'.$id.'</th>
                                        <td>'.$testo.'</td>
                                        <td>'.$id_ordine.'</td>
                                        <td><form action="../../config/server/action" method="post">
                                                <input type="hidden" name="id" value="'.$id.'"/>
                                                <input type="hidden" name="link" value="'.substr(basename($_SERVER['PHP_SELF']),0,-4).'"/>
                                                <button type="submit" class="btn btn-success" name="cancellaNotifica"><i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    ';
                                }
                                elseif($id_testo = 4){
                                    echo '
                                        <tr>
                                            <th scope="row">'.$id.'</th>
                                            <td>'.$testo.'</td>
                                            <td>'.$id_ordine.'</td>
                                            <td><form action="../../config/server/action" method="post">
                                                    <input type="hidden" name="id" value="'.$id.'"/>
                                                    <input type="hidden" name="link" value="'.substr(basename($_SERVER['PHP_SELF']),0,-4).'"/>
                                                    <button type="submit" class="btn btn-success" name="cancellaNotifica"><i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    ';
                                }
                            }

                        ?>
                    </tbody>
                </table> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <form action="../../config/server/action" method="post">
                    <input type="hidden" name="link" value="<?php $xyz = substr(basename($_SERVER['PHP_SELF']),0,-4); echo $xyz;?>"/>
                    <button type="submit" name="cancellaNotifica2" class="btn btn-success">Segna tutti come letto</button>
                </form>    
            </div>
            </div>
        </div>
    </div>  

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo',
                    data:{ nome:$("#sArticolo").val(),},
                    success:function(data){
                        $("#output").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo2").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo',
                    data:{ nome:$("#sArticolo2").val(),},
                    success:function(data){
                        $("#output2").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo3").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo',
                    data:{ nome:$("#sArticolo3").val(),},
                    success:function(data){
                        $("#output3").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo4").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo',
                    data:{ nome:$("#sArticolo4").val(),},
                    success:function(data){
                        $("#output4").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo5").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo',
                    data:{ nome:$("#sArticolo5").val(),},
                    success:function(data){
                        $("#output5").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo6").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo2',
                    data:{ nome:$("#sArticolo6").val(),},
                    success:function(data){
                        $("#output6").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo7").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo3',
                    data:{ nome:$("#sArticolo7").val(),},
                    success:function(data){
                        $("#output7").html(data);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo8").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo4',
                    data:{ slot:$("#sArticolo8").val(),},
                    success:function(data){
                        $("#output8").html(data);
                    }
                });
            });
        });
    </script>  
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#sArticolo9").keyup(function(){
                $.ajax({
                    type:'POST',
                    url:'../../config/link/lis-articolo5',
                    data:{ nome:$("#sArticolo9").val(),},
                    success:function(data){
                        $("#output9").html(data);
                    }
                });
            });
        });
    </script>    

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>

    <?php
        if(isset($_SESSION['varArticolo']) && $_SESSION['varArticolo'] == 1)
        {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Variante aggiunte con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";

            unset($_SESSION['varArticolo']);
        }
        else if(isset($_SESSION['varArticolo']) && $_SESSION['varArticolo'] == 2)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Errore',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['varArticolo']);
        }
        else if(isset($_SESSION['insArticolo']) && $_SESSION['insArticolo'] == 1)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Articolo aggiunto con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['insArticolo']);
        }
        else if(isset($_SESSION['insArticolo']) && $_SESSION['insArticolo'] == 2)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Inserire tutti i campi richiesti.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['insArticolo']);
        }
        else if(isset($_SESSION['insArticolo']) && $_SESSION['insArticolo'] == 3)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Articolo già esistente.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['insArticolo']);
        }
        else if(isset($_SESSION['fotoArticolo']) && $_SESSION['fotoArticolo'] == 1)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Foto aggiunte con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['fotoArticolo']);
        }
        else if(isset($_SESSION['fotoArticolo']) && $_SESSION['fotoArticolo'] == 2)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Inserire almeno 2 foto oppure limite superato (10).',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['fotoArticolo']);
        }
        else if(isset($_SESSION['fotoArticolo']) && $_SESSION['fotoArticolo'] == 3)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Uno o più file sono di tipo non consentito.',
                    timer: 3000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['fotoArticolo']);
        }
        else if(isset($_SESSION['fotoArticolo']) && $_SESSION['fotoArticolo'] == 4)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Foto già inserita. Usare AGGIORNA FOTO.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['fotoArticolo']);
        }
        else if(isset($_SESSION['aggArticolo']) && $_SESSION['aggArticolo'] == 1)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Aggiornamento avvenuto con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['aggArticolo']);
        }
        else if(isset($_SESSION['aggArticolo']) && $_SESSION['aggArticolo'] == 2)
        {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    text: 'Errore nell\'aggiornamento.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";
            unset($_SESSION['aggArticolo']);
        }

    ?>

    <!-- EXTRA JS -->
    <?php 
      linkJs();
      jsInline2();
    ?>

    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#not").load(window.location.href + " #not" );
                $("#not2").load(window.location.href + " #not2" );
            }, 10000);
        });
    </script>

  </body>
</html>