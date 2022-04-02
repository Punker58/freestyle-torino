<?php

    include '../../config/link/function.php';
    include '../../config/server/action.php';

    $s=$conn->prepare("SELECT o.id, o.id_utente, o.prodotti, o.data_pagamento, o.prezzo_totale, o.stato,
                            u.nome, u.cognome,
                            ui.indirizzo, ui.citta, ui.cap, ui.nome_campanello, ui.telefono, ui.email,
                            p.nome_province
                        FROM ordini AS o
                        JOIN utente AS u ON u.id = o.id_utente
                        JOIN utente_indirizzo AS ui ON ui.id_utente = o.id_utente 
                        JOIN province AS p ON p.id_province = ui.provincia
                        WHERE o.id = ?");		
    $s->bind_param("i", $_POST['id']);                    
    $s->execute();  
    $r = $s->get_result();

    while ($row = $r->fetch_assoc()) {

        $id = $row['id'];
        $utente = $row['id_utente'];
        $prodotti = $row['prodotti'];
        $data = $row['data_pagamento'];
        $prezzo = $row['prezzo_totale'];
        $indirizzo = $row['indirizzo'];
        $citta = $row['citta'];
        $cap = $row['cap'];
        $provincia = $row['nome_province'];
        $campanello = $row['nome_campanello'];
        $telefono = $row['telefono'];
        $email = $row['email'];
        $nome = $row['nome'];
        $cognome = $row['cognome'];

    }


    echo '
    
        <div class="container">

            <div class="row justify-content-center bg-light">
                    
                <div class="col-12 mt-3">

                    <div class="col-12">
                        <h2>FreestyleConceptStore</h2>
                        <span style="font-size:1.5vh;">Via Giuseppe Giacosa 2,</span><br>
                        <span style="font-size:1.5vh;">Nichelino - Torino (10042)</span><br>
                        <span style="font-size:1.5vh;">3926674386</span><br>
                        <span style="font-size:1.5vh;">P.iva 12572410012</span><br>
                    </div>  

                </div>

                <div class="col-12 mt-5">

                    <div class="col-12">
                        <p class="fw-bold">Indirizzo di spedizione:</p>
                        <p style="font-size:1.5vh;" class="text-capitalize"><span class="fw-bold">Nome/Cognome:</span> '.$nome.' '.$cognome.'</p>
                        <p style="font-size:1.5vh;" class="text-capitalize"><span class="fw-bold">Indirizzo:<br></span> '.$indirizzo.',<br> '.$citta.' - '.$provincia.' ('.$cap.')</p>
                        <p style="font-size:1.5vh;"><span class="fw-bold">N.Telefono:</span> '.$telefono.'</p>
                        <p style="font-size:1.5vh;" class="mb-3"><span class="fw-bold">Email:</span> '.$email.'</p>
                    </div>                                        

                </div>      

            </div>

    </div>    

    ';

?>