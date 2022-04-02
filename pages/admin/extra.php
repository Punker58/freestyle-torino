<?php 
  include '../../config/server/action.php';
  include '../../config/link/function.php';
  cookieAdmin();
  
  if( $_SESSION['ruolo'] != 10) {echo'<script> location.replace("../../"); </script>';}
?>

<!doctype html>
<html lang="it">
  <head>

    <?php 
        //funzioni invocate
        metaTags();
        linkCssAdmin();
        linkJs();
        favicon2();
    ?>
    <title>Extra</title>
  </head>

  <body>

    <div class="d-flex" id="wrapper">

    <?php sidebarAdminExtra2(); ?>

        <div id="page-content-wrapper">
 
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                    <h2 class="fs-2 m-0 text-light">Extra</h2>
                </div>
            </nav> 

            <div class="container-fluid px-4">
                
                <div class="row g-3 my-2">

                    <!-- AGGIUNGI COLORE -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art1">
                            <div>
                                <p class="fs-5">Aggiungi Colore</p>
                            </div>
                                <i class="fas fa-paint-brush fs-1 primary-text border rounded-full bg-danger p-3"></i>
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

                                <form action="../../config/server/action" method="POST">


                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="floatingColore" name="colore" placeholder="COLORE">
                                    <label for="floatingColore">COLORE</label>
                                </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="inserisciColore">Inserisci</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>   
                    
                    <!-- AGGIUNGI TAGLIA -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art2">
                            <div>
                                <p class="fs-5">Aggiungi Taglia</p>
                            </div>
                                <i class="fas fa-tshirt fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aggiungi articolo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="../../config/server/action" method="POST">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingTaglia" name="taglia" placeholder="TAGLIA">
                                        <label for="floatingTaglia">TAGLIA</label>
                                    </div>

                            </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" name="inserisciTaglia">Inserisci</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- AGGIUNGI CATEGORIA -->
                    <!--<div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art3">
                            <div>
                                <p class="fs-5">Aggiungi Categoria</p>
                            </div>
                                <i class="fas fa-tshirt fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingCategoria" name="categoria" placeholder="CATEGORIA">
                                            <label for="floatingCategoria">CATEGORIA</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-control "name="attiva" id="floatingSconto">
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="floatingSconto">ATTIVA</label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="inserisciCategoria">Inserisci</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- ATTIVA/DISATTIVA CATEGORIA -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art4">
                            <div>
                                <p class="fs-5">Attiva/Disattiva Categoria</p>
                            </div>
                                <i class="fas fa-toggle-on fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Attiva/Disattiva Taglia</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

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
                                            <select class="form-control "name="attiva" id="floatingSconto">
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <label for="floatingSconto">ATTIVA</label>
                                        </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" name="attivaCategoria">Inserisci</button>
                                    </div>

                                </form>
                                </div>
                            </div>
                        </div>                        
                    </div>  
                    
                    <!-- AGGIUNGI BANNER HOME -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art5">
                            <div>
                                <p class="fs-5">Modifica Banner Home</p>
                            </div>
                                <i class="fas fa-ad fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Banner Home</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="floatingSconto" name="sconto" placeholder="SCONTO">
                                            <label for="floatingSconto">SCONTO</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingDesc" name="descrizione" placeholder="DESCRIZIONE">
                                            <label for="floatingDescrizione">DESCRIZIONE</label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="modificaBannerHome">Modifica</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- AGGIUNGI CODICE SCONTO ARTICOLO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art6">
                            <div>
                                <p class="fs-5">Codice Sconto articolo</p>
                            </div>
                                <i class="fas fa-tag fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Codice sconto articolo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="nome" placeholder="SCONTO">
                                            <label for="floatingSconto">Nome dello sconto</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="valore" placeholder="VALORE">
                                            <label for="floatingSconto">Valore dello sconto (inserire solo il numero)</label>
                                        </div>

                                        <div class="form-floating mb-3">

                                            <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="tipo" placeholder="CATEGORIA" required>

                                                <option selected disabled hidden></option>
                                                <option value="1">EURO</option>
                                                <option value="2">% (IN PERCENTUALE)</option>

                                            </select>
                                            <label for="floatingCategoria">Tipo di sconto</label>

                                        </div>

                                        <div class="form-floating mb-3">

                                            <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="articolo" placeholder="ARTICOLO">
                                                <option selected disabled hidden></option>
                                                <?php

                                                    $s=$conn->prepare("SELECT * FROM prodotti");
                                                    $s->execute();  
                                                    $r = $s->get_result(); 

                                                    while ($row = $r->fetch_assoc()) {

                                                        $id = $row['id_prodotto'];
                                                        $nome = $row['nome'];
                                                    
                                                        echo '<option value="'.$id.'">ID: '.$id.' NOME: '.$nome.'</option>';

                                                    }
                                                    
                                                ?>

                                            </select>
                                            <label for="floatingCategoria">ARTICOLO</label>

                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingCod" name="codice" placeholder="CODICE">
                                            <label for="floatingCod">CODICE</label>
                                        </div>

                                        <div class="form-floating ">
                                            <input type="date" class="form-control" id="datepicker" name="data" placeholder="DATA" min="<?= date('Y-m-d'); ?>" required>
                                            <label for="datepicker" class="ms-2">SCADENZA</label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="inserisciCodScontoArticolo">Inserisci</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- AGGIUNGI CODICE SCONTO CATEGORIA -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art7">
                            <div>
                                <p class="fs-5">Codice Sconto categoria</p>
                            </div>
                                <i class="fas fa-tags fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art7" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Codice sconto articolo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="nome" placeholder="SCONTO">
                                            <label for="floatingSconto">Nome dello sconto</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="valore" placeholder="VALORE">
                                            <label for="floatingSconto">Valore dello sconto (inserire solo il numero)</label>
                                        </div>

                                        <div class="form-floating mb-3">

                                            <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="tipo" placeholder="CATEGORIA" required>

                                                <option selected disabled hidden></option>
                                                <option value="1">EURO</option>
                                                <option value="2">% (IN PERCENTUALE)</option>

                                            </select>
                                            <label for="floatingCategoria">Tipo di sconto</label>

                                        </div>

                                        <div class="form-floating mb-3">

                                            <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="articolo" placeholder="ARTICOLO">
                                                <option selected disabled hidden></option>
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
                                            <input type="text" class="form-control" id="floatingCod" name="codice" placeholder="CODICE">
                                            <label for="floatingCod">CODICE</label>
                                        </div>

                                        <div class="form-floating ">
                                            <input type="date" class="form-control" id="datepicker" name="data" placeholder="DATA" min="<?= date('Y-m-d'); ?>" required>
                                            <label for="datepicker" class="ms-2">SCADENZA</label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="inserisciCodScontoArticolo">Inserisci</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- AGGIUNGI CODICE SCONTO SU TUTTO -->
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded" type="button" data-bs-toggle="modal" data-bs-target="#art8">
                            <div>
                                <p class="fs-5">Codice Sconto su tutto</p>
                            </div>
                                <i class="fas fa-user-tag fs-1 primary-text border rounded-full bg-danger p-3"></i>
                        </div>
                    </div>
                
                    <div class="modal fade" id="art8" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Codice sconto articolo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="../../config/server/action" method="POST">

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="nome" placeholder="SCONTO">
                                            <label for="floatingSconto">Nome dello sconto</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingSconto" name="valore" placeholder="VALORE">
                                            <label for="floatingSconto">Valore dello sconto (inserire solo il numero)</label>
                                        </div>

                                        <div class="form-floating mb-3">

                                            <select class="form-select" aria-label="Default select example" id="floatingCategoria" name="tipo" placeholder="CATEGORIA" required>

                                                <option selected disabled hidden></option>
                                                <option value="1">EURO</option>
                                                <option value="2">% (IN PERCENTUALE)</option>

                                            </select>
                                            <label for="floatingCategoria">Tipo di sconto</label>

                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingCod" name="codice" placeholder="CODICE">
                                            <label for="floatingCod">CODICE</label>
                                        </div>

                                        <div class="form-floating ">
                                            <input type="date" class="form-control" id="datepicker" name="data" placeholder="DATA" min="<?= date('Y-m-d'); ?>" required>
                                            <label for="datepicker" class="ms-2">SCADENZA</label>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="inserisciCodScontoTutto">Inserisci</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                     

                    <!--TABELLE -->
                    <div class="row g-3 my-2">

                        <h3 class="fs-4 mb-3 text-light">Extra</h3>
                        <div class="t1 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 ">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">#</th>
                                        <th scope="col">Colore</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $s=$conn->prepare("SELECT * FROM colore");
                                        $s->execute();  
                                        $r = $s->get_result(); 


                                        while ($row = $r->fetch_assoc()) {

                                        $id = $row['id'];
                                        $nome = $row['n_colore'];

                                        echo '
                                            <tr>
                                            <th scope="row">'.$id.'</th>
                                            <td>'.$nome.'</td>
                                            </tr>   
                                        ';

                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="t1 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">ID</th>
                                        <th scope="col">Taglia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $s=$conn->prepare("SELECT t.id, t.n_taglia FROM taglia AS t");
                                        $s->execute();  
                                        $r = $s->get_result(); 


                                        while ($row = $r->fetch_assoc()) {

                                        $id = $row['id'];
                                        $nome = $row['n_taglia'];

                                        echo '
                                            <tr>
                                            <th scope="row">'.$id.'</th>
                                            <td>'.$nome.'</td>
                                            </tr>   
                                        ';

                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="t1 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 ">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">#</th>
                                        <th scope="col">Categoria</th>
                                        <th>Sezione attiva</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $s=$conn->prepare("SELECT * FROM categoria");
                                        $s->execute();  
                                        $r = $s->get_result(); 


                                        while ($row = $r->fetch_assoc()) {

                                        $id = $row['id'];
                                        $nome = $row['n_categoria'];
                                        $attiva = $row['attiva'];

                                        echo '
                                            <tr>
                                            <th scope="row">'.$id.'</th>
                                            <td>'.$nome.'</td>
                                            <td>'.$attiva.'</td>
                                            </tr>   
                                        ';

                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="t1 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 ">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">ID</th>
                                        <th scope="col">Sconto</th>
                                        <th scope="col">descrizione</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $s=$conn->prepare("SELECT * FROM banner_home");
                                        $s->execute();  
                                        $r = $s->get_result(); 


                                        while ($row = $r->fetch_assoc()) {

                                        $id = $row['id'];
                                        $nome = $row['sconto'];
                                        $descrizione = $row['descrizione'];

                                        echo '
                                            <tr>
                                                <th scope="row">'.$id.'</th>
                                                <td>'.$nome.' €</td>
                                                <td>'.$descrizione.'</td>
                                            </tr>   
                                        ';

                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="t1 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 ">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">ID</th>
                                        <th scope="col">Descrizione</th>
                                        <th scope="col">Codice</th>
                                        <th>Tipo</th>
                                        <th>Gamma</th>
                                        <th>Scadenza</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 

                                        $s=$conn->prepare("SELECT * FROM cod_sconto");
                                        $s->execute();  
                                        $r = $s->get_result(); 


                                        while ($row = $r->fetch_assoc()) {

                                        $id = $row['id'];
                                        $nome = $row['nome'];
                                        $codice = $row['codice'];
                                        $tipo = $row['tipo'];
                                        $gamma = $row['gamma'];
                                        $data = date("d-m-Y", strtotime($row['durata'])); 

                                        echo '
                                            <tr>
                                                <th scope="row">'.$id.'</th>
                                                <td>'.$nome.'</td>
                                                <td>'.$codice.'</td>
                                                <td>'?> <?php if($tipo == 1){ echo '€';}else{ echo '%';} ?> <?php echo'</td>
                                                <td>'.$gamma.'</td>
                                                <td>'.$data.'</td>
                                            </tr>   
                                        ';

                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    <!-- /#page-content-wrapper -->
    </div>

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

    <!-- SEZIONE NOTIFICHE -->
    <?php
        if(isset($_SESSION['success']) && $_SESSION['success'] == 1)
        {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    text: 'Variante aggiunta con successo.',
                    timer: 2000,
                    showConfirmButton: false});
            </script>
            ";

            unset($_SESSION['success']);
        }
        else if(isset($_SESSION['success']) && $_SESSION['success'] == 2)
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
            unset($_SESSION['success']);
        }

    ?>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $(document).ready(function(){
            setInterval(function(){
                $("#not").load(window.location.href + " #not" );
                $("#not2").load(window.location.href + " #not2" );
            }, 10000);
        });
    </script>

  </body>
</html>