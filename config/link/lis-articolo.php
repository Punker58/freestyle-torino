<?php 
  include '../../config/server/action.php';
  include '../../config/link/function.php';
  
  if( $_SESSION['ruolo'] != 10) {header('Location: ../../');}
?>


<?php

    $s=$conn->prepare("SELECT *
                        FROM prodotti
                        WHERE nome LIKE '%".$_POST['nome']."%'
                        ORDER BY nome ASC");
    $s->execute();  
    $r = $s->get_result(); 

    if(mysqli_num_rows($r)>0){

        echo '<select class="form-select form-select-lg mb-3"  name="id" required="required">';

        while ($row = $r->fetch_assoc()) {

            $id = $row['id_prodotto'];
            $nome = $row['nome'];
            $categoria = $row['categoria'];

            echo 
                '
                <option value="'.$id.'|'.$categoria.'">'.$nome.'</option>
                    
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