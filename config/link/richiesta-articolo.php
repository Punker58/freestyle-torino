<?php
    // connessione db + start sessione
    session_start();
    require '../server/connect_db.php';
    $conn = db();

	if($_POST || $_GET){
		if($_GET){
			if($_GET['request']=="richiesta" && $_POST){

            ?>
            
            <div><p class="fs-1 mt-5 t-dettagli">TAGLIA</p>
                <select class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 form-select form-select-lg mt-5" aria-label=".form-select-lg example" name="id_taglia">

            <?php    
    
                $s3=$conn->prepare("SELECT pv.id_prodotto, pv.quantita, pv.id_taglia,
                                            t.n_taglia, c.n_colore
                                    FROM prodotti_varianti as pv
                                    JOIN taglia as t ON t.id = pv.id_taglia
                                    JOIN colore as c ON c.id = pv.id_colore
                                    WHERE pv.quantita > 0
                                    AND pv.id_prodotto = ?
                                    AND pv.id_colore = ?");	
                $s3->bind_param("ii", $_SESSION['articolo'], $_POST['id_colore']);	
                $s3->execute();  
                $r = $s3->get_result();

                while ($row = $r->fetch_assoc()) {
  
                    $_SESSION['id_taglia'] = $row['id_taglia'];
                    $taglia = $row['n_taglia']; 

                    echo 
                        '
                        <option value="'.$_SESSION['id_taglia'].'"selected>'.$taglia.'</option> 
                        ';

                }
		
				?>

                </select>
			<?php
			}
		}
	}
?>