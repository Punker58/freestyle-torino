<?php 
  include '../../config/server/action.php';
  include '../../config/link/function.php';
  
  if( $_SESSION['ruolo'] != 10) {header('Location: ../../');}
?>


<?php

    $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione,  p.categoria,
                        pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5,
                        pv.id, pv.quantita, p._like, p.in_sconto,
                        c.n_colore,
                        t.n_taglia,
                        ca.n_categoria
                        FROM prodotti as p
                        JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
                        JOIN prodotti_varianti  as pv ON pv.id_prodotto =  p.id_prodotto
                        JOIN colore as c ON c.id = pv.id_colore
                        JOIN taglia as t ON t.id = pv.id_taglia
                        JOIN categoria as ca ON ca.id = p.categoria
                        WHERE nome LIKE '%".$_POST['nome']."%'
                        ORDER BY nome ASC");
    $s->execute();  
    $r = $s->get_result(); 

    if(mysqli_num_rows($r)>0){

        echo '<select class="form-select form-select-lg mb-3"  name="id" required="required">';

        while ($row = $r->fetch_assoc()) {

            $id = $row['id'];
            $nome = $row['nome'];
            $categoria = $row['categoria'];
            $colore = $row['n_colore'];
            $taglia = $row['n_taglia'];

            echo 
                '
                    <option value="'.$id.'|'.$categoria.'">'.$nome.' ('.$colore.') ('.$taglia.')</option>
                    
                ';

                }

            echo' </select>';
    }
    else 
    {
        echo '
            <select class=" form-select form-select-lg mb-3" aria-label="disabled" id="sUtente" disabled>
                <option>Nessun risultato</option>
                <label for="sutente">CERCA ARTICOLO</label>
            </select>       
        ';
    }

?>