<?php 

    include '../../config/link/function.php';
    include '../../config/server/action.php';
    cookieUtente();
    cod_sconto();
	if(!isset($_SESSION['y']) OR !isset($_SESSION['token'])){echo'<script> location.replace("../index.php"); </script>';}

    //check token + get var ritiro in negozio + data + stato ordine da ritirare
    $x = str_replace('-', '/', $_GET['token'] );
	if(isset($_GET['negozio'])){
		$neg = $_GET['negozio'];
	}else{
		$neg = null;
	}
    $oggi = date("Y/m/d");
	$staton = 2;

    if(password_verify($_SESSION['y'], $x ))
        {

		//var notifiche
		$testo = 1; // hai un nuovo ordine
		$stato = 0;

		// check codice coupon
		if(isset($_SESSION['scontoUtilizzato'])){

			$sx=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto) 
						VALUES (?,?)");
            $sx->bind_param("ii", $_SESSION['id'], $_SESSION['scontoUtilizzato']);
            $sx->execute();

		}

        // seleziono l'articolo dal carrello con i suoi dettagli
        $s=$conn->prepare("SELECT c.id_prodotto, c.id_colore, c.id_taglia, c.n_quantita,
                                pv.quantita
                         FROM carrello AS c
                         JOIN prodotti_varianti AS pv ON pv.id_prodotto = c.id_prodotto
                         WHERE id_utente = ?");
        $s->bind_param('s', $_SESSION['cod_carrello']);		
        $s->execute();        
        $r = $s->get_result();
        while ($row = $r->fetch_assoc()){

            $id_prodotto = $row['id_prodotto'];
            $id_colore = $row['id_colore'];
            $id_taglia = $row['id_taglia'];
            $quantitaCarrello = $row['n_quantita'];
            $quantitaDb = $row['quantita'];
        }

        $totaleQuantita = $quantitaDb - $quantitaCarrello;

		// diminuisco quantita dell'articolo		
        $s=$conn->prepare("UPDATE prodotti_varianti SET quantita = ? WHERE id_prodotto = ? AND id_taglia = ? AND id_colore = ?");
        $s->bind_param('iiii', $totaleQuantita, $id_prodotto, $id_taglia, $id_colore);		
        $s->execute(); 


        if($quantitaDb<=5){

            $testo1 = 2;//quantita quasi esaurita
            // inserisci notifica quasi esaurito
            $s=$conn->prepare("INSERT INTO notifiche (id_ordine, testo, stato) 
                                VALUES (?,?,?)");
            $s->bind_param('iii', $id_prodotto, $testo1, $stato);		
            $s->execute();            

        }elseif($quantitaDb==0){

            $testo1 = 3; //quantita esaurita
            // inserisci notifica articolo esaurito
            $s=$conn->prepare("INSERT INTO notifiche (id_ordine, testo, stato) 
                                VALUES (?,?,?)");
            $s->bind_param('iii', $id_prodotto, $testo1, $stato);		
            $s->execute();

        }

        // seleziono il carrello
        $s=$conn->prepare("SELECT CONCAT (nome,' ( X ',n_quantita,' ) ', ' ( ',n_colore,' ) ', ' ( ',n_taglia,' ) ')
                            AS articoli, p.prezzo, p.prezzo_scontato, c.n_quantita AS qty
                            FROM carrello AS c
                            JOIN prodotti AS p ON p.id_prodotto = c.id_prodotto
                            JOIN colore AS co ON co.id = c.id_colore
                            JOIN taglia as t ON t.id = c.id_taglia
                            WHERE id_utente = ?");
        $s->bind_param('s', $_SESSION['cod_carrello']);		
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()){
            $articoli[] = $row['articoli'];
			$quantita = $row['qty'];

			if(isset($row['prezzo_scontato'])){
				$prezzo = $row['prezzo_scontato'] * $quantita;
			  }else{
				$prezzo = $row['prezzo'] * $quantita;
			  }

			$prezzoS = $prezzo + 7; //prezzo + spedizione
        }
        $articoli2 = implode("</br></br> ", $articoli);

        $stato = 0;

		if(!isset($_SESSION['id'])){

			// inserisci dati dell'utente nel db veloce
            $s1=$conn->prepare("INSERT INTO utente_veloce (nome, cognome, email, indirizzo, cap, citta, provincia,telefono)
                                VALUES(?,?,?,?,?,?,?,?)");
            $s1->bind_param("ssssssis", $_SESSION['nome'], $_SESSION['cognome'], $_SESSION['email'], $_SESSION['indirizzo'],
                                $_SESSION['cap'], $_SESSION['citta'], $_SESSION['provincia'], $_SESSION['telefono'] );
            $s1->execute();	
			
			// ricavo l'id dell utente db veloce
			$sx=$conn->prepare("SELECT id, nome_province FROM utente_veloce AS u
								JOIN province AS p ON p.id_province = u.provincia
								WHERE telefono = ?");
            $sx->bind_param("s", $_SESSION['telefono']);
            $sx->execute();

			$rx = $sx->get_result();

			while ($row = $rx->fetch_assoc()) {
				$_SESSION['idr'] = $row['id'];
				$_SESSION['provincia'] = $row['nome_province'];
			}

			// Inserisci ordine se non sei iscritto + ritiro in negozio
			if($neg == 1){

				$s=$conn->prepare("INSERT INTO ordini (prodotti, data_pagamento, prezzo_totale, stato, utente_veloce) 
									VALUES (?,?,?,?,?)");
				$s->bind_param('ssdii', $articoli2, $oggi, $prezzo, $staton, $_SESSION['idr']);		
				$s->execute(); 

			}
			else{

				// Inserisci ordine se non sei iscritto + spedizione
				$s=$conn->prepare("INSERT INTO ordini (prodotti, data_pagamento, prezzo_totale, stato, utente_veloce) 
							VALUES (?,?,?,?,?)");
				$s->bind_param('ssdii', $articoli2, $oggi, $prezzoS, $stato, $_SESSION['idr']);		
				$s->execute(); 

			}

		}else{

			if($neg == 1) {

				// Inserisci ordine se sei iscritto + ritiro in negozio
				$s=$conn->prepare("INSERT INTO ordini (id_utente, prodotti, data_pagamento, prezzo_totale, stato) 
									VALUES (?,?,?,?,?)");
				$s->bind_param('issdi', $_SESSION['id'], $articoli2, $oggi, $prezzo, $staton);		
				$s->execute();  

			}else{

			// Inserisci ordine se sei iscritto + spedizione
			$s=$conn->prepare("INSERT INTO ordini (id_utente, prodotti, data_pagamento, prezzo_totale, stato) 
						VALUES (?,?,?,?,?)");
			$s->bind_param('issdi', $_SESSION['id'], $articoli2, $oggi, $prezzoS, $stato);		
			$s->execute();  

			}

		}

        // last id
        $last_id = mysqli_insert_id($conn);

        // inserisci notifica per admin
        $s=$conn->prepare("INSERT INTO notifiche (id_ordine, testo, stato) 
                            VALUES (?,?,?)");
        $s->bind_param('iii', $last_id, $testo, $stato);		
        $s->execute();

        //elimino dal carrello
        $s=$conn->prepare("DELETE FROM carrello WHERE id_utente = ?");
        $s->bind_param('s', $_SESSION['cod_carrello']);		
        $s->execute();   
        
		//seleziono gli ordini da mandare tramite email
		if(isset($_SESSION['idr'])){
			// non registrato
			$s=$conn->prepare("SELECT * FROM ordini WHERE utente_veloce = ? ORDER BY id DESC");
			$s->bind_param('i', $_SESSION['idr']);		
			$s->execute();  
			$r = $s->get_result();

			if ($r->num_rows > 0) {

			while ($row = $r->fetch_assoc()) {

				$id_ordine = $row['id'];
				$articoli = $row['prodotti'];
				$data = $row['data_pagamento'];
				$prezzo = $row['prezzo_totale'];

				}
			}

		}else{
			//registrato
			$s=$conn->prepare("SELECT * FROM ordini WHERE id_utente = ? ORDER BY id DESC");
			$s->bind_param('i', $_SESSION['id']);		
			$s->execute();  
			$r = $s->get_result();

			if ($r->num_rows > 0) {

			while ($row = $r->fetch_assoc()) {

				$id_ordine = $row['id'];
				$articoli = $row['prodotti'];
				$data = $row['data_pagamento'];
				$prezzo = $row['prezzo_totale'];

				}
			}
		}

        $m = '
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>freestyleconceptstore</title>
			<style type="text/css">
				@import url(\'https://fonts.googleapis.com/css2?family=Anton&display=swap\');
				:root {
					--main-bg-color: #000000;
					--main-font-color: #FFFFFF;
					--second-font-color: #D0D403;
					--main-card-color: #a61107;
				}
				*{
					font-family: \'Anton\', sans-serif;
					margin: 0;
					padding: 0;
					border: 0;
				}
				body {
					background-color: #cccccc;
					font-size: 19px;
					width: 800px;
					margin: 0 auto;
					padding: 3%;
				}
				header{
					width:98%;
				}
				table {
					border-spacing: 0;
				}
				td {
					padding: 0;
				}
				img {
					border: 0;
					max-width: 100%;
				}
				.stile h1{
					color: #D0D403 !important;
					margin:3%;
					font-size:3em;
				}
				.stile p{
					color: white !important;
					margin:3%;
					font-size:1.6em;
				}
				table {
					border-collapse: collapse;
					width: 100%;
					margin:3%;
					margin-right:5% !important;
				}
		
				td, th {
					border: 1px solid #dddddd;
					text-align: left;
					padding-right: 260px;
					padding-bottom: 10px;
					padding-left: 100px;
					color: white !important;
					font-size: 2vh;
					max-width:260px !important;
				}
		
				tr:nth-child(even) {
					background-color: #dddddd;
				}
				hr {
					height:1px !important;
					background-color: white !important;
				}
				#contact{
					text-align:center;
					padding-bottom: 3%;
					line-height: 20px;
					font-size: 16px;
					color: white !important;
				}
				.row {
					display: flex;
				}     
				.column {
				flex: 50%;
				padding: 10px;
				margin:3%;
				}
				.column p {
					font-size:19px;
				}
				.upper{
					text-transform:capitalize;
				}
			</style>
			</head>
			<body>
				
				<div id="wrapper" class="stile" style="background-image: url(\'https://freestyleconceptstore.it/images/bg/bgf2.jpg\') !important;">
					<header>
						<img src="https://freestyleconceptstore.it/images/logo/freestyle2.png" height="150vh" width="300vh" alt="freestyle"><br>
					</header>
					<div id="one-col">
						<h1 class="upper">Gentile '.$_SESSION['nome'].' '.$_SESSION['cognome'].'</h1>
						<p>
							Grazie per il tuo ordine.<br> Ti invieremo un\'e-mail quando i tuoi articoli saranno spediti.<br>
							La data di consegna prevista è indicata in basso.<br> Puoi consultare la pagina  " I MIEI ORDINI " sul nostro sito web
							per visualizzare lo stato del tuo ordine. 
						</p>
					</div>
					<div id="two-col">
						<h1>Riepilogo ordine</h1>
							<hr>
							<p>ordine n° '.$id_ordine.'</p>
							<p>Effettuato il '.$data.'</p>
							<hr>
					</div>
					<div id="three-col">
						<p>Arriverà: 24/72 ore</p>
					</div>
					<div class="row">
						<div class="column">
							<p>L\'ordine sarà spedito a:</p>
							<p class="upper">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</p>
							<p>'.$_SESSION['indirizzo'].' '.$_SESSION['citta'].'</p>
							<p>'.$_SESSION['cap'].' '.$_SESSION['provincia'].'<?php if(!empty){ echo $_SESSION[\'campanello\'];} ?><?php echo \'</p>
							<p>'.$_SESSION['telefono'].'<br> '.$_SESSION['email'].'</p>
						</div>
					</div> 
					<div class="column">
						<h1>Articoli:</h1>
						<p style="font-size:2rem;">'.$articoli.'</p>
						<br>
						<h1>Totale</h1>
						<p style="font-size:2rem;">'.$prezzo.' €</p>
					</div>
					<div class="column">
						<p>
							Questo documento non è valido come fattura e non può essere usato per detrarre l\'IVA.
							Operazione non soggetta all\'obbligo di emissione della fattura (ai sensi dell\'art. 22, c. 1, n. 1 DPR 633/72) né
							all\'obbligo di certificazione fiscale (art 2, lett oo), DPR 696/96.                        
						</p>
					</div> 
					<footer>
						<p id="contact">
							Freestyleconceptstore.it<br>
							Via Giuseppe Giacosa 2,<br>
							Nichelino 10042 (TO)<br>
							P.IVA 12572410012
						</p>
					</footer>
				</div>
			
			</body>
		</html>
			';

            // email bot -> utente 
			$to = $_SESSION['email'];
			$subject = 'Ordine preso in carico';
			$message = $m;
            $from = 'noreply@freestyleconceptstore.it';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";
                 
			$headers .= "From: ".$from."\r\n";

            mail($to, $subject, $message, $headers);

			$m2 = '
				<html><body><p style="color:red;">Hai un nuovo ordine!</p></body></html>
				';

			// email bot -> admin (notifica)
			$to2 = 'freestyle.nichelino@gmail.com'; //admin freestyle 
			$subject2 = 'Hai un nuovo ordine da preparare!';
			$message2 = $m2;
            $from = 'noreply@freestyleconceptstore.it';

			$headers2 = "MIME-Version: 1.0" . "\r\n";
			$headers2 .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";
                 
			$headers2 .= "From: ".$from."\r\n";

            mail($to2, $subject2, $message2, $headers2);

        }else{
			//
		}

?>


<!doctype html>
<html lang="it">
  <head>

    <?php 
        //meta tags + seo + css + js
        metaTagsY();
        seoTags();
        linkCss2();
        linkJs();
        favicon2();
    ?>
    <title>Grazie per l'acquisto | Sito ufficiale FreestyleConceptStore</title>
  </head>

  <body>

    <div class="bg58">

    <?php navbarGenerico2(); navbarGenericoMobile2();?>

    <section>
      <div class="container bg-black mt-5">
        <div class="row">
          <div class="col-12 mt-5 text-center">
            <h1 class="t-dettagli">Pagamento effettuato con successo!</h1>
          </div>
          <div class="col-12 mt-5 d-flex justify-content-center">
            <h2>Grazie per l'acquisto</h2>   
          </div>
          <div class="col-12 mt-5 mb-5 text-center">
            <h3>Ti abbiamo inviato una email in riferimento al tuo ordine.</h3><br><br>
			<p>Potrai sempre controllare i tuoi ordini attraverso la pagina "i miei ordini" del nostro sito.</p>
			<p class="t-dettagli">Tra pochi secondi verrai reindirizzato alla nostra home.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <?php footer2(); ?>
    </div>

  <!-- Extra JS -->
  <script>
    window.setTimeout(function(){

      // Move to a new location 
      window.location.href = "../../";

    }, 10000);    
  </script>
	<?php 
		unset($_SESSION['y']);
		unset($_SESSION['token']);
	?>
  </body>
</html>