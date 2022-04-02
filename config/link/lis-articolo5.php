<?php 
  include '../../config/server/action.php';
  include '../../config/link/function.php';
  
  if( $_SESSION['ruolo'] != 10) {header('Location: ../../');}
?>


<?php

    $s=$conn->prepare("SELECT p.id_prodotto, p.nome, p.prezzo, p.descrizione,  p.categoria,
                        pf.id, pf.foto1, pf.foto2, pf.foto3, pf.foto4, pf.foto5
                        FROM prodotti as p
                        JOIN prodotti_foto  as pf ON pf.id_prodotto =  p.id_prodotto
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

            echo 
                '
                    <option value="'.$id.'">'.$nome.'</option>             
                ';

                }

            echo' </select>';
            echo '<input type="hidden" name="categoria" value="'.$categoria.'">';
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