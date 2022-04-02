<?php 
    include '../../config/server/action.php';
    include '../../config/link/function.php';
    cookieAdmin2();
?>

<!doctype html>
<html lang="it" class="h-100">
  <head>

    <?php 
        //funzioni invocate
        metaTags();
        linkCssAdmin();
        linkJs();
        favicon2();
    ?>
    <title>Login | Dashboard</title>
  </head>

  <body class="bg58">

    <div class="d-flex">
      
        <div class="container mt-5 pt-5">

          <div class="row">
            
            <div class="col-12 col-sm-8 col-md-6 m-auto bg-58">

              <div class="card border-0 shadow">

                <div class="card-body text-center">

                  <img src="../../images/logo/freestyle2.png" height="200rem" width="300rem" alt="">

                  <form method="post" class="needs-validation" novalidate>

                    <div class="form-floating">
                        <input type="text" class="form-control mt-3 mb-3 " id="user" name="username" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                        <label for="user" class="form-label">Username</label>
                        <div class="invalid-feedback">
                            Inserire l'username
                        </div>

                    </div>

                    <div class="form-floating">
                        <input type="password" class="form-control mt-3 mb-3" id="pass" name="password" size="100" onKeyDown="if(this.value.length==100 && event.keyCode!=8) return false;" required>
                        <label for="pass">Password</label>
                        <div class="invalid-feedback">
                            Inserire la password
                        </div>
                    </div>

                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="submit" name="login-admin" class="btn btn-lg btn-dark mt-3 mb-3">ENTRA</button>
                    </div> 

                  </form>  

                </div>

              </div>  

            </div>

          </div>

        </div>

      </div>

  <!-- Validation form-->
  <script>
    (function () {
      'use strict'
    
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')
    
      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
    
            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>

  </body>
</html>