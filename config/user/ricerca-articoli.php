<?php   
    include '../../config/link/function.php';
    include '../../config/server/action.php';
    
    if(isset($_POST['stshirt'])){

        $rpp = 9;
        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                pf.id, pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                pv.id, pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto,
                                c.n_categoria
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                            JOIN categoria as c ON c.id = p.categoria
                            WHERE pv.quantita > 0
                            AND p.categoria = 1
                            AND p.nome LIKE '%".$_POST['stshirt']."%'
                            GROUP BY pv.id");		
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
        else { $i = 'p.id'; $s = null;}    

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria, p.in_sconto,
                                pf.id, pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                pv.id, pv.id_taglia, pv.id_colore, pv.quantita, p.in_sconto,
                                c.n_categoria
                            FROM prodotti as p
                            LEFT JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            LEFT JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                            LEFT JOIN categoria as c ON c.id = p.categoria
                            WHERE pv.quantita > 0
                            AND p.categoria = 1
                            AND p.nome LIKE '%".$_POST['stshirt']."%'
                            ".$s."
                            GROUP BY pv.id
                            ORDER by ".$i." 
                            GROUP BY pv.id
                            LIMIT ".$fr.','.$rpp);		
        $s->execute();  
        $r = $s->get_result(); 
        $r2 = $r->num_rows;                      

        if ($r->num_rows > 0) {
            
            while ($row = $r->fetch_assoc()) {

            $idr = $row['id'];
            $_SESSION['articolo'] = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $_SESSION['categoria'] = $row['categoria'];
            $n_cat1 = $row['n_categoria'];
            $foto1 = $row['foto1'];
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
                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 card-ca2">
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 col-xxl-3 card-ca3">
                        <img src="../../images/articoli/'.$_SESSION['categoria'].'/'.$foto1.'" height ="300vh" width="220vh" alt="Girl in a jacket" ">
                    </div>';
                
                    if (isset($_SESSION['id'])) {
                        if ($s1->num_rows > 0) {

                            echo '
                                <span class="unlike btn float-end mt-2" data-id="'.$_SESSION['articolo'].'"><i class="fas fa-heart text-black"></i></span>
                                ';
                        }
                        else{
                            echo '
                                <span class="like btn float-end mt-2" data-id="'.$_SESSION['articolo'].'"><i class="fas fa-heart"></i></span>
                                ';
                        }
                    }
                
        echo'
                <div class="text-center mt-5">
                    
                    <h3 class="text-capitalize">'.$nome.'</h3>
                    <h3>'.$prezzo.' € ';if($in_sconto=='SI'){echo'<span class="text-black">IN SCONTO</span>';} echo'</h3>
                    <form action="articolo-dettagli" method="post">
                        <input type="hidden" name="id" value="'.$_SESSION['articolo'].'"/>
                        <input type="submit" class="btn btn-dark" value="DETTAGLI"/>
                    </form>
                </div>
            </div>   
        ';

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

        echo '
                    </li> 
                </ul>
            </nav>
            ';


        }
    ?>
