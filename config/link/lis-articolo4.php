<?php 
  include '../../config/server/action.php';
  include '../../config/link/function.php';
  
  if( $_SESSION['ruolo'] != 10) {header('Location: ../../');}
?>


<?php

    $tot = $_POST['slot'];

        echo '<hr><br><br>';

        for($x=0; $x<$tot; $x++){
            
    ?>   
            <!-- TAGLIA -->
            <div class="form-floating mb-3">

                <select class="form-select" aria-label="Default select example" id="floatingTaglia" name="taglia<?php echo $x; ?>" placeholder="TAGLIA">

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

            <!-- QUANTITA -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingQuan" name="quantita<?php echo $x; ?>" placeholder="QUANTITÀ">
                <label for="floatingQuan">QUANTITÀ</label>
            </div>            
    <?php    
      
        }

?>