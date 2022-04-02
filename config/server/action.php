<?php
    // connessione db + start sessione
    session_start();
    require 'connect_db.php';
    $conn = db();

?>

<?php  
    // login admin
    if(isset($_POST["login-admin"])) {

        // dichiarazione +  escape
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Validation backend
        if (empty($username)) {
            array_push($errors, "Username obbligatorio");
        }
        if (empty($password)) {
            array_push($errors, "Password obbligatoria");
        }

        // Check errori
        if (count($errors) == 0)
            {   
                $s=$conn->prepare("SELECT username, password, ruolo, cod_login  FROM admin WHERE username = ?");		
                $s->bind_param("s", $username);
                $s->execute();  
                $s->store_result();

                if ($s->num_rows > 0) {
					$s->bind_result($u, $h, $r, $c);
					$s->fetch();

                    if (password_verify($password, $h)) {

                        session_regenerate_id();
                        $_SESSION['username'] = $u;
                        $_SESSION['ruolo'] = $r;
                        $_SESSION['cod_login'] = $c;

                    // settiamo il cookie
                    //setcookie("access_admin", $c, time()+(86400 * 365), "/");
                    
                    // Redirect
                    echo '
                        <script> 
                                document.cookie = "access_admin='.$_SESSION['cod_login'].'; max-age=31536000; path=/";
                                location.replace("../../pages/admin/dashboard");
                         </script>';

                    }    

                }
            else
                {
                    echo'<script> location.replace("../../pages/admin/login"); </script>';
                }
        }        
    }

    // selezione utenti stock
    if(isset($_POST["selezioneUtente"])) {

        $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                                    ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.telefono, ui.email
                            FROM utente as u
                            JOIN utente_indirizzo as ui ON ui.id_utente =  u.id");		
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {

            $nome = $row['nome'];
            $cognome = $row['cognome'];
            $indirizzo = $row['indirizzo'];
            $citta = $row['citta'];
            $cap = $row['cap'];
            $provincia = $row['provincia'];
            $telefono = $row['telefono'];
            $email = $row['email'];

        }

    }

    // selezione utenti - nuovi utenti a vecchi utenti
    if(isset($_POST["selezioneUtenteNuovo"])) {

        $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                                ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.telefono, ui.email
                            FROM utente as u
                            JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                            ORDER BY id DESC");		
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {

            $nome = $row['nome'];
            $cognome = $row['cognome'];
            $indirizzo = $row['indirizzo'];
            $citta = $row['citta'];
            $cap = $row['cap'];
            $provincia = $row['provincia'];
            $telefono = $row['telefono'];
            $email = $row['email'];

        }

    }

    // selezione dalla lista utenti te stesso
    if(isset($_POST["selezioneUtenteTu"])) {

        $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                                    ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.telefono, ui.email
                            FROM utente as u
                            JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                            WHERE u.id = ?");
        $s->bind_param("i", $_POST['id']);                    		
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {

            $nome = $row['nome'];
            $cognome = $row['cognome'];
            $indirizzo = $row['indirizzo'];
            $citta = $row['citta'];
            $cap = $row['cap'];
            $provincia = $row['provincia'];
            $telefono = $row['telefono'];
            $email = $row['email'];

        }

    }

    // cerca utenti
    if(isset($_POST["cercaUtente"])) {

        $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello,
                                    ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.telefono, ui.email
                            FROM utente as u
                            JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                            WHERE u.nome LIKE '%".$_POST['nome']."%'
                            ORDER BY nome ASC");		
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {

            $nome = $row['nome'];
            $cognome = $row['cognome'];
            $indirizzo = $row['indirizzo'];
            $citta = $row['citta'];
            $cap = $row['cap'];
            $provincia = $row['provincia'];
            $telefono = $row['telefono'];
            $email = $row['email'];

        }

    }

    // SUPERADMIN - modifica utente
    if(isset($_POST["modificaUtente"])) {

        $s=$conn->prepare("UPDATE utente SET nome = ?, cognome = ? WHERE id = ?");
        $s->bind_param("ssi", $_POST['nome'], $_POST['cognome'], $_POST['id']);		
        $s->execute();  
        $r = $s->get_result();


    }

    // selezione prodotti stock
    if(isset($_POST["selezioneProdotto"])) {

        $s=$conn->prepare("SELECT pv.id, p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            GROUP BY p.nome
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

    // selezione prodotti con più like
    if(isset($_POST["selezioneProdottoLike"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                            WHERE pv.id_prodotto = 1000
                            ORDER BY p._like
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

    /* selezione prodotti da prezzo alto a basso
    if(isset($_POST["selezioneProdottoPrezzoUp"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            ORDER BY p.prezzo DESC
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

     selezione prodotti da prezzo basso ad alto
    if(isset($_POST["selezioneProdottoPrezzoDw"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            ORDER BY p.prezzo ASC
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

    // selezione prodotti con sconto
    if(isset($_POST["selezioneProdottoSconto"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            WHERE p.in_sconto = 1
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

    // selezione prodotti da nuovi a vecchi
    if(isset($_POST["selezioneProdottoNuovo"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            ORDER BY id DESC
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }

    // selezione prodotti quasi esaurito
    if(isset($_POST["selezioneProdottoQuasiEsaurito"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            WHERE pv.quantita = 5
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }      
    
    // selezione prodotti esaurito
    if(isset($_POST["selezioneProdottoEsaurito"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            WHERE pv.quantita = 0
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    } */

    // inserisci prodotto
    if(isset($_POST["inserisciArticolo"])) {

        
        if(!empty($_POST['id_prodotto']) && !empty($_POST['nome']) && !empty($_POST['prezzo']) && !empty($_POST['descrizione']) 
                && !empty($_POST['descrizione2']) && !empty($_POST['categoria'])){


            // check articolo esistente
            $s=$conn->prepare("SELECT * FROM prodotti WHERE id_prodotto = ?");	
            $s->bind_param("i", $_POST['id_prodotto']);
            $s->execute();  
            $s->store_result();

            if ($s->num_rows > 0) 
                {
                    $_SESSION['insArticolo'] = 3;
                    echo'<script> location.replace("../../pages/admin/articoli"); </script>';
                }else{

                        $s=$conn->prepare("INSERT INTO prodotti (id_prodotto, nome, prezzo, descrizione, descrizione2, categoria)
                                            VALUES (?,?,?,?,?,?)");
                        $s->bind_param("isdsii", $_POST['id_prodotto'], $_POST['nome'], $_POST['prezzo'], $_POST['descrizione'], $_POST['descrizione2'], $_POST['categoria']);
                        $s->execute();  
                        $s->store_result();  

                        $_SESSION['insArticolo'] = 1;
                        echo'<script> location.replace("../../pages/admin/articoli"); </script>';                    

                }     
        }
        else 
        {
            $_SESSION['insArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }

    }    

    // inserisci foto del prodotto
    if(isset($_POST['inserisciFotoArticolo'])){

        $allowed_ex = array("jpg", "jpeg", "png", "jfif");

        $r = $_POST['id'];
        $r_explode = explode('|', $r);
        $_POST['id'] = $r_explode[0];
        $cat = $r_explode[1];
    
        //foto
        $files = array_filter($_FILES['foto']['name']);
        $tot = count($_FILES['foto']['name']);

        if(!empty($_POST['id'] && $tot >= 2 && $tot <=10)){

            // loop file - 5 ovvero 6 foto
            for( $i=0 ; $i < $tot ; $i++ ) {

                //prende il nome temporaneo
                $img = $_FILES['foto']['name'][$i];
                $tmp_name = $_FILES['foto']['tmp_name'][$i];

                //Estensione del file + Corsivo
                $img_ex = pathinfo($img, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                if (in_array($img_ex_lc, $allowed_ex)) {

                    // Inserisci foto nella cartella 
                    $new_img_name[$i] = bin2hex(random_bytes(20)).'.'.$img_ex_lc;
                    $img_upload_path = '../../images/articoli/'.$cat.'/'.$new_img_name[$i];
                    move_uploaded_file($tmp_name, $img_upload_path);

                }else{

                    $_SESSION['fotoArticolo'] = 3;
                    echo'<script> location.replace("../../pages/admin/articoli"); </script>';
                }


            }

            //2 foto obbligatorie
            if(!empty($new_img_name[0]) && !empty($new_img_name[1])){

                $s=$conn->prepare("INSERT INTO prodotti_foto (id_prodotto, foto0, foto1)
                                    VALUES (?,?,?)");
                $s->bind_param("iss", $_POST['id'], $new_img_name[0], $new_img_name[1]);
                $s->execute();  
            }

            for($x=2; $x < 10; $x++){

                // dalla terza in poi tutto facoltativo
                if(!empty($new_img_name[$x])){

                    $s=$conn->prepare("UPDATE prodotti_foto SET foto".$x." = ? WHERE id_prodotto = ?");
                    $s->bind_param("si", $new_img_name[$x], $_POST['id']);
                    $s->execute();  
                }    

            }     

            $_SESSION['fotoArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';

        }
        else
        {
            $_SESSION['fotoArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }

    }

    // inserisci variante prodotto
    if(isset($_POST["inserisciVarArticolo"])) {

        $tot = $_POST['slot'];

        for($x=0; $x<$tot; $x++) {

            if(!empty($_POST['id']) && !empty($_POST['colore']) && !empty($_POST['taglia'.$x])  && !empty($_POST['quantita'.$x])){

                $s1=$conn->prepare("INSERT INTO prodotti_varianti (id_prodotto, id_taglia, id_colore, quantita)
                                    VALUES (?,?,?,?)");
                $s1->bind_param("iiii", $_POST['id'], $_POST['taglia'.$x], $_POST['colore'], $_POST['quantita'.$x]);
                $s1->execute();  
                $s1->store_result();
    
                $_SESSION['varArticolo'] = 1;
                echo'<script> location.replace("../../pages/admin/articoli"); </script>';
    
            }
            else 
            {
                $_SESSION['varArticolo'] = 2;
                echo'<script> location.replace("../../pages/admin/articoli"); </script>';
            }

        }

    }
    
    // modifica prodotto
    if(isset($_POST["aggiornaArticolo"])) {

        if(!empty($_POST['nome'])){

            $s=$conn->prepare("UPDATE prodotti SET nome = ? WHERE id_prodotto = ?");
            $s->bind_param("si", $_POST['nome'], $_POST['id']);
            $s->execute();  
            $s->store_result();      
            
            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['prezzo'])){

            $s=$conn->prepare("UPDATE prodotti SET prezzo = ? WHERE id_prodotto = ?");
            $s->bind_param("di", $_POST['prezzo'],  $_POST['id']);
            $s->execute();  
            $s->store_result();      

            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['descrizione'])){

            $s=$conn->prepare("UPDATE prodotti SET descrizione = ? WHERE id_prodotto = ?");
            $s->bind_param("si", $_POST['descrizione'], $_POST['id']);
            $s->execute();  
            $s->store_result();   

            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['categoria'])){

            $s=$conn->prepare("UPDATE prodotti SET categoria = ? WHERE id_prodotto = ?");
            $s->bind_param("ii", $_POST['categoria'], $_POST['id']);
            $s->execute();  
            $s->store_result();   

            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['sconto'])){

            $s=$conn->prepare("UPDATE prodotti SET in_sconto = ? WHERE id_prodotto = ?");
            $s->bind_param("si", $_POST['sconto'], $_POST['id']);
            $s->execute();  
            $s->store_result();   

            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

    }

    if(isset($_POST['aggVarArticolo'])){

        if(!empty($_POST['taglia'])){

            $s=$conn->prepare("UPDATE prodotti_varianti SET id_taglia = ? WHERE id = ?");
            $s->bind_param("ii", $_POST['taglia'], $_POST['id']);
            $s->execute();  
            $s->store_result();      
            
            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['colore'])){

            $s=$conn->prepare("UPDATE prodotti_varianti SET id_colore = ? WHERE id = ?");
            $s->bind_param("ii", $_POST['colore'], $_POST['id']);
            $s->execute();  
            $s->store_result();  
            
            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

        if(!empty($_POST['quantita'])){

            $s=$conn->prepare("UPDATE prodotti_varianti SET quantita = ? WHERE id = ?");
            $s->bind_param("ii", $_POST['quantita'], $_POST['id']);
            $s->execute();  
            $s->store_result();      
            
            $_SESSION['aggArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';
        }
        else
        {
            $_SESSION['aggArticolo'] = 2;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>'; 
        }

    }

    if(isset($_POST['aggiornaFotoArticolo'])){

        $allowed_ex = array("jpg", "jpeg", "png", "jfif");

        $r = $_POST['id'];
        $r_explode = explode('|', $r);
        $_POST['id'] = $r_explode[0];
        $categoria = $r_explode[1];
    
        //foto0
		$img0 = $_FILES['foto0']['name'];
		$tmp_name0 = $_FILES['foto0']['tmp_name'];
		$error0 = $_FILES['foto0']['error'];

        //foto1
		$img1 = $_FILES['foto1']['name'];
		$tmp_name1 = $_FILES['foto1']['tmp_name'];
		$error1 = $_FILES['foto1']['error'];

        //foto2
		$img2 = $_FILES['foto2']['name'];
		$tmp_name2 = $_FILES['foto2']['tmp_name'];
		$error2 = $_FILES['foto2']['error'];

        //foto3
		$img3 = $_FILES['foto3']['name'];
		$tmp_name3 = $_FILES['foto3']['tmp_name'];
		$error3 = $_FILES['foto3']['error'];

        //foto4
		$img4 = $_FILES['foto4']['name'];
		$tmp_name4 = $_FILES['foto4']['tmp_name'];
		$error4 = $_FILES['foto4']['error'];

        //foto5
		$img5 = $_FILES['foto5']['name'];
		$tmp_name5 = $_FILES['foto5']['tmp_name'];
		$error5 = $_FILES['foto5']['error'];

        //foto6
		$img6 = $_FILES['foto6']['name'];
		$tmp_name6 = $_FILES['foto6']['tmp_name'];
		$error6 = $_FILES['foto6']['error'];

        //foto7
		$img7 = $_FILES['foto7']['name'];
		$tmp_name7 = $_FILES['foto7']['tmp_name'];
		$error7 = $_FILES['foto7']['error'];  
        
        //foto8
		$img8 = $_FILES['foto8']['name'];
		$tmp_name8 = $_FILES['foto8']['tmp_name'];
		$error8 = $_FILES['foto8']['error'];

        //foto9
		$img9 = $_FILES['foto9']['name'];
		$tmp_name9 = $_FILES['foto9']['tmp_name'];
		$error9 = $_FILES['foto9']['error'];

        if(!empty($_POST['id'])){

            if ($error0 === 0 ) {  

                if(!empty($img0)){

                    //Estensione del file + Corsivo
                    $img_ex0 = pathinfo($img0, PATHINFO_EXTENSION);
                    $img_ex_lc0 = strtolower($img_ex0);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto0']['tmp_name'])){

                        if (in_array($img_ex_lc0, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name0 = bin2hex(random_bytes(20)).'.'.$img_ex_lc0;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name0;
                            move_uploaded_file($tmp_name0, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto0 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name0, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error1 === 0 ) {  

                if(!empty($img1)){

                    //Estensione del file + Corsivo
                    $img_ex1 = pathinfo($img1, PATHINFO_EXTENSION);
                    $img_ex_lc1 = strtolower($img_ex1);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto1']['tmp_name'])){

                        if (in_array($img_ex_lc1, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name1 = bin2hex(random_bytes(20)).'.'.$img_ex_lc1;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name1;
                            move_uploaded_file($tmp_name1, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto1 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name1, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error2 === 0 ) {  

                if(!empty($img2)){
                    //Estensione del file + Corsivo
                    $img_ex2 = pathinfo($img2, PATHINFO_EXTENSION);
                    $img_ex_lc2 = strtolower($img_ex2);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto2']['tmp_name'])){

                        if (in_array($img_ex_lc2, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name2 = bin2hex(random_bytes(20)).'.'.$img_ex_lc2;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name2;
                            move_uploaded_file($tmp_name2, $img_upload_path);

                            // aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto2 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name2, $_POST['id']);
                            $s->execute();  
                            $s->store_result();
                            
                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error3 === 0 ) {  

                if(!empty($img3)){
                    //Estensione del file + Corsivo
                    $img_ex3 = pathinfo($img3, PATHINFO_EXTENSION);
                    $img_ex_lc3 = strtolower($img_ex3);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto3']['tmp_name'])){

                        if (in_array($img_ex_lc3, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name3 = bin2hex(random_bytes(20)).'.'.$img_ex_lc2;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name3;
                            move_uploaded_file($tmp_name3, $img_upload_path);

                            // aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto3 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name3, $_POST['id']);
                            $s->execute();  
                            $s->store_result();  

                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error4 === 0 ) {  

                if(!empty($img4)){
                    //Estensione del file + Corsivo
                    $img_ex4 = pathinfo($img4, PATHINFO_EXTENSION);
                    $img_ex_lc4 = strtolower($img_ex4);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto4']['tmp_name'])){

                        if (in_array($img_ex_lc4, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name4 = bin2hex(random_bytes(20)).'.'.$img_ex_lc4;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name4;
                            move_uploaded_file($tmp_name4, $img_upload_path);

                            // aggiorno file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto4 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name4, $_POST['id']);
                            $s->execute();  
                            $s->store_result();    


                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error5 === 0 ) {  

                if(!empty($img5)){
                    //Estensione del file + Corsivo
                    $img_ex5 = pathinfo($img5, PATHINFO_EXTENSION);
                    $img_ex_lc5 = strtolower($img_ex5);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto5']['tmp_name'])){

                        if (in_array($img_ex_lc5, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name5 = bin2hex(random_bytes(20)).'.'.$img_ex_lc5;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name5;
                            move_uploaded_file($tmp_name5, $img_upload_path);

                            // aggiorno file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto5 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name5, $_POST['id']);
                            $s->execute();  
                            $s->store_result();    

                        }else{
                            //errore
                        }
                    }
                }
            }

            if ($error6 === 0 ) {  

                if(!empty($img6)){

                    //Estensione del file + Corsivo
                    $img_ex6 = pathinfo($img6, PATHINFO_EXTENSION);
                    $img_ex_lc6 = strtolower($img_ex6);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto6']['tmp_name'])){

                        if (in_array($img_ex_lc6, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name6 = bin2hex(random_bytes(20)).'.'.$img_ex_lc6;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name6;
                            move_uploaded_file($tmp_name6, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto6 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name6, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }  
            
            if ($error7 === 0 ) {  

                if(!empty($img7)){

                    //Estensione del file + Corsivo
                    $img_ex7 = pathinfo($img7, PATHINFO_EXTENSION);
                    $img_ex_lc7 = strtolower($img_ex7);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto7']['tmp_name'])){

                        if (in_array($img_ex_lc7, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name7 = bin2hex(random_bytes(20)).'.'.$img_ex_lc7;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name7;
                            move_uploaded_file($tmp_name7, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto7 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name7, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }   
            
            if ($error8 === 0 ) {  

                if(!empty($img8)){

                    //Estensione del file + Corsivo
                    $img_ex8 = pathinfo($img8, PATHINFO_EXTENSION);
                    $img_ex_lc8 = strtolower($img_ex8);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto8']['tmp_name'])){

                        if (in_array($img_ex_lc8, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name8 = bin2hex(random_bytes(20)).'.'.$img_ex_lc8;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name8;
                            move_uploaded_file($tmp_name8, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto8 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name8, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }  
            
            if ($error9 === 0 ) {  

                if(!empty($img9)){

                    //Estensione del file + Corsivo
                    $img_ex9 = pathinfo($img9, PATHINFO_EXTENSION);
                    $img_ex_lc9 = strtolower($img_ex9);

                    // Se il file è stato caricato
                    if(file_exists($_FILES['foto9']['tmp_name'])){

                        if (in_array($img_ex_lc9, $allowed_ex)) {

                            // Crea il nuovo nome Tipo Giorno Giovanna, che nome è merd btw + sposta il file nella cartella 
                            $new_img_name9 = bin2hex(random_bytes(20)).'.'.$img_ex_lc9;
                            $img_upload_path = '../../images/articoli/'.$categoria.'/'.$new_img_name9;
                            move_uploaded_file($tmp_name9, $img_upload_path);

                            //aggiorno il file della foto
                            $s=$conn->prepare("UPDATE prodotti_foto SET foto9 = ? WHERE id_prodotto = ?");
                            $s->bind_param("si", $new_img_name9, $_POST['id']);
                            $s->execute();  

                        }else{
                            //errore
                        }
                    }
                }
            }            
            
            $_SESSION['fotoArticolo'] = 1;
            echo'<script> location.replace("../../pages/admin/articoli"); </script>';

        }
        else
            {
                $_SESSION['fotoArticolo'] = 2;
                echo'<script> location.replace("../../pages/admin/articoli"); </script>';
            }

    }
    
    // cerca prodotti
    if(isset($_POST["cercaProdotti"])) {

        $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione, p.categoria,
                                    pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                                    pv.id_taglia, pv.id_colore, pv.quantita, p._like, p.in_sconto
                            FROM prodotti as p
                            JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                            JOIN prodotti_varianti  as pv ON pf.id_prodotto =  p.id_prodotto
                            WHERE nome LIKE '%".$_POST['nome']."%'
                            ORDER BY nome ASC
                            ");		
        $s->execute();  
        $s->store_result();

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $prezzo = $row['prezzo'];
            $descrizione = $row['descrizione'];
            $categoria = $row['categoria'];
            $foto1 = $row['foto1'];
            $foto2 = $row['foto2'];
            $foto3 = $row['foto3'];
            $foto4 = $row['foto4'];
            $foto5 = $row['foto5'];
            $taglia = $row['id_taglia'];
            $colore = $row['id_colore'];
            $quantita = $row['quantita'];
            $like = $row['like'];
            $in_sconto = $row['in_sconto'];

        }

    }
    
    // inserisci taglia
    if(isset($_POST["inserisciTaglia"])) {
        
        if(!empty($_POST['taglia'])){
            $s=$conn->prepare("INSERT INTO taglia (n_taglia)
                                    VALUES (?)");
            $s->bind_param("s", $_POST['taglia']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }

    }
    
    // modifica taglia
    if(isset($_POST["modificaTaglia"])) {

        $s=$conn->prepare("UPDATE taglia SET n_taglia = ? WHERE id = ?");
        $s->bind_param("si", $_POST['nome'], $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }  
    
    // elimina taglia
    if(isset($_POST["eliminaTaglia"])) {

        $s=$conn->prepare("DELETE FROM taglia WHERE id = ?");
        $s->bind_param("i", $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }
    
    // lista taglia
    if(isset($_POST["listaTaglia"])) {

        $s=$conn->prepare("SELECT * FROM taglia");
        $s->execute();  
        $r = $s->get_result(); 

        while ($row = $r->fetch_assoc()) {

            $id = $row['id'];
            $nome = $row['n_taglia'];
            $categoria = $row['categoria'];

        }
    
    }
    
    // inserisci colore
    if(isset($_POST["inserisciColore"])) {

        if(!empty($_POST['colore'])){
            $s=$conn->prepare("INSERT INTO colore (n_colore)
                                    VALUES (?)");
            $s->bind_param("s", $_POST['colore']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }

    } 
    
    // modifica colore
    if(isset($_POST["modificaColore"])) {

        $s=$conn->prepare("UPDATE colore SET n_colore =? WHERE id = ?");
        $s->bind_param("si", $_POST['nome'], $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }  
    
    // elimina colore
    if(isset($_POST["eliminaColore"])) {

        $s=$conn->prepare("DELETE FROM colore WHERE id = ?");
        $s->bind_param("i", $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }
    
    // lista colori
    if(isset($_POST["listaColore"])) {

        $s=$conn->prepare("SELECT * FROM colore");
        $s->execute();  
        $r = $s->get_result(); 

        while ($row = $r->fetch_assoc()) {

            $id = $row['id'];
            $nome = $row['n_colore'];

        }
    
    } 

    // inserisci categoria
    if(isset($_POST["inserisciCategoria"])) {

        if(!empty($_POST['attiva']) && !empty($_POST['categoria'])){
            $s=$conn->prepare("INSERT INTO categoria (n_categoria, attiva)
                                    VALUES (?,?)");
            $s->bind_param("si", $_POST['categoria'], $_POST['attiva']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';;
        }

    }
    
    // modifica categoria
    if(isset($_POST["modificaCategoria"])) {

        $s=$conn->prepare("UPDATE categoria SET n_categoria =?, attiva = ? WHERE id = ?");
        $s->bind_param("sii", $_POST['nome'], $_POST['attiva'], $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }  
    
    // elimina categoria
    if(isset($_POST["eliminaCategoria"])) {

        $s=$conn->prepare("DELETE FROM categoria WHERE id = ?");
        $s->bind_param("i", $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }
    
    // lista categoria
    if(isset($_POST["listaCategoria"])) {

        $s=$conn->prepare("SELECT * FROM categoria");
        $s->execute();  
        $r = $s->get_result(); 

        while ($row = $r->fetch_assoc()) {

            $id = $row['id'];
            $nome = $row['n_categoria'];
            $attiva = $row['attiva'];

        }
    
    } 

    // attiva categoria
    if(isset($_POST["attivaCategoria"])) {

        if(!empty($_POST['categoria']) && !empty($_POST['attiva'])){
            $s=$conn->prepare("UPDATE categoria SET attiva = ? WHERE id = ?");
            $s->bind_param("si", $_POST['attiva'], $_POST['categoria']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }

    }    

    // modifica banner home
    if(isset($_POST["modificaBannerHome"])) {

        if(!empty($_POST['sconto']) && !empty($_POST['descrizione'])){

            $id = 1;

            $s=$conn->prepare("UPDATE banner_home SET sconto =?, descrizione = ? WHERE id = ?");
            $s->bind_param("isi", $_POST['sconto'], $_POST['descrizione'], $id);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
    }
    
    // modifica codice sconto
    if(isset($_POST["modificaCodiceSconto"])) {

        $s=$conn->prepare("UPDATE cod_sconto SET nome = ?, codice = ? WHERE id = ?");
        $s->bind_param("ssi", $_POST['nome'], $_POST['codice'], $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }  
    
    // elimina codice sconto
    if(isset($_POST["eliminaCodiceSconto"])) {

        $s=$conn->prepare("DELETE FROM cod_sconto WHERE id = ?");
        $s->bind_param("i", $_POST['id']);
        $s->execute();  
        $s->store_result();  
    
    }
    
    // lista codice sconto
    if(isset($_POST["listaCodiceSconto"])) {

        $s=$conn->prepare("SELECT * FROM cod_sconto");
        $s->execute();  
        $r = $s->get_result(); 

        while ($row = $r->fetch_assoc()) {

            $id = $row['id'];
            $nome = $row['nome'];
            $codice = $row['codice'];

        }
    
    }

    // registrazione utente
    if(isset($_POST["registraUtente"])) {

        // dichiarazione +  escape + minuscolo + hash password default
        $nome = mysqli_real_escape_string($conn, strtolower($_POST['nome']));
        $cognome = mysqli_real_escape_string($conn, strtolower($_POST['cognome']));
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $campanello = mysqli_real_escape_string($conn, strtolower($_POST['campanello']));
        $indirizzo = mysqli_real_escape_string($conn, strtolower($_POST['indirizzo']));
        $citta= mysqli_real_escape_string($conn, strtolower($_POST['citta']));
        $cap = mysqli_real_escape_string($conn, $_POST['cap']);
        $provincia = mysqli_real_escape_string($conn, strtolower($_POST['provincia']));
        $telefono= mysqli_real_escape_string($conn, $_POST['telefono']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password_h = password_hash($password, PASSWORD_DEFAULT);

        $testo = 4; //nuovo iscritto
        $stato = 0; //non letta

        // extra
        $pre_cod = rand();
        $cod_cookie = hash("sha256", $pre_cod);
        $cod_recupero = rand (10000,99999);
        $data = date("Y/m/d");
        $cod_carrello = $_SESSION['cod_carrello'];

        // Validation backend + check errori
        if  (!empty($nome) && !empty($cognome) && !empty($email) && !empty($password)
                && !empty($indirizzo) && !empty($citta) && !empty($cap) && !empty($telefono)
                && strlen($telefono) == 10 && strlen($cap) == 5 && strlen($password) <= 30)
            {

                // Check dell'esistenza in db
                $s=$conn->prepare("SELECT email FROM utente_indirizzo WHERE email = ?");		
                $s->bind_param("s", $email);
                $s->execute();  
                $s->store_result();

            if ($s->num_rows > 0) 
                {

                    $_SESSION['utenteNotifica'] = 3;
                    echo'<script> location.replace("../../"); </script>';
                }

            else

                {
                    // insert utente
                    $s1=$conn->prepare("INSERT INTO utente (nome, cognome, data_iscrizione, cod_cookie, cod_recupero, cod_carrello, password) 
                                        VALUES (?,?,?,?,?,?,?)");		
                    $s1->bind_param("ssssiss", $nome, $cognome, $data, $cod_cookie, $cod_recupero, $cod_carrello, $password_h);
                    $s1->execute();  
                    $s1->store_result();

                    //LAST ID
	                $last_id = mysqli_insert_id($conn);

                    // Check campanello 
                if(!empty($campanello)) 

                    {
                        $s1=$conn->prepare("INSERT INTO utente_indirizzo (id_utente, indirizzo, citta, cap, provincia, nome_campanello, telefono, email)
                                             VALUES (?,?,?,?,?,?,?,?)");		
                        $s1->bind_param("isssisss", $last_id, $indirizzo, $citta, $cap, $provincia, $campanello, $telefono, $email);
                        $s1->execute();  
                        $s1->store_result();
                    }

                else

                    {
                        //insert indirizzo
                        $s1=$conn->prepare("INSERT INTO utente_indirizzo (id_utente, indirizzo, citta, cap, provincia, telefono, email)
                                                     VALUES (?,?,?,?,?,?,?)");		
                        $s1->bind_param("issssss", $last_id, $indirizzo, $citta, $cap, $provincia, $telefono, $email);
                        $s1->execute();  
                        $s1->store_result();
                    }

                        //insert notifica
                        $s1=$conn->prepare("INSERT INTO notifiche (id_ordine, testo, stato)
                                            VALUES (?,?,?)");		
                        $s1->bind_param("iii", $last_id, $testo, $stato);
                        $s1->execute();  
                        $s1->store_result();


                    $_SESSION['utenteNotifica'] = 1;
                    // Redirect
                    echo'<script> location.replace("../../"); </script>';

                }    

            }
        else
        {
            $_SESSION['utenteNotifica'] = 2;
            echo'<script> location.replace("../../"); </script>';
        }
    }
     
    // accedi utente
    if(isset($_POST["accediUtente"])) {
        // dichiarazione +  escape
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Validation backend + check errori
        if  (!empty($email) && !empty($password))
        {
            $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello, u.cod_recupero, u.password,
                                            ui.indirizzo, ui.citta, ui.cap, ui.nome_campanello, ui.telefono,
                                            p.nome_province
                                    FROM utente as u
                                    JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                                    JOIN province as p ON p.id_province = ui.provincia
                                    WHERE ui.email = ?");		
            $s->bind_param("s", $email);
            $s->execute();  
            $s->store_result();

            if ($s->num_rows > 0) {
                $s->bind_result($id, $nome, $cognome, $cod_cookie, $cod_carrello, $cod_recupero, $h,
                                 $indirizzo, $citta, $cap, $nome_province, $campanello, $telefono);
                $s->fetch();

                if (password_verify($password, $h)) {

                    session_regenerate_id();
                    $_SESSION['id'] = $id;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['cognome'] = $cognome;
                    $_SESSION['access'] = $cod_cookie;
                    $_SESSION['cod_carrello'] = $cod_carrello;
                    $_SESSION['cod_recupero'] = $cod_recupero;
                    $_SESSION['indirizzo'] = $indirizzo;
                    $_SESSION['citta'] = $citta;
                    $_SESSION['cap'] = $cap;
                    $_SESSION['provincia'] = $nome_province;
                    $_SESSION['campanello'] = $campanello;
                    $_SESSION['telefono'] = $telefono;
                    $_SESSION['email'] = $email;

                    unset($_SESSION['avx']);

                    $_SESSION['utenteNotifica'] = 4;
                    // cookie e redirect
                    echo '
                        <script> 
                                document.cookie = "access='.$_SESSION['access'].'; max-age=31536000; path=/";
                                document.cookie = "cod_carrello='.$_SESSION['cod_carrello'].'; max-age=31536000; path=/";
                                location.replace("../../index");
                         </script>';

                }
                else
                    {
                        $_SESSION['utenteNotifica'] = 5;
                        echo '<script> location.replace("../../index"); </script>';
                    }  

            }
        else
            {
                $_SESSION['utenteNotifica'] = 5;
                echo'<script> location.replace("../../index"); </script>';
            }    

        }
    }

    // registrazione utente
    if(isset($_POST["modificaUtente"])) {

        // dichiarazione +  escape + minuscolo + hash password default
        $nome = mysqli_real_escape_string($conn, strtolower($_POST['nome']));
        $cognome = mysqli_real_escape_string($conn, strtolower($_POST['cognome']));
        $campanello = mysqli_real_escape_string($conn, strtolower($_POST['campanello']));
        $indirizzo = mysqli_real_escape_string($conn, strtolower($_POST['indirizzo']));
        $citta= mysqli_real_escape_string($conn, strtolower($_POST['citta']));
        $cap = mysqli_real_escape_string($conn, $_POST['cap']);
        $provincia = mysqli_real_escape_string($conn, strtolower($_POST['provincia']));
        $telefono= mysqli_real_escape_string($conn, $_POST['telefono']);

            if(!empty($nome)) {
                $s=$conn->prepare("UPDATE utente SET nome = ? WHERE id = ?");		
                $s->bind_param("si", $nome,  $_SESSION['id']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($cognome)) {
                $s=$conn->prepare("UPDATE utente SET cognome = ? WHERE id = ?");		
                $s->bind_param("si", $cognome,  $_SESSION['id']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($campanello)) {
                $s=$conn->prepare("UPDATE utente_indirizzo SET nome_campanello = ? WHERE id_utente = ?");		
                $s->bind_param("si", $campanello,  $_SESSION['id_utente']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($indirizzo)) {
                $s=$conn->prepare("UPDATE utente_indirizzo SET indirizzo = ? WHERE id_utente = ?");		
                $s->bind_param("si", $indirizzo,  $_SESSION['id_utente']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($citta)) {
                $s=$conn->prepare("UPDATE utente_indirizzo SET citta = ? WHERE id_utente = ?");		
                $s->bind_param("si", $citta,  $_SESSION['id_utente']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($cap)) {
                $s=$conn->prepare("UPDATE utente_indirizzo SET cap = ? WHERE id_utente = ?");		
                $s->bind_param("ii", $cap, $_SESSION['id_utente']);
                $s->execute();  
                $s->store_result();

            }

            if(!empty($provincia)) {
                $s=$conn->prepare("UPDATE utente_indirizzo SET provincia = ? WHERE id_utente = ?");		
                $s->bind_param("si", $provincia, $_SESSION['id_utente']);
                $s->execute();  
                $s->store_result();

            }

            $_SESSION['utenteNotifica'] = 1;
            // Redirect
            echo'<script> location.replace("../../pages/utente/i-miei-dati"); </script>';

    } 

    // rimuovi like
    if(isset($_POST['unlike'])){
        //like esistente quindi cancello
        $s1=$conn->prepare("DELETE FROM likes WHERE id_utente = ? AND prodotto = ?");	
        $s1->bind_param("ii", $_SESSION['id'], $_POST['id']);	
        $s1->execute();  
        $s1->store_result();

        $s2=$conn->prepare("SELECT _like from prodotti WHERE id_prodotto = ?");	
        $s2->bind_param("i", $_POST['id']);	
        $s2->execute();  
        $r = $s2->get_result();

        while ($row = $r->fetch_assoc()) {
            $likeDB = $row['_like'];

            $likeFinale = $likeDB - 1;

            $s=$conn->prepare("UPDATE prodotti SET _like = ? WHERE id_prodotto = ?");	
            $s->bind_param("ii", $likeFinale, $_POST['id']);	
            $s->execute();  
            $s->store_result();
        }

        echo'<script> location.replace("../../pages/collezione/tutta-la-collezione"); </script>';

    }

    // inserisci like
    if(isset($_POST['like'])){
        //like inesistente quindi inserisco
        $s1=$conn->prepare("INSERT INTO likes (id_utente, prodotto) VALUES (?,?)");	
        $s1->bind_param("ii", $_SESSION['id'], $_POST['id']);	
        $s1->execute();  
        $s1->store_result();

        $s2=$conn->prepare("SELECT _like from prodotti WHERE id_prodotto = ?");	
        $s2->bind_param("i", $_POST['id']);	
        $s2->execute();  
        $r = $s2->get_result();

        while ($row = $r->fetch_assoc()) {
            $likeDB = $row['_like'];

            $likeFinale = $likeDB + 1;

            $s=$conn->prepare("UPDATE prodotti SET _like = ? WHERE id_prodotto = ?");	
            $s->bind_param("ii", $likeFinale, $_POST['id']);	
            $s->execute();  
            $s->store_result();
        }
        echo'<script> location.replace("../../pages/collezione/tutta-la-collezione"); </script>';

    }

    //inserisci nel carrello
    if(isset($_POST['inserisciCarrello'])) {

        /* ADD CHECK DB FORSE*/

		$id_utente = $_SESSION['cod_carrello'];
		$articolo = $_SESSION['articolo'];
		$id_colore = $_POST['id_colore'];
		$id_taglia = $_POST['id_taglia'];
		$prezzo = $_SESSION['prezzo'];
        $q=1;
		$quantita = $q;

        if(!empty($articolo) && !empty($id_colore) && !empty($id_taglia) && !empty($prezzo))
            {

                $s1=$conn->prepare("SELECT * FROM carrello
                                    WHERE id_utente = ?
                                    AND id_prodotto = ?
                                    AND id_colore = ?
                                    AND id_taglia = ?");	
                $s1->bind_param("siii", $id_utente, $articolo, $id_colore, $id_taglia);	
                $s1->execute();  
                $s1->store_result();

                if ($s1->num_rows > 0) 
                {
                    $_SESSION['articoloCarrello'] = 1; //notifica articolo già esistente nel carrello
                    unset($_SESSION['prezzo']);
                    unset($_SESSION['articolo']);
                    echo'<script> location.replace("../../pages/collezione/tutta-la-collezione"); </script>';   
                }
                else
                {

                    $s2=$conn->prepare("INSERT INTO carrello (id_utente, id_prodotto, id_colore, id_taglia, n_quantita, prezzo_singolo, prezzo_totale) 
                                        VALUES (?,?,?,?,?,?,?)");	
                    $s2->bind_param("siiiidd", $id_utente, $articolo, $id_colore, $id_taglia, $quantita, $prezzo, $prezzo);	
                    $s2->execute();  
                    $s2->store_result();
                    
                    $_SESSION['articoloCarrello'] = 2; //notifica articolo aggiunto con successo nel carrello
                    unset($_SESSION['prezzo']);
                    unset($_SESSION['articolo']);
                    echo'<script> location.replace("../../pages/carrello/carrello"); </script>';
                }
            }

        else
            {
                unset($_SESSION['prezzo']);
                unset($_SESSION['articolo']);
                echo'<script> location.replace("../../"); </script>'; 
            }

    }

    // diminuisci quantita carrello
    if(isset($_POST["diminuisciQuantita"])) {

        // dichiaro variabili
        $id =  $_POST['id'];
        $riga = $_POST['riga'];
        $quantita = $_POST['quantita'];
        $prezzo = $_POST['prezzo'];
        $id_utente = $_SESSION['cod_carrello'];
        $q= $quantita - 1;

        //calcolo il totale
        $totale = $q * $prezzo;

        //controllo variabili con if
        if(!empty($quantita) && !empty($id) && !empty($id_utente) && !empty($prezzo)) {

            //check database
            $s1=$conn->prepare("SELECT * FROM carrello
                                WHERE id_prodotto = ?
                                AND id = ?
                                AND id_utente = ?");	
            $s1->bind_param("iii", $id, $riga, $id_utente);	
            $s1->execute();  
            $r = $s1->get_result(); 

            while ($row = $r->fetch_assoc()) {

                $db_riga = $row['id'];
                $db_id_prodotto = $row['id_prodotto'];
                $db_prezzo = $row['prezzo_singolo'];
                $db_utente = $row['id_utente'];
            }

            //check database con if
            if($db_riga == $riga && $db_id_prodotto == $id && $db_prezzo == $prezzo && $db_utente == $id_utente)  {

                if($quantita == 1){

                    $s=$conn->prepare("DELETE FROM carrello
                                        WHERE id = ?");	
                    $s->bind_param("i", $riga);	
                    $s->execute();  
                    $s->store_result();
                    
                    echo'<script> location.replace("../../pages/carrello/carrello"); </script>';

                }
                else 
                {

                    $s=$conn->prepare("UPDATE carrello SET n_quantita = ?, prezzo_totale = ?
                                        WHERE id_utente = ?
                                        AND id_prodotto = ?");	
                    $s->bind_param("idsi", $q, $totale, $id_utente, $id);	
                    $s->execute();  
                    $s->store_result();


                    echo'<script> location.replace("../../pages/carrello/carrello"); </script>';

                }

            }
            else
            {
                echo'<script> location.replace("../../pages/carrello/carrello?error-volevi"); </script>';
            }

        }
        else
        {
            echo'<script> location.replace("../../pages/carrello/carrello?error"); </script>';
        }

    }

    // aumenta quantita carrello
    if(isset($_POST["incrementaQuantita"])) {

        // dichiaro variabili
        $id =  $_POST['id'];
        $riga = $_POST['riga'];
        $quantita = $_POST['quantita'];
        $prezzo = $_POST['prezzo'];
        $id_utente = $_SESSION['cod_carrello'];
        $q= $quantita + 1;

        //calcolo il totale
        $totale = $q * $prezzo;

        //controllo variabili con if
        if(!empty($quantita) && !empty($id) && !empty($id_utente) && !empty($prezzo)) {

            //check database
            $s1=$conn->prepare("SELECT * FROM carrello
                                WHERE id_prodotto = ?
                                AND id = ?
                                AND id_utente = ?");	
            $s1->bind_param("iii", $id, $riga, $id_utente);	
            $s1->execute();  
            $r = $s1->get_result(); 

            while ($row = $r->fetch_assoc()) {

                $db_riga = $row['id'];
                $db_id_prodotto = $row['id_prodotto'];
                $db_prezzo = $row['prezzo_singolo'];
                $db_utente = $row['id_utente'];
                $db_quantita = $row['n_quantita'];
            }

            //check database con if
            if($db_riga == $riga && $db_id_prodotto == $id && $db_prezzo == $prezzo && $db_utente == $id_utente)  {

                if($db_quantita >= 5){
                  
                    echo'<script> location.replace("../../pages/carrello/carrello?limite-consentito"); </script>';

                }
                else 
                {

                    $s=$conn->prepare("UPDATE carrello SET n_quantita = ?, prezzo_totale = ?
                                        WHERE id_utente = ?
                                        AND id_prodotto = ?");	
                    $s->bind_param("idsi", $q, $totale, $id_utente, $id);	
                    $s->execute();  
                    $s->store_result();


                    echo'<script> location.replace("../../pages/carrello/carrello"); </script>';;

                }

            }
            else
            {
                echo'<script> location.replace("../../pages/carrello/carrello?error-volevi"); </script>';
            }

        }
        else
        {
            echo'<script> location.replace("../../pages/carrello/carrello?error"); </script>';
        }

    }
 
    // inserisci codice sconto articolo
    if(isset($_POST["inserisciCodScontoArticolo"])) {

        if(!empty($_POST['nome']) && !empty($_POST['valore'])  && !empty($_POST['tipo']) && !empty($_POST['articolo']) && !empty($_POST['codice'])){

            $s=$conn->prepare("INSERT INTO cod_sconto (nome, valore, codice, tipo, gamma, durata)
                                    VALUES (?,?,?,?,?,?)");
            $s->bind_param("sisiis", $_POST['nome'], $_POST['valore'], $_POST['codice'], $_POST['tipo'], $_POST['articolo'], $_POST['data']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
    
    }
    
    // inserisci codice sconto categoria
    if(isset($_POST["inserisciCodScontoTutto"])) {

        if(!empty($_POST['nome']) && !empty($_POST['valore'])  && !empty($_POST['tipo']) && !empty($_POST['codice']) && !empty($_POST['data'])){

            $s=$conn->prepare("INSERT INTO cod_sconto (nome, valore, codice, tipo, durata)
                                    VALUES (?,?,?,?,?)");
            $s->bind_param("sisis", $_POST['nome'], $_POST['valore'], $_POST['codice'], $_POST['tipo'], $_POST['data']);
            $s->execute();  
            $s->store_result();  

            $_SESSION['success'] = 1;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
        else
        {
            $_SESSION['success'] = 2;
            echo'<script> location.replace("../../pages/admin/extra"); </script>';
        }
    
    }     

    // checkout codice sconto
    if(isset($_POST["coupon"])){
        $cod = htmlspecialchars($_POST['codice']);
        $complessivo = 0;
        $complessivo2 = 0;

        // controllo se un coupon è stato già utilizzato
        $s=$conn->prepare("SELECT * FROM utente_sconto
                            WHERE id_utente = ?");	
        $s->bind_param("i", $_SESSION['id']);	
        $s->execute();  
        $r = $s->get_result(); 

        while ($row = $r->fetch_assoc()) {
            $coupon = $row['id_sconto'];
        }

            if(empty($coupon)){//se il coupon non è stato utilizzato

                // check codice sconto nel db
                $s1=$conn->prepare("SELECT * FROM cod_sconto
                                WHERE codice = ?");	
                $s1->bind_param("s", $cod);	
                $s1->execute();  
                $r1 = $s1->get_result(); 

                while ($row = $r1->fetch_assoc()) {
                    $id_codice = $row['id'];
                    $codice = $row['codice'];
                    $tipo = $row['tipo'];
                    $gamma = $row['gamma'];
                    $valore = $row['valore'];
                }

                //seleziono tutti i tuoi articoli
                $s2=$conn->prepare("SELECT c.id, c.id_prodotto, c.prezzo_totale,
                                        p.categoria
                                    FROM carrello AS c
                                    JOIN prodotti AS p ON p.id_prodotto = c.id_prodotto
                                    WHERE c.id_utente = ?
                                    LIMIT 1");	
                $s2->bind_param("s", $_SESSION['cod_carrello']);	
                $s2->execute();  
                $r2 = $s2->get_result();  

                while ($row = $r2->fetch_assoc()) {
                    $id_prodotto = $row['id_prodotto'];
                    $categoria = $row['categoria'];
                    $complessivo = $complessivo + $row['prezzo_totale'];
                }                

                if(!empty($codice)){ //il codice esiste nel db

                    if($tipo == 1 AND $gamma == null){ // euro + tutta la gamma  1052668106

                        // vado a scontare il tuo articolo
                        $complessivo = $complessivo - $valore;

                        // aggiorno il tuo prezzo nel db
                        $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                            WHERE id_utente = ?
                                            LIMIT 1");	
                        $s1->bind_param("is", $complessivo, $_SESSION['cod_carrello']);	
                        $s1->execute();  

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();     

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';

                    }

                    elseif($tipo == 1 AND $categoria == $gamma AND $gamma <= 999){//euro + categoria

                        // vado a scontare il tuo articolo
                        $complessivo = $complessivo - $valore;

                        // aggiorno il tuo prezzo nel db
                        $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                            WHERE id_utente = ?
                                            LIMIT 1");	
                        $s1->bind_param("is", $complessivo, $_SESSION['cod_carrello']);	
                        $s1->execute();  

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();     

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';

                    }

                    elseif($tipo == 1 AND $id_prodotto == $gamma AND $gamma >= 1000 ){//euro + articolo

                        // vado a scontare il tuo articolo
                        $complessivo = $complessivo - $valore;

                        // aggiorno il tuo prezzo nel db
                        $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                            WHERE id_utente = ?
                                            LIMIT 1");	
                        $s1->bind_param("is", $complessivo, $_SESSION['cod_carrello']);	
                        $s1->execute();  

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();     

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';                        

                    }

                    elseif($tipo == 2 AND $gamma == null ){ //percentuale + tutta la gamma     
                        
                        //seleziono tutti i tuoi articoli per la percentuale
                        $s5=$conn->prepare("SELECT c.id, c.prezzo_totale
                                            FROM carrello AS c
                                            WHERE c.id_utente = ?");	
                        $s5->bind_param("s", $_SESSION['cod_carrello']);	
                        $s5->execute();  
                        $r5 = $s5->get_result();  

                        while ($row = $r5->fetch_assoc()) {
                            $riga = $row['id'];
                            $complessivo2 = $row['prezzo_totale'];
                                              
                            // vado a scontare il tuo articolo
                            $complessivo3 = $complessivo2  * $valore / 100;
                            $complessivo2 -= $complessivo3;

                            // aggiorno il tuo prezzo nel db
                            $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                                WHERE id_utente = ?
                                                AND id = ?");	
                            $s1->bind_param("isi", $complessivo2, $_SESSION['cod_carrello'], $riga);	
                            $s1->execute();  
                            
                        }

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();                         

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';

                    }
                    elseif($tipo == 2 AND $categoria == $gamma AND $gamma <= 999 ){ //percentuale + categoria            

                        //seleziono tutti i tuoi articoli per la percentuale
                        $s5=$conn->prepare("SELECT c.id, c.prezzo_totale
                                            FROM carrello AS c
                                            WHERE c.id_utente = ?");	
                        $s5->bind_param("s", $_SESSION['cod_carrello']);	
                        $s5->execute();  
                        $r5 = $s5->get_result();  

                        while ($row = $r5->fetch_assoc()) {
                            $riga = $row['id'];
                            $complessivo2 = $row['prezzo_totale'];
                                              
                            // vado a scontare il tuo articolo
                            $complessivo3 = $complessivo2  * $valore / 100;
                            $complessivo2 -= $complessivo3;

                            // aggiorno il tuo prezzo nel db
                            $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                                WHERE id_utente = ?
                                                AND id = ?");	
                            $s1->bind_param("isi", $complessivo2, $_SESSION['cod_carrello'], $riga);	
                            $s1->execute();  
                            
                        }

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();                         

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';                        
                    } 
                    elseif($tipo == 2 AND $id_prodotto == $gamma AND $gamma >= 1000 ){ //percentuale + articolo   
  
                        //seleziono tutti i tuoi articoli per la percentuale
                        $s5=$conn->prepare("SELECT c.id, c.prezzo_totale
                                            FROM carrello AS c
                                            WHERE c.id_utente = ?");	
                        $s5->bind_param("s", $_SESSION['cod_carrello']);	
                        $s5->execute();  
                        $r5 = $s5->get_result();  

                        while ($row = $r5->fetch_assoc()) {
                            $riga = $row['id'];
                            $complessivo2 = $row['prezzo_totale'];
                                              
                            // vado a scontare il tuo articolo
                            $complessivo3 = $complessivo2  * $valore / 100;
                            $complessivo2 -= $complessivo3;

                            // aggiorno il tuo prezzo nel db
                            $s1=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                                                WHERE id_utente = ?
                                                AND id = ?");	
                            $s1->bind_param("isi", $complessivo2, $_SESSION['cod_carrello'], $riga);	
                            $s1->execute();  
                            
                        }

                        // inserisco la riga di codice già utilizzato
                        $s2=$conn->prepare("INSERT INTO utente_sconto (id_utente, id_sconto)
                                            VALUES (?,?)");	
                        $s2->bind_param("ii", $_SESSION['id'], $id_codice);	
                        $s2->execute();                         

                        //notifiche
                        $_SESSION['notificaSconto'] = 1;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';                         

                    }
                    else {
                        $_SESSION['notificaSconto'] = 0;
                        echo'<script> location.replace("../../pages/carrello/checkout"); </script>';
                    }

                }
                else{
                    $_SESSION['notificaSconto'] = 0;
                    echo'<script> location.replace("../../pages/carrello/checkout"); </script>';
                }

            }

            else{
                $_SESSION['notificaSconto'] = 0;
                echo'<script> location.replace("../../pages/carrello/checkout"); </script>';
            }
    }

    // codice tracking con utente registrato 
    if(isset($_POST["modificaStatoOrdine"])){

        //ricevo i dati - utilizzo l'explode e array
        $r = $_POST['id'];
        $r_explode = explode('|', $r);
        $id_ordine = $r_explode[0];
        $prodotti = $r_explode[1];
        $id_utente = $r_explode[2];
        $data = $r_explode[3];
        $indirizzo = $r_explode[4];
        $citta = $r_explode[5];
        $cap = $r_explode[6];
        $provincia = $r_explode[7];
        $campanello = $r_explode[8];
        $telefono = $r_explode[9];
        $email = $r_explode[10];
        $nome = $r_explode[11];
        $cognome = $r_explode[12];
        $prezzo = $r_explode[13];
        
        $codice = $_POST['codice'];
        $stato = 1;

        $s=$conn->prepare("UPDATE ordini SET stato = ?, tracking = ? WHERE id = ?");
        $s->bind_param("ssi", $stato, $codice, $id_ordine);
        $s->execute();  
        $s->store_result();  

        if($stato == 1){

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
								font-size: 24px;
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
								color: white !important;
								font-size: 2vh;
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
								<h1 class="upper">Gentile '.$nome.' '.$cognome.'</h1>
								<p>
									Grazie per il tuo ordine. Ti informiamo che il tuo ordine è stato spedito.
									La tua data di consegna prevista è indicata in basso.
									Di seguito troverai il codice tracking del tuo ordine.
								</p>
							</div>
							<div id="two-col">
								<h1>Riepilogo ordine</h1>
									<hr>
									<p>ordine n°'.$id_ordine.'</p>
									<p>Effettuato il '.$data.'</p>
									<hr>
							</div>
							<div id="three-col">
								<h1>Codice:</h1>
								<p>'.$codice.'</p>
							</div>
							<div class="column">
								<p style="font-size:1rem;">
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
			$to = $email;
			$subject = 'il tuo ordine è in arrivo';
			$message = $m;
            $from = 'noreply@freestyleconceptstore.it';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";
                 
			$headers .= "From: ".$from."\r\n";

            mail($to, $subject, $message, $headers);
 
 
            $_SESSION['notificaStato'] = 0;
            echo'<script> location.replace("../../pages/admin/ordini"); </script>';
        }
        else {
            $_SESSION['notificaStato'] = 1;
            echo'<script> location.replace("../../pages/admin/ordini"); </script>';
        }


    
    } 

    // codice tracking con utente senza registrazione  
    if(isset($_POST["modificaStatoOrdine2"])){

        //ricevo i dati - utilizzo l'explode e array
        $r = $_POST['id'];
        $r_explode = explode('|', $r);
        $id_ordine = $r_explode[0];
        $prodotti = $r_explode[1];
        $id_utente = $r_explode[2];
        $data = $r_explode[3];
        $indirizzo = $r_explode[4];
        $citta = $r_explode[5];
        $cap = $r_explode[6];
        $provincia = $r_explode[7];
        $telefono = $r_explode[8];
        $email = $r_explode[9];
        $nome = $r_explode[10];
        $cognome = $r_explode[11];
        $prezzo = $r_explode[12];
        
        $codice = $_POST['codice'];
        $stato = 1;

        $s=$conn->prepare("UPDATE ordini SET stato = ?, tracking = ? WHERE id = ?");
        $s->bind_param("ssi", $stato, $codice, $id_ordine);
        $s->execute();  
        $s->store_result();  

        if($stato == 1){

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
								font-size: 24px;
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
								color: white !important;
								font-size: 2vh;
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
								<h1 class="upper">Gentile '.$nome.' '.$cognome.'</h1>
								<p>
									Grazie per il tuo ordine. Ti informiamo che il tuo ordine è stato spedito.
									La tua data di consegna prevista è indicata in basso.
									Di seguito troverai il codice tracking del tuo ordine.
								</p>
							</div>
							<div id="two-col">
								<h1>Riepilogo ordine</h1>
									<hr>
									<p>ordine n°'.$id_ordine.'</p>
									<p>Effettuato il '.$data.'</p>
									<hr>
							</div>
							<div id="three-col">
								<h1>Codice:</h1>
								<p>'.$codice.'</p>
							</div>
							<div class="column">
								<p style="font-size:1rem;">
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
			$to = $email;
			$subject = 'il tuo ordine è in arrivo';
			$message = $m;
            $from = 'noreply@freestyleconceptstore.it';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";
                 
			$headers .= "From: ".$from."\r\n";

            mail($to, $subject, $message, $headers);
 
 
            $_SESSION['notificaStato'] = 0;
            echo'<script> location.replace("../../pages/admin/ordini"); </script>';
        }
        else {
            $_SESSION['notificaStato'] = 1;
            echo'<script> location.replace("../../pages/admin/ordini"); </script>';
        }


    
    }     

    // elimina like pagina preferiti
    if(isset($_POST['eliminaLike'])){

        $s=$conn->prepare("DELETE FROM likes WHERE id_utente = ? AND prodotto = ?");
        $s->bind_param("ii", $_SESSION['id'], $_POST['prodotto']);
        $s->execute();  
        $s->store_result();  

        $_SESSION['notificaStato'] = 0;
        echo'<script> location.replace("../../pages/utente/preferiti"); </script>';
    }

    //segna come letto notifica singola
    if(isset($_POST['cancellaNotifica'])){

        $link = $_POST['link'];
        $w=$conn->prepare("UPDATE notifiche SET stato = 1 WHERE id = ?");
        $w->bind_param("i",$_POST['id']);
        $w->execute();  

        echo ('<script LANGUAGE=\'JavaScript\'>
                window.location.href = "../../pages/admin/'.$link.'";
                </script>');
    }

    //segna come letto tutte le notifiche
    if(isset($_POST['cancellaNotifica2'])){

        $link = $_POST['link'];
        $w=$conn->prepare("UPDATE notifiche SET stato = 1");
        $w->execute();  

        echo ('<script LANGUAGE=\'JavaScript\'>
                window.location.href = "../../pages/admin/'.$link.'";
                </script>');
    }
    
    //invio codice tramite email
    if(isset($_POST['recuperoPssw1'])){

        //unset variabile modal
        unset($_SESSION['resetPsswd']);

        //escape + var
        $email = htmlspecialchars(strip_tags(strtolower($_POST['email'])));

        //check email
        $s=$conn->prepare("SELECT u.cod_recupero 
                            FROM utente AS u
                            JOIN utente_indirizzo AS ui ON ui.id_utente = u.id
                            WHERE ui.email = ?");
        $s->bind_param('s', $email);
        $s->execute();  
        $s->store_result(); 

        if (mysqli_stmt_num_rows($s) > 0){

            //genera codice
            $cod_recupero = rand (10000,99999);

            //update codice nel db
            $s1=$conn->prepare("UPDATE utente AS u 
                                JOIN utente_indirizzo AS ui 
                                ON ui.id_utente = u.id
                                SET u.cod_recupero = ?
                                WHERE ui.email = ?");
            $s1->bind_param('is', $cod_recupero, $email);
            $s1->execute();

            //invia email
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
                                    font-size: 24px;
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
                                    color: white !important;
                                    font-size: 2vh;
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
                                    <p>
                                        Grazie di usare l\'account freestyleconceptstore.<br>
                                        Inserisci il seguente codice nella apposita sezione per cambiare password.<br>
                                        CODICE:  '.$cod_recupero.'
                                    </p>
                                    <hr>
                                    <p>Se sei stato tu a effettuare la richiesta di reimpostazione  della password, ottimo! Volevamo solo sincerarci che fossi tu.</p>
                                    <p>Se invece NON sei stato tu a effettuare la richiesta di reimpostazione della password, modifica immediatamente la tua password di freestyleconcepstore per garantire la sicurezza dell\'account.</p>
                                    <hr>
                                    <p>Grazie,<br>
                                    Il team di assistenza Freestyleconceptstore</p>
                                </div>
                                <footer>
                                    <p id="contact">
                                        © 2022 Freestyleconceptstore. Tutti i diritti riservati.<br>
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
            $to = $email;
            $subject = 'Richiesta reimpostazione account freestyleconceptstore';
            $message = $m;
            $from = 'noreply@freestyleconceptstore.it';

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1" . "\r\n";
                
            $headers .= "From: ".$from."\r\n";

            mail($to, $subject, $message, $headers);

            $_SESSION['resetPsswd'] = 1;
            echo'<script> location.replace("../../index"); </script>';

        }else{
            //popup
            $_SESSION['resetPsswd'] = 0;
            echo'<script> location.replace("../../index?error"); </script>';
        }

    }

    //check codice
    if(isset($_POST['recuperoPssw2'])){

        //var + escape
        $codice = htmlspecialchars(strip_tags(strtolower($_POST['codice'])));

        //SELECT codice
        $s=$conn->prepare("SELECT u.cod_recupero, ui.email
                            FROM utente AS u
                            JOIN utente_indirizzo AS ui
                            ON u.id = ui.id_utente
                            WHERE u.cod_recupero = ?");
        $s->bind_param('i', $codice);
        $s->execute();        
        $s->store_result();

        if ($s->num_rows > 0){

            $s1=$conn->prepare("SELECT u.cod_recupero, ui.email
                                FROM utente AS u
                                JOIN utente_indirizzo AS ui
                                ON u.id = ui.id_utente
                                WHERE u.cod_recupero = ?");
            $s1->bind_param('i', $codice);
            $s1->execute();  
            $r = $s1->get_result();          

            while($row = $r->fetch_assoc()){
                $_SESSION['email'] = $row['email'];
                $_SESSION['cod_recupero'] = $row['cod_recupero'];
            }

            //unset modal
            unset($_SESSION['resetPsswd']);

            $_SESSION['resetPsswd2'] = 1;
            echo'<script> location.replace("../../index"); </script>';

        }else{
            $_SESSION['resetPsswd2'] = 0;
            echo'<script> location.replace("../../index"); </script>';
        }

    }

    //modifica password
    if(isset($_POST['recuperoPssw3'])){


        $email = htmlspecialchars(strip_tags(strtolower($_SESSION['email'])));
        $cod_recupero = htmlspecialchars(strip_tags($_SESSION['cod_recupero']));
        $pass1 = htmlspecialchars(strip_tags($_POST['pass1']));
        $pass2 = htmlspecialchars(strip_tags($_POST['pass2']));

        if ($pass1 == $pass2) {

            //hash password
            $passh = password_hash($pass1, PASSWORD_DEFAULT);

            //update password
            $s=$conn->prepare("UPDATE utente AS u  
                                JOIN utente_indirizzo AS ui 
                                ON ui.id_utente = u.id
                                SET u.password = ?
                                WHERE u.cod_recupero = ? 
                                AND ui.email = ?");
            $s->bind_param('sis', $passh, $cod_recupero, $email);
            $s->execute();        
            $s->store_result();     
            
            //unset modal
            unset($_SESSION['resetPsswd2']);

            $_SESSION['resetPsswd3'] = 1;
            echo'<script> location.replace("../../index"); </script>';

        }else{

            $_SESSION['resetPsswd3'] = 0;
            echo'<script> location.replace("../../index"); </script>';
        }  

    }

    //annulla inserimento password
    if(isset($_POST['annullaPssw'])){
        unset($_SESSION['resetPsswd']);
        unset($_SESSION['resetPsswd2']);
        echo'<script> location.replace("../../index?richiesta-annullata"); </script>';
    }

    if(isset($_POST['eliminaVariante'])){

        //cancella riga variante
        $s=$conn->prepare("DELETE FROM prodotti_varianti WHERE id = ? ");
        $s->bind_param("i", $_POST['idr']);
        $s->execute();  

        echo'<script> location.replace("../../pages/admin/articoli"); </script>';

    }

    if(isset($_POST['eliminaTot'])){

        //ricevo i dati e uso l'explode id
        $r = $_POST['id'];
        $r_explode = explode('|', $r);
        $id_prodotto = $r_explode[0];
        $id_variante = $r_explode[1];
        $id_foto = $r_explode[2];
        
        //cancello le varianti
        $s=$conn->prepare("DELETE FROM prodotti_varianti WHERE id = ? ");
        $s->bind_param("i", $id_variante);
        $s->execute();  

        //seleziono le foto
        $s=$conn->prepare("SELECT * FROM prodotti_foto AS pf
                            JOIN prodotti AS p ON p.id_prodotto = pf.id_prodotto
                            WHERE pf.id = ?");
        $s->bind_param("i", $id_foto);
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {
            $f = array($row['foto0'],$row['foto1'],$row['foto2'],$row['foto3'],$row['foto4'],
                    $row['foto5'],$row['foto6'],$row['foto7'],$row['foto8'],$row['foto9']);
            $cat = $row['categoria'];
        }

        //cancello le foto dalla cartella
        for ($x=0; $x<10; $x++){
            unlink('../../images/articoli/'.$cat.'/'.$f[$x].'');
        }

        //cancello le foto
        $s=$conn->prepare("DELETE FROM prodotti_foto WHERE id = ? ");
        $s->bind_param("i", $id_foto);
        $s->execute(); 

        //cancello l'articolo
        $s=$conn->prepare("DELETE FROM prodotti WHERE id = ? ");
        $s->bind_param("i", $id_prodotto);
        $s->execute(); 

        echo'<script> location.replace("../../pages/admin/articoli"); </script>';

    }

    if(isset($_POST['eliminaFoto'])){

        $id_foto = $_POST['id'];
        //seleziono le foto
        $s=$conn->prepare("SELECT * FROM prodotti_foto AS pf
                            JOIN prodotti AS p ON p.id_prodotto = pf.id_prodotto
                            WHERE pf.id = ?");
        $s->bind_param("i", $id_foto);
        $s->execute();  
        $r = $s->get_result();

        while ($row = $r->fetch_assoc()) {
            $f = array($row['foto0'],$row['foto1'],$row['foto2'],$row['foto3'],$row['foto4'],
                    $row['foto5'],$row['foto6'],$row['foto7'],$row['foto8'],$row['foto9']);
            $cat = $row['categoria'];
        }

        //cancello le foto dalla cartella
        for ($x=0; $x<10; $x++){
            unlink('../../images/articoli/'.$cat.'/'.$f[$x].'');
        }

        //cancello le foto
        $s=$conn->prepare("DELETE FROM prodotti_foto WHERE id = ? ");
        $s->bind_param("i", $id_foto);
        $s->execute(); 

        echo'<script> location.replace("../../pages/admin/articoli"); </script>';
    }

    if(isset($_POST['acquistoVeloce'])){

        if( !empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['email']) && !empty($_POST['indirizzo']) &&
        !empty($_POST['cap']) && !empty($_POST['citta']) && !empty($_POST['provincia']) && !empty($_POST['telefono'])){

            $_SESSION['nome'] = strtolower(strip_tags($_POST['nome']));
            $_SESSION['cognome'] = strtolower(strip_tags($_POST['cognome']));
            $_SESSION['email'] = strtolower(strip_tags($_POST['email']));
            $_SESSION['indirizzo'] = strtolower(strip_tags($_POST['indirizzo']));
            $_SESSION['cap'] = strtolower(strip_tags($_POST['cap']));
            $_SESSION['citta'] = strtolower(strip_tags($_POST['citta']));
            $_SESSION['provincia'] = strtolower(strip_tags($_POST['provincia']));
            $_SESSION['telefono'] = strtolower(strip_tags($_POST['telefono']));

            $_SESSION['avx'] = 1;

            echo'<script> location.replace("../../pages/carrello/checkout"); </script>';

        }else{
            echo'<script> location.replace("../../pages/carrello/acquisto-veloce"); </script>';
        }

    }
?>