<?php 
  // css admin
  function linkCssAdmin() {
      echo 
          '<!-- Bootstrap CSS -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <!-- FontAwesome-->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />            
          <link rel="stylesheet" href="../../styles/css/admin.css">
          <link rel="icon" type="image/x-icon" href="../../favicon.ico">
          ';
  }

  // sidebar admin livello 2
  function sidebarAdmin2() {
    $conn = db();
    $w=$conn->prepare("SELECT n.id, n.id_ordine, n.testo, n.stato,
                              t.id_testo, t.testo
                        FROM notifiche AS n
                        JOIN testo AS t ON t.id_testo = n.testo
                        WHERE stato = 0");
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  

      echo '
          <!-- Sidebar -->
              <div class="bg-white" id="sidebar-wrapper">
                  <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">Freestyle <a href="" id="not" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-success"><i class="fas fa-bell">('.$sa.')</a></i></div>
                  <div class="list-group list-group-flush my-3">
                      <a href="dashboard" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                              class="fas fa-home me-2"></i>Dashboard</a>
                      <a href="articoli" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-tshirt me-2"></i>Articoli</a>                                
                      <a href="ordini" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-truck me-2"></i>Ordini</a>
                      <a href="extra" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="far fa-file me-2"></i>Extra</a>                                
                      <a href="lista-utenti" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-user me-2"></i>Utente</a>
                      <a href="esci" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                              class="fas fa-power-off me-2"></i>Esci</a>
                  </div>
              </div>
          <!-- /#sidebar-wrapper -->
      ';
  }

  // sidebar articoli livello 2
  function sidebarAdminArticoli2() {
    $conn = db();
    $w=$conn->prepare("SELECT n.id, n.id_ordine, n.testo, n.stato,
                              t.id_testo, t.testo
                        FROM notifiche AS n
                        JOIN testo AS t ON t.id_testo = n.testo
                        WHERE stato = 0");
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  

      echo '
          <!-- Sidebar -->
              <div class="bg-white" id="sidebar-wrapper">
                  <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">Freestyle <a href="" id="not" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-success"><i class="fas fa-bell">('.$sa.')</a></i></div>
                  <div class="list-group list-group-flush my-3">
                      <a href="dashboard" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-home me-2"></i>Dashboard</a>
                      <a href="articoli" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                              class="fas fa-tshirt me-2"></i>Articoli</a>                                
                      <a href="ordini" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-truck me-2"></i>Ordini</a>
                      <a href="extra" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="far fa-file me-2"></i>Extra</a>                                
                      <a href="lista-utenti" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-user me-2"></i>Utente</a>
                      <a href="esci" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                              class="fas fa-power-off me-2"></i>Esci</a>
                  </div>
              </div>
          <!-- /#sidebar-wrapper -->
      ';
  }
    
  // sidebar ordini livello 2
  function sidebarAdminOrdini2() {
    $conn = db();
    $w=$conn->prepare("SELECT n.id, n.id_ordine, n.testo, n.stato,
                              t.id_testo, t.testo
                        FROM notifiche AS n
                        JOIN testo AS t ON t.id_testo = n.testo
                        WHERE stato = 0");
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  

      echo '
          <!-- Sidebar -->
              <div class="bg-white" id="sidebar-wrapper">
                  <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">Freestyle <a href="" id="not" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-success"><i class="fas fa-bell">('.$sa.')</a></i></div>
                  <div class="list-group list-group-flush my-3">
                      <a href="dashboard" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-home me-2"></i>Dashboard</a>
                      <a href="articoli" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-tshirt me-2"></i>Articoli</a>                                
                      <a href="ordini" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                              class="fas fa-truck me-2"></i>Ordini</a>
                      <a href="extra" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="far fa-file me-2"></i>Extra</a>                                
                      <a href="lista-utenti" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-user me-2"></i>Utente</a>
                      <a href="esci" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                              class="fas fa-power-off me-2"></i>Esci</a>
                  </div>
              </div>
          <!-- /#sidebar-wrapper -->
      ';
  }   
    
  // sidebar extra livello 2
  function sidebarAdminExtra2() {
    $conn = db();
    $w=$conn->prepare("SELECT n.id, n.id_ordine, n.testo, n.stato,
                              t.id_testo, t.testo
                        FROM notifiche AS n
                        JOIN testo AS t ON t.id_testo = n.testo
                        WHERE stato = 0");
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  

      echo '
          <!-- Sidebar -->
              <div class="bg-white" id="sidebar-wrapper">
                  <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">Freestyle <a href="" id="not" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-success"><i class="fas fa-bell">('.$sa.')</a></i></div>
                  <div class="list-group list-group-flush my-3">
                      <a href="dashboard" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-home me-2"></i>Dashboard</a>
                      <a href="articoli" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-tshirt me-2"></i>Articoli</a>                                
                      <a href="ordini" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-truck me-2"></i>Ordini</a>
                      <a href="extra" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                              class="far fa-file me-2"></i>Extra</a>                                
                      <a href="lista-utenti" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-user me-2"></i>Utente</a>
                      <a href="esci" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                              class="fas fa-power-off me-2"></i>Esci</a>
                  </div>
              </div>
          <!-- /#sidebar-wrapper -->
      ';
  }  

  // sidebar utente livello 2
  function sidebarAdminUtente2() {
    $conn = db();
    $w=$conn->prepare("SELECT n.id, n.id_ordine, n.testo, n.stato,
                              t.id_testo, t.testo
                        FROM notifiche AS n
                        JOIN testo AS t ON t.id_testo = n.testo
                        WHERE stato = 0");
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  

      echo '
          <!-- Sidebar -->
              <div class="bg-white" id="sidebar-wrapper">
                  <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">Freestyle <a href="" id="not" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-success"><i class="fas fa-bell">('.$sa.')</a></i></div>
                  <div class="list-group list-group-flush my-3">
                      <a href="dashboard" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-home me-2"></i>Dashboard</a>
                      <a href="articoli" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-tshirt me-2"></i>Articoli</a>                                
                      <a href="ordini" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="fas fa-truck me-2"></i>Ordini</a>
                      <a href="extra" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                              class="far fa-file me-2"></i>Extra</a>                                
                      <a href="lista-utenti" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                              class="fas fa-user me-2"></i>Utente</a>
                      <a href="esci" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                              class="fas fa-power-off me-2"></i>Esci</a>
                  </div>
              </div>
          <!-- /#sidebar-wrapper -->
      ';
  } 

  //page content admin
  function pageContent() {
      echo '
          <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
              <div class="d-flex align-items-center">
                  <i class="fas fa-align-left text-light fs-4 me-3 " id="menu-toggle"></i>
                  <h2 class="fs-2 m-0 text-light">Dashboard</h2>
              </div>

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                              role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-user me-2"></i>John Doe
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <li><a class="dropdown-item" href="#">Profile</a></li>
                              <li><a class="dropdown-item" href="#">Settings</a></li>
                              <li><a class="dropdown-item" href="#">Logout</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </nav>    
      ';
  }

  // Cookie accesso admin login
  function cookieAdmin() {

      $conn = db();
      if(isset($_COOKIE['access_admin'])){
          $_SESSION['access_admin'] = $_COOKIE['access_admin'];
  
          $s=$conn->prepare("SELECT id, ruolo  FROM admin WHERE cod_login = ?");		
          $s->bind_param("s", $_SESSION['access_admin']);
          $s->execute();  
          $s->store_result();

          if ($s->num_rows > 0) {
              $s->bind_result($id, $r);
              $s->fetch();

              $_SESSION['id'] = $id;
              $_SESSION['ruolo'] = $r;
              
              }else{
                $_SESSION['access_admin'] = null;
              }
          }

  }

  // Cookie accesso admin
  function cookieAdmin2() {

      $conn = db();
      if(isset($_COOKIE['access_admin'])){
          $_SESSION['access_admin'] = $_COOKIE['access_admin'];
  
          $s=$conn->prepare("SELECT id, ruolo  FROM admin WHERE cod_login = ?");		
          $s->bind_param("s", $_SESSION['access_admin']);
          $s->execute();  
          $s->store_result();

          if ($s->num_rows > 0) {
              $s->bind_result($id, $r);
              $s->fetch();

              $_SESSION['id'] = $id;
              $_SESSION['ruolo'] = $r;

              echo '<script> location.replace("dashboard"); </script>';
              
              }else{
                  $_SESSION['access_admin'] = null;
              }
          }

  }

  // Cookie accesso utente
  function cookieUtente() {

      $conn = db();
      if(isset($_COOKIE['access'])){
          $_SESSION['access'] = $_COOKIE['access'];
  
          $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello, 
                              ui.indirizzo, ui.citta, ui.cap, ui.nome_campanello, ui.telefono, ui.email,
                              p.nome_province
                              FROM utente as u
                              JOIN utente_indirizzo as ui ON ui.id_utente = u.id
                              JOIN province as p ON p.id_province = ui.provincia
                              WHERE cod_cookie = ? ");		
          $s->bind_param("s", $_SESSION['access']);
          $s->execute();  
          $s->store_result();

          if ($s->num_rows > 0) {
              $s->bind_result($id, $nome, $cognome, $cookie, $carrello,
                              $indirizzo, $citta, $cap, $campanello, $telefono, $email, $nome_province);
              $s->fetch();
    
              $_SESSION['id'] = $id;
              $_SESSION['nome'] = $nome;
              $_SESSION['cognome'] = $cognome;
              $_SESSION['access'] = $cookie;
              $_SESSION['cod_carrello'] = $carrello;
              $_SESSION['indirizzo'] = $indirizzo;
              $_SESSION['citta'] = $citta;
              $_SESSION['cap'] = $cap;
              $_SESSION['provincia'] = $nome_province;
              $_SESSION['campanello'] = $campanello;
              $_SESSION['telefono'] = $telefono;
              $_SESSION['email'] = $email;
              
              unset($_SESSION['avx']);
              
              }else{
                  unset($_SESSION['id']);
                  unset($_SESSION['nome']);
                  unset($_SESSION['cognome']);
                  unset($_SESSION['access']);
                  unset($_SESSION['cod_carrello']);
                  unset($_SESSION['indirizzo']);
                  unset($_SESSION['citta']);
                  unset($_SESSION['cap']);
                  unset($_SESSION['provincia']);
                  unset($_SESSION['campanello']);
                  unset($_SESSION['telefono']);
                  unset($_SESSION['email']);
              }
      }

  }

  // carrello
  function carrello(){

    if(isset($_COOKIE['access'])){

      $conn = db();
  
      $s=$conn->prepare("SELECT u.id, u.nome, u.cognome, u.cod_cookie, u.cod_carrello, u.cod_recupero,
                                ui.indirizzo, ui.citta, ui.cap, ui.provincia, ui.nome_campanello, ui.telefono, ui.email
                        FROM utente as u
                        JOIN utente_indirizzo as ui ON ui.id_utente =  u.id
                        WHERE u.cod_cookie = ?");		
      $s->bind_param("s", $_COOKIE['access']);
      $s->execute();  
      $s->store_result();

      if ($s->num_rows > 0) {

        $s->bind_result($id, $nome, $cognome, $cod_cookie, $cod_carrello, $cod_recupero,
                        $indirizzo, $citta, $cap, $provincia, $campanello, $telefono, $email);
        $s->fetch();

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
          $_SESSION['provincia'] = $provincia;
          $_SESSION['telefono'] = $telefono;
          $_SESSION['email'] = $email;

      }

    }elseif(isset($_COOKIE['cod_carrello'])){
      $_SESSION['cod_carrello'] = $_COOKIE['cod_carrello'];

    }else{
      
      $cod_carrello = rand();
      $_SESSION['cod_carrello'] = $cod_carrello;
      echo '
        <script> 
                document.cookie = "cod_carrello='.$_SESSION['cod_carrello'].'; max-age=31536000";
        </script>';

    }  

  }

  // elimina carrello inusato
  /*function eliminaCarrelloInusato(){

    $conn = db();
    $w=$conn->prepare("SELECT c.id, c.id_utente FROM carrello AS c");
    $w->execute();  
    $r = $w->get_result();

    while ($row = $r->fetch_assoc()) {

      $id = $row['id'];
      $id_utente = $row['id_utente'];

      $w1=$conn->prepare("SELECT u.cod_carrello 
                          FROM utente AS u
                          WHERE u.cod_carrello = ?");
      $w1->bind_param("i", $id_utente);
      $w1->execute();
      $r1 = $w1->get_result();

      if ($r1->num_rows == 0) {

        $w2=$conn->prepare("DELETE FROM carrello 
                            WHERE id = ?");
        $w2->bind_param("i", $id);
        $w2->execute();

      }

    }

  }*/

  //SEO tags
  function seoTags () {
      echo '
          <meta name="description" content="Un\'accurata selezione di abbigliamento streetwear.">
          <meta name="keywords" content="streetwear,freestyle,chivasso,torino,abbigliamento,italia,torino,new collection,moda italiana,manstyle,menswear,shop">
          <meta name="robots" content="index, follow"> 
      ';
  }

  //meta tags
  function metaTags() {
      echo '
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0" />
          <meta http-equiv="Cache-Control" content="no-cache" />
          <meta http-equiv="Pragma" content="no-cache" />
          <meta http-equiv="Expires" content="0" />
          ';
          unset($_SESSION['complessivo1']);
          unset($_SESSION['complessivo2']);
          
        //elimino lo sconto
        $conn = db();
        $z=null;
        $w=$conn->prepare("UPDATE carrello SET prezzo_sconto = ? 
                          WHERE id_utente = ?");	
        $w->bind_param("is", $z, $_SESSION['cod_carrello']);
        $w->execute();  
        $w->store_result();      

  }

  //meta tags
  function metaTagsY() {
      echo '
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0" />
          <meta http-equiv="Cache-Control" content="no-cache" />
          <meta http-equiv="Pragma" content="no-cache" />
          <meta http-equiv="Expires" content="0" />
          ';
          unset($_SESSION['complessivo1']);
          unset($_SESSION['complessivo2']);
  }

  // css
  function linkCss() {
      echo '
          <!-- FONT -->
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Anton&family=Quintessential&display=swap" rel="stylesheet">

          <!-- Bootstrap CSS -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          
          <!-- FontAwesome-->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          <link rel="stylesheet" href="styles/css/main.css">
          
          ';
  }

  // css livello 2
  function linkCss2() {
      echo 
          '
          <!-- FONT -->
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Anton&family=Quintessential&display=swap" rel="stylesheet">

          <!-- Bootstrap CSS -->
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <!-- FontAwesome-->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <link rel="stylesheet" href="../../styles/css/main.css">
          
          ';
  }

  function modalLogin(){

    echo '
    
        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content bg-black border border-warning">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="row">

                <form action="config/server/action" method="post">

                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                    <label for="email">Email</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                    <label for="password">Password</label>
                  </div>

                  <div class="mb-3 col-12">
                    <div class="col-sm-4">
                      <button type="submit" name="accediUtente" class="btn btn-success">ACCEDI</button>
                    </div>
                  </div>

                </form>

                </div>
              </div>

              <div class="modal-footer text-center">
                <p>password dimenticata?</p>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal3">RECUPERA</button>
              </div>

              <div class="modal-footer text-center">
                <p>Non sei ancora registrato?</p>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal2">REGISTRATI</button>
              </div>
              
            </div>
          </div>
        </div>    
    ';
  }

  function modalLogin2(){

    echo '
    
        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content bg-black border border-warning">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="row">

                <form action="../../config/server/action" method="post">

                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                    <label for="email">Email</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                    <label for="password">Password</label>
                  </div>

                  <div class="mb-3 col-12">
                    <div class="col-sm-10">
                      <button type="submit" name="accediUtente" class="btn btn-success">ACCEDI</button>
                    </div>
                  </div>

                </form>

                </div>
              </div>

              <div class="modal-footer text-center">
                <p>password dimenticata?</p>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal3">RECUPERA</button>
              </div>

              <div class="modal-footer text-center">
                <p>Non sei ancora registrato?</p>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal2">REGISTRATI</button>
              </div>

            </div>
          </div>
        </div>    
    ';
  }

  function modalRegistrazione(){
    $conn = db();
    echo '
          <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-black border border-warning">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Registazione</h5>
                  <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="row">

                  <form action="config/server/action" method="post">

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnome" name="nome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="floatingnome">Nome *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="cognome" name="cognome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="cognome">Cognome *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                        <label for="email">Email *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="password">Password (MAX 30 Caratteri) *</label>
                      </div>

                      <hr>
                      <h1>INDIRIZZO DI SPEDIZIONE</h1>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="campanello" name="campanello" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;">
                        <label for="campanello">Nome campanello</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                        <label for="indirizzo">Indirizzo (ES. Via Italia 18) *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="citta" name="citta" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="citta">Città *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="cap" name="cap" placeholder="name@example.com" size="5" onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;" required>
                        <label for="cap">Cap *</label>
                      </div>

                      <div class="form-floating mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                      <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="provincia" required>
                        <option selected="" disabled hidden></option>
                  ';
                      
  
                        $w=$conn->prepare("SELECT id_province, nome_province, sigla_province FROM province");
                        $w->execute();  
                        $r = $w->get_result();
  
                        while ($row = $r->fetch_assoc()) {
                          echo '<option value="'.$row['id_province'].'">'.$row['nome_province'].' ('.$row['sigla_province'].')</option>';
                        }
  
              
                      
                echo'
                      </select>
                      <label for="floatingSelect">Provincia *</label>
                    </div> 

                      <div class="form-floating mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="name@example.com" size="10" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" required>
                        <label for="telefono">Telefono *</label>
                      </div>

                      <div class="form-floating mb-3">
                      <button type="submit" class="btn btn-success" name="registraUtente">Registra</button>
                      </div>

                    </form>

                  </div>
                </div>

                <div class="modal-footer text-center">
                  <p>Hai già un account?</p>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal1">Accedi</button>
                </div>

              </div>
            </div>
          </div>    
    ';
  }

  function modalRegistrazione2(){
    $conn = db();
    echo '
          <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-black border border-warning">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Registazione</h5>
                  <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="row">

                  <form action="../../config/server/action" method="post">

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingnome" name="nome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="floatingnome">Nome *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="cognome" name="cognome" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="cognome">Cognome *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                        <label for="email">Email *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="password">Password (MAX 30 Caratteri) *</label>
                      </div>

                      <hr>
                      <h1>INDIRIZZO DI SPEDIZIONE</h1>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="campanello" name="campanello" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;">
                        <label for="campanello">Nome campanello</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="name@example.com" size="60" onKeyDown="if(this.value.length==60 && event.keyCode!=8) return false;" required>
                        <label for="indirizzo">Indirizzo (ES. Via Italia 18) *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="citta" name="citta" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                        <label for="citta">Città *</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="cap" name="cap" placeholder="name@example.com" size="5" onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;" required>
                        <label for="cap">Cap *</label>
                      </div>

                      <div class="form-floating mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                      <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="provincia" required>
                        <option selected="" disabled hidden></option>
                  ';
                      
  
                        $w=$conn->prepare("SELECT id_province, nome_province, sigla_province FROM province");
                        $w->execute();  
                        $r = $w->get_result();
  
                        while ($row = $r->fetch_assoc()) {
                          echo '<option value="'.$row['id_province'].'">'.$row['nome_province'].' ('.$row['sigla_province'].')</option>';
                        }
  
              
                      
                echo'
                      </select>
                      <label for="floatingSelect">Provincia *</label>
                    </div> 

                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="name@example.com" size="10" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;" required>
                        <label for="telefono">Telefono *</label>
                      </div>

                      <div class="form-floating mb-3">
                      <button type="submit" class="btn btn-success" name="registraUtente">Registra</button>
                      </div>

                    </form>

                  </div>
                </div>

                <div class="modal-footer text-center">
                  <p>Hai già un account?</p>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal1">Accedi</button>
                </div>

              </div>
            </div>
          </div>    
    ';
  }

  function recuperopssw(){
    echo '
          <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-black border border-warning">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                  <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="row">

                    <form action="config/server/action" method="post">

                        <div class="form-floating mb-3">
                          <input type="email" class="form-control" id="emailr" name="email" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                          <label for="emailr">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                          <button type="submit" class="btn btn-success" name="recuperoPssw1">INVIA CODICE</button>
                        </div>
                    </form>

                  </div>
                </div>

                <div class="modal-footer text-center">
                  <p>Hai già un account?</p>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal1">Accedi</button>
                </div>

              </div>
            </div>
          </div>

        ';

        if(isset($_SESSION['resetPsswd']) && $_SESSION['resetPsswd'] == 1) {
          
          echo "
              <script>
                $(document).ready(function(){
                  $('#modal4').modal('show');
                })
              </script> 
                ";

          echo '    

              <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="modal-dialog">
                  <div class="modal-content bg-black border border-warning">

                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                      <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row">          

                        <form action="config/server/action" method="post">

                            <p>abbiamo inviato un codice di recupero alla tua email</p>
                            <div class="form-floating mb-3"> 
                              <input type="number" class="form-control" id="codice" name="codice" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                              <label for="codice">Codice</label>
                            </div>

                            <div class="form-floating mb-3">
                              <button type="submit" class="btn btn-success" id="codice2" name="recuperoPssw2">INVIA</button>
                            </div>

                          </form>

                        <form action="config/server/action" method="post">
                         
                          <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-danger" name="annullaPssw">ANNULLA</button>
                          </div>

                        </form>  

                      </div>
                    </div>

                  </div>
                </div>
              </div>    
              ';
      }

      if(isset($_SESSION['resetPsswd2']) && $_SESSION['resetPsswd2'] == 1) {
          
        echo "
            <script>
              $(document).ready(function(){
                $('#modal5').modal('show');
              })
            </script> 
              ";

        echo '    

            <div class="modal fade" id="modal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
              <div class="modal-dialog">
                <div class="modal-content bg-black border border-warning">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                    <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <div class="row">          

                      <form action="config/server/action" method="post">

                          <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="codice" name="pass1" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                            <label for="codice">Inserisci la password</label>
                          </div>

                          <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="codice2" name="pass2" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                          <label for="codice2">Conferma la password</label>
                        </div>

                          <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-success" id="codice2" name="recuperoPssw3">INVIA</button>
                          </div>

                      </form>

                      <form action="config/server/action" method="post">
                         
                        <div class="form-floating mb-3">
                          <button type="submit" class="btn btn-danger" name="annullaPssw">ANNULLA</button>
                        </div>

                      </form>  

                    </div>
                  </div>

                </div>
              </div>
            </div>    
            ';
    }      
  }

  function recuperopssw2(){
    echo '
          <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-black border border-warning">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                  <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="row">

                    <form action="../../config/server/action" method="post">

                        <div class="form-floating mb-3">
                          <input type="email" class="form-control" id="emailr" name="email" placeholder="name@example.com" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                          <label for="emailr">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                          <button type="submit" class="btn btn-success" name="recuperoPssw1">INVIA CODICE</button>
                        </div>
                    </form>

                  </div>
                </div>

                <div class="modal-footer text-center">
                  <p>Hai già un account?</p>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modal1">Accedi</button>
                </div>

              </div>
            </div>
          </div>

        ';

        if(isset($_SESSION['resetPsswd']) && $_SESSION['resetPsswd'] == 1) {
          
          echo "
              <script>
                $(document).ready(function(){
                  $('#modal4').modal('show');
                })
              </script> 
                ";

          echo '    

              <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="modal-dialog">
                  <div class="modal-content bg-black border border-warning">

                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                      <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row">          

                        <form action="../../config/server/action" method="post">

                            <p>abbiamo inviato un codice di recupero alla tua email</p>
                            <div class="form-floating mb-3"> 
                              <input type="number" class="form-control" id="codice" name="codice" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                              <label for="codice">Codice</label>
                            </div>

                            <div class="form-floating mb-3">
                              <button type="submit" class="btn btn-success" id="codice2" name="recuperoPssw2">INVIA</button>
                            </div>

                          </form>

                        <form action="config/server/action" method="post">
                         
                          <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-danger" name="annullaPssw">ANNULLA</button>
                          </div>

                        </form>  

                      </div>
                    </div>

                  </div>
                </div>
              </div>    
              ';
      }

      if(isset($_SESSION['resetPsswd2']) && $_SESSION['resetPsswd2'] == 1) {
          
        echo "
            <script>
              $(document).ready(function(){
                $('#modal5').modal('show');
              })
            </script> 
              ";

        echo '    

            <div class="modal fade" id="modal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
              <div class="modal-dialog">
                <div class="modal-content bg-black border border-warning">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recupera password</h5>
                    <button type="button" class="btn-close btn-success" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    <div class="row">          

                      <form action="../../config/server/action" method="post">

                          <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="codice" name="pass1" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                            <label for="codice">Inserisci la password</label>
                          </div>

                          <div class="form-floating mb-3">
                          <input type="password" class="form-control" id="codice2" name="pass2" placeholder="text" size="30" onKeyDown="if(this.value.length==30 && event.keyCode!=8) return false;" required>
                          <label for="codice2">Conferma la password</label>
                        </div>

                          <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-success" id="codice2" name="recuperoPssw3">INVIA</button>
                          </div>

                      </form>

                      <form action="../../config/server/action" method="post">
                         
                        <div class="form-floating mb-3">
                          <button type="submit" class="btn btn-danger" name="annullaPssw">ANNULLA</button>
                        </div>

                      </form>  

                    </div>
                  </div>

                </div>
              </div>
            </div>    
            ';
    }      
  }

  // logo sito
  function freestyleLogoIndex() {
    echo '
           <!-- LOGO -->
           <section>
             <div class="text-center">
               <img class="img-fluid logo" src="images/logo/freestyle2.png" alt="freestyle">
             </div>
           </section> 
         '; 
  }

  //logo sito livello 2
  function freestyleLogo2() {
   echo '
          <!-- LOGO -->
          <section>
            <div class="text-center">
              <img class="img-fluid logo" src="../../images/logo/freestyle2.png" alt="">
            </div>
          </section> 
        '; 
  }

  //navbar index
  function navbarIndex() {
    $conn = db();
    $w=$conn->prepare("SELECT id FROM carrello
        WHERE id_utente = ?");
    $w->bind_param('s', $_SESSION['cod_carrello']);		
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;

    echo '
    <section>
    <div class="container-fluid bg-black">

      <nav class="navbar navbar-expand-lg navbar-light bg-black nav58">
          <div class="container-fluid">
            <div class="col"></div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                  <div class="dropdown">
                    <a class="nav-link  my-5 ms-5 dropdown-toggle " role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                    
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
            ';

                        $a="SI";
                        $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                        $s->bind_param("s", $a);
                        $s->execute();  
                        $r = $s->get_result(); 

                        echo '
                              <li><a class="dropdown-item d-flex" href="pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                            ';
                
                        while ($row = $r->fetch_assoc()) {
                
                            $id = $row['id'];
                            $nome = $row['n_categoria'];
                            $attiva = $row['attiva'];
                
                            echo '
                                  <li><a class="dropdown-item d-flex" href="pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                            ';
                        }
                                   
            echo '          
                    </ul>
                  </div>

                </li>

                <li class="nav-item">
                  <a class="nav-link attivo my-5 ms-5" aria-current="page" href="index">home</a>
                </li>

                <li class="nav-item">
                ';

                    if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                      {
                        echo '
                              <li class="nav-item">
                                <div class="dropdown">
                                  <a class="nav-link  my-5 ms-5 dropdown-toggle " role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  
                                  <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="config/server/logout">esci</a></li>
                                  </ul>
                                </div>
                              </li>
                              ';
                      }
                    else 
                      {
                        echo '<a class="nav-link  my-5 ms-5" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                      }  
             
            echo '
                </li>
              </ul>

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 ico58">
                <li class="nav-item">
                  <a href="pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                </li>
                <li class="nav-item">
                  <a href="pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>

    </div>
    </section>
    ';
  }

  // navbar index mobile
  function navbarIndexMobile() {
      $conn = db();
      $w=$conn->prepare("SELECT id FROM carrello
                        WHERE id_utente = ?");
      $w->bind_param('s', $_SESSION['cod_carrello']);		
      $w->execute();  
      $w->store_result();

      $sa = $w->num_rows;      
      echo '
      <section>
      <nav class="navbar navbar-light bg-black fixed-top">
        <div class="container-fluid">
        <div><a href="" ><li><img class="img-fluid logomobile" src="images/logo/freestyle2.png" width="150rem" alt="freestyle"></li></a></div>
          <div>
            <li class="nav-item icon85">
              <a href="pages/utente/preferiti"><i class="fas fa-heart"></i></a>
            </li>
          </div>

          <div>
            <li class="nav-item icon85">
              <a href="pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
            </li>
          </div>

          <button class="navbar-toggler closemobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-black">
              <div></div>
              <button type="button" class="btn-close closemobile text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body  text-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link mb-3 attivo" aria-current="page" href="index">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">

              ';    
              $a="SI";
              $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
              $s->bind_param("s", $a);
              $s->execute();  
              $r = $s->get_result(); 

              echo '
                    <li><a class="dropdown-item d-flex" href="pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                  ';
      
              while ($row = $r->fetch_assoc()) {
      
                  $id = $row['id'];
                  $nome = $row['n_categoria'];
                  $attiva = $row['attiva'];
      
                  echo '
                        <li><a class="dropdown-item d-flex" href="pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                  ';
              }
                        
                        
              echo '

                  </ul>
                </li>
              ';  
                      if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                        {
                          echo '

                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="config/server/logout">esci</a></li>
                                  </ul>
                                </li>
                                ';
                        }
                      else 
                        {
                          echo '<a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                        }  
              
          echo '
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </section>
    ';
  }

  //navbar account livello 2
  function navbarAccount2() {
    $conn = db();
    $w=$conn->prepare("SELECT id FROM carrello
        WHERE id_utente = ?");
    $w->bind_param('s', $_SESSION['cod_carrello']);		
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  


    echo '
    <section>
    <div class="container-fluid bg-black">

      <nav class="navbar navbar-expand-lg navbar-light bg-black nav58">
          <div class="container-fluid">
            <div class="col"></div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                  <div class="dropdown">
                    <a class="nav-link  my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                    
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
            ';

            $a="SI";
            $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
            $s->bind_param("s", $a);
            $s->execute();  
            $r = $s->get_result(); 

            echo '
                  <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                ';
    
            while ($row = $r->fetch_assoc()) {
    
                $id = $row['id'];
                $nome = $row['n_categoria'];
                $attiva = $row['attiva'];
    
                echo '
                      <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                ';
            }
                      
                 
            echo '          
                    </ul>
                  </div>

                </li>

                <li class="nav-item">
                  <a class="nav-link my-5 ms-5" aria-current="page" href="../../">home</a>
                </li>

                <li class="nav-item">
                ';

                    if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                      {
                        echo '
                            <li class="nav-item">
                              <div class="dropdown">
                                <a class="nav-link attivo my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                
                                <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
                                  <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                  <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                  <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                </ul>
                              </div>
                            </li>
                              ';
                      }
                    else 
                      {
                        echo '<a class="nav-link  my-5 ms-5" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                      }  
             
            echo '
                </li>
              </ul>

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 ico58">
                <li class="nav-item">
                <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                </li>
                <li class="nav-item">
                <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>
      </div>
    </section>
    ';
  }

  // navbar account mobile livello 2
  function navbarAccountMobile2() {
      $conn = db();
      $w=$conn->prepare("SELECT id FROM carrello
          WHERE id_utente = ?");
      $w->bind_param('s', $_SESSION['cod_carrello']);		
      $w->execute();  
      $w->store_result();

      $sa = $w->num_rows;        
      echo '
      <section>
      <nav class="navbar navbar-light bg-black fixed-top">
        <div class="container-fluid">
          <div><a href="../../" ><li><img class="img-fluid logomobile" src="../../images/logo/freestyle2.png" width="150rem" alt="freestyle"></li></a></div>
          <div>
            <li class="nav-item icon85">
              <a href="pages/utente/preferiti"><i class="fas fa-heart"></i></a>
            </li>
          </div>

          <div>
            <li class="nav-item icon85">
              <a href="pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
            </li>
          </div>
          <button class="navbar-toggler closemobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-black">
              <div></div>
              <button type="button" class="btn-close closemobile text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body  text-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link mb-3" aria-current="page" href="../../">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">

              ';    

              $a="SI";
              $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
              $s->bind_param("s", $a);
              $s->execute();  
              $r = $s->get_result(); 
  
              echo '
                    <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                  ';
      
              while ($row = $r->fetch_assoc()) {
      
                  $id = $row['id'];
                  $nome = $row['n_categoria'];
                  $attiva = $row['attiva'];
      
                  echo '
                        <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                  ';
              }
                        
                        
              echo '

                  </ul>
                </li>

                <li class="nav-item mb-3">

              ';  
                      if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                        {
                          echo '
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </li>
                                ';
                        }
                      else 
                        {
                          echo '<a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">login</a>';
                        }  
              
          echo '
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </section>
    ';
  }  

  /*navbar sconti livello 2
  function navbarSconti2() {
    $conn = db();
    echo '
    <section>
    <div class="container-fluid bg-black">

      <nav class="navbar navbar-expand-lg navbar-light bg-black nav58">
          <div class="container-fluid">
            <div class="col"></div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                  <div class="dropdown">
                    <a class="nav-link  my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                    
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
            ';       
                    $a="SI";
                    $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                    $s->bind_param("s", $a);
                    $s->execute();  
                    $r = $s->get_result(); 

                    echo '
                          <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                        ';
            
                    while ($row = $r->fetch_assoc()) {
            
                        $id = $row['id'];
                        $nome = $row['n_categoria'];
                        $attiva = $row['attiva'];
            
                        echo '
                              <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                        ';
                    }
                      
                 
            echo '          
                    </ul>
                  </div>

                </li>

                <li class="nav-item">
                  <a class="nav-link my-5 ms-5" aria-current="page" href="#../../">home</a>
                </li>

                <li class="nav-item">
                ';

                    if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                      {
                        echo '
                              <li class="nav-item">
                                <div class="dropdown">
                                  <a class="nav-link  my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  
                                  <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </div>
                              </li>
                              ';
                      }
                    else 
                      {
                        echo '<a class="nav-link  my-5 ms-5" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                      }  
             
            echo '
                </li>
              </ul>

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 ico58">
                <li class="nav-item">
                <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                </li>
                <li class="nav-item">
                <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart"></i></a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>
      </div>
    </section>
    ';
  }*/

  /* navbar sconti mobile livello 2
  function navbarScontiMobile2() {
      $conn = db();
      echo '
      <section>
      <nav class="navbar navbar-light bg-black fixed-top">
        <div class="container-fluid">
          <div></div>
          <button class="navbar-toggler closemobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-black">
              <div></div>
              <button type="button" class="btn-close closemobile text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body  text-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link mb-3" aria-current="page" href="../../">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">

              ';    

                      $a="SI";
                      $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                      $s->bind_param("s", $a);
                      $s->execute();  
                      $r = $s->get_result(); 
          
                      echo '
                            <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                          ';
              
                      while ($row = $r->fetch_assoc()) {
              
                          $id = $row['id'];
                          $nome = $row['n_categoria'];
                          $attiva = $row['attiva'];
              
                          echo '
                                <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                          ';
                      }
                        
                        
              echo '

                  </ul>
                </li>

                <li class="nav-item mb-3">

              ';  
                      if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                        {
                          echo '
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </li>
                                ';
                        }
                      else 
                        {
                          echo '<a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                        }  
              
          echo '
                </li>

                <li class="nav-item icon85">
                  <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                  <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </section>
    ';
  }*/

  //navbar catalogo livello 2
  function navbarCatalogo2() {
    $conn = db();
    $w=$conn->prepare("SELECT id FROM carrello
        WHERE id_utente = ?");
    $w->bind_param('s', $_SESSION['cod_carrello']);		
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;  
    echo '
    <section>
    <div class="container-fluid bg-black">

      <nav class="navbar navbar-expand-lg navbar-light bg-black nav58">
          <div class="container-fluid">
            <div class="col"></div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                  <div class="dropdown">
                    <a class="nav-link attivo my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                    
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
            ';

                      $a="SI";
                      $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                      $s->bind_param("s", $a);
                      $s->execute();  
                      $r = $s->get_result(); 

                      echo '
                            <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                          ';
              
                      while ($row = $r->fetch_assoc()) {
              
                          $id = $row['id'];
                          $nome = $row['n_categoria'];
                          $attiva = $row['attiva'];
              
                          echo '
                                <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                          ';
                      }
                      
                 
            echo '          
                    </ul>
                  </div>

                </li>

                <li class="nav-item">
                  <a class="nav-link my-5 ms-5" aria-current="page" href="../../">home</a>
                </li>

                <li class="nav-item">
                ';

                    if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                      {
                        echo '
                              <li class="nav-item">
                                <div class="dropdown">
                                  <a class="nav-link  my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  
                                  <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </div>
                              </li>
                              ';
                      }
                    else 
                      {
                        echo '<a class="nav-link  my-5 ms-5" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                      }  
             
            echo '
                </li>
              </ul>

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 ico58">
                <li class="nav-item">
                <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                </li>
                <li class="nav-item">
                  <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>
      </div>
    </section>
    ';
  }

  // navbar catalogo mobile livello 2
  function navbarCatalogoMobile2() {
      $conn = db();
      $w=$conn->prepare("SELECT id FROM carrello
          WHERE id_utente = ?");
      $w->bind_param('s', $_SESSION['cod_carrello']);		
      $w->execute();  
      $w->store_result();

      $sa = $w->num_rows;
      echo '
      <section>
      <nav class="navbar navbar-light bg-black fixed-top">
        <div class="container-fluid">
        <div><a href="../../" ><li><img class="img-fluid logomobile" src="../../images/logo/freestyle2.png" width="150rem" alt="freestyle"></li></a></div>
          <div>
            <li class="nav-item icon85">
              <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
            </li>
          </div>

          <div>
            <li class="nav-item icon85">
              <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
            </li>
          </div>
          <button class="navbar-toggler closemobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-black">
              <div></div>
              <button type="button" class="btn-close closemobile text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body  text-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link mb-3" aria-current="page" href="../../">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link attivo dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">

              ';    

                          $a="SI";
                          $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                          $s->bind_param("s", $a);
                          $s->execute();  
                          $r = $s->get_result(); 
              
                          echo '
                                <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                              ';
                  
                          while ($row = $r->fetch_assoc()) {
                  
                              $id = $row['id'];
                              $nome = $row['n_categoria'];
                              $attiva = $row['attiva'];
                  
                              echo '
                                    <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                              ';
                          }
                        
                        
              echo '

                  </ul>
                </li>

                <li class="nav-item mb-3">

              ';  
                      if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                        {
                          echo '
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </li>
                              ';
                        }
                      else 
                        {
                          echo '<a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                        }  
              
          echo '
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </section>
    ';
  }  

  //navbar sconti livello 2
  function navbarGenerico2() {
    $conn = db();
    $w=$conn->prepare("SELECT id FROM carrello
        WHERE id_utente = ?");
    $w->bind_param('s', $_SESSION['cod_carrello']);		
    $w->execute();  
    $w->store_result();

    $sa = $w->num_rows;
    echo '
    <section>
    <div class="container-fluid bg-black">

      <nav class="navbar navbar-expand-lg navbar-light bg-black nav58">
          <div class="container-fluid">
            <div class="col">
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                  <div class="dropdown">
                    <a class="nav-link my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                    
                    <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
            ';

                      $a="SI";
                      $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                      $s->bind_param("s", $a);
                      $s->execute();  
                      $r = $s->get_result(); 

                      echo '
                            <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                          ';
              
                      while ($row = $r->fetch_assoc()) {
              
                          $id = $row['id'];
                          $nome = $row['n_categoria'];
                          $attiva = $row['attiva'];
              
                          echo '
                                <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                          ';
                      }
                      
                 
            echo '          
                    </ul>
                  </div>

                </li>

                <li class="nav-item">
                  <a class="nav-link my-5 ms-5" aria-current="page" href="../../">home</a>
                </li>

                <li class="nav-item">
                ';

                    if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                      {
                        echo '
                              <li class="nav-item">
                                <div class="dropdown">
                                  <a class="nav-link  my-5 ms-5 dropdown-toggle " href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  
                                  <ul class="dropdown-menu mt-3" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </div>
                              </li>
                              ';
                      }
                    else 
                      {
                        echo '<a class="nav-link  my-5 ms-5" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                      }  
             
            echo '
                </li>
              </ul>

              <ul class="navbar-nav me-auto mb-2 mb-lg-0 ico58">
                <li class="nav-item">
                <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
                </li>
                <li class="nav-item">
                <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
                </li>
              </ul>
              
            </div>
          </div>
        </nav>
      </div>
    </section>
    ';
  }

  // navbar sconti mobile livello 2
  function navbarGenericoMobile2() {
      $conn = db();
      $w=$conn->prepare("SELECT id FROM carrello
          WHERE id_utente = ?");
      $w->bind_param('s', $_SESSION['cod_carrello']);		
      $w->execute();  
      $w->store_result();

      $sa = $w->num_rows;        
      echo '
      <section>
      <nav class="navbar navbar-light bg-black fixed-top">
        <div class="container-fluid">
        <div><a href="../../" ><li><img class="img-fluid logomobile" src="../../images/logo/freestyle2.png" width="150rem" alt="freestyle"></li></a></div>
        <div>
          <li class="nav-item icon85">
            <a href="../../pages/utente/preferiti"><i class="fas fa-heart"></i></a>
          </li>
        </div>

        <div>
          <li class="nav-item icon85">
            <a href="../../pages/carrello/carrello"><i class="fas fa-shopping-cart">';?><?php if($sa > 0) {echo "(".$sa.")";}else{}?><?php echo'</i></a>
          </li>
        </div>

          <button class="navbar-toggler closemobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-black">
              <div></div>
              <button type="button" class="btn-close closemobile text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body  text-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link mb-3" aria-current="page" href="../../">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link attivo dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">catalogo</a>
                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">

              ';    

                        $a="SI";
                        $s=$conn->prepare("SELECT * FROM categoria WHERE attiva = ?");
                        $s->bind_param("s", $a);
                        $s->execute();  
                        $r = $s->get_result(); 
            
                        echo '
                              <li><a class="dropdown-item d-flex" href="../../pages/collezione/tutta-la-collezione">TUTTA LA COLLEZIONE</a></li>
                            ';
                
                        while ($row = $r->fetch_assoc()) {
                
                            $id = $row['id'];
                            $nome = $row['n_categoria'];
                            $attiva = $row['attiva'];
                
                            echo '
                                  <li><a class="dropdown-item d-flex" href="../../pages/collezione/'.strtolower($nome).'">'.$nome.'</a></li>
                            ';
                        }
                        
                        
              echo '

                  </ul>
                </li>

                <li class="nav-item mb-3">

              ';  
                      if( isset($_SESSION['access']) OR isset($_COOKIE['access']) )
                        {
                          echo '
                                <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle mb-3" href="#" role="button" id="offcanvasNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">'.$_SESSION['nome'].' '.$_SESSION['cognome'].'</a>
                                  <ul class="dropdown-menu mb-3" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-dati">i miei dati</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../pages/utente/i-miei-ordini">i miei ordini</a></li>
                                    <li><a class="dropdown-item text-uppercase" href="../../config/server/logout">esci</a></li>
                                  </ul>
                                </li>
                              ';
                        }
                      else 
                        {
                          echo '<a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#modal1">accedi</a>';
                        }  
              
          echo '
                </li>

              </ul>
            </div>
          </div>
        </div>
      </nav>
    </section>
    ';
  }   

  // js
  function linkJs() {
    echo 
        '  
        <!-- JQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <!-- Swalfire -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>

        <!-- MEDIUM ZOOM -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/medium-zoom/1.0.6/medium-zoom.min.js" integrity="sha512-N9IJRoc3LaP3NDoiGkcPa4gG94kapGpaA5Zq9/Dr04uf5TbLFU5q0o8AbRhLKUUlp8QFS2u7S+Yti0U7QtuZvQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        ';
  }

  // js inline
  function jsInline(){
    echo '<script src="scripts/zoom.js"></script>';
  }

  // js inline livello 2
  function jsInline2(){
    echo '<script src="../../scripts/zoom.js"></script>';
  }

  // favicon
  function favicon() {
      echo '<link rel="icon" type="image/png" sizes="32x32" href="favicon.png">';
  }

  // favicon livello 2
  function favicon2() {
    echo '<link rel="icon" type="image/png" sizes="32x32" href="../../favicon.png">';
  }

  //footer Index
  function footerIndex(){
    echo '
      <footer>

        <div class="container">  

          <div class="row">
            
              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
              <h1>AREA LEGALE</h1>
                <a href="pages/politiche/privacy" class="text-decoration-none"><p>Politica della privacy</p></a>
                <a href="pages/politiche/reso-e-spedizioni" class="text-decoration-none"><p>Reso e spedizioni</p></a>
                <a href="pages/politiche/aiuto-e-faq" class="text-decoration-none"><p>Aiuto e FAQ</p></a>
              </div>
          
              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
                <h1>IL NOSTRO STORE</h1>
                  <p>Via Giuseppe Giacosa 2,</p>
                  <p>Nichelino 10042 (TO)</p>
                  <p>+39 392 667 4386</p>
                  <p>P.IVA:12572410012</p>
              </div>

              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
                <h1>INFO</h1>
                  <a href="index" style="text-decoration:none;"><p>Home</p></a>
                  <a href="pages/collezione/tutta-la-collezione" style="text-decoration:none;"><p>Collezione</p></a>
                  <a href="pages/utente/i-miei-dati" style="text-decoration:none;"><p>Utente</p></a>
                  <a href="pages/carrello/carrello" style="text-decoration:none;"><p>Carrello</p></a>
                  <a href="sitemap" style="text-decoration:none;"><p>Mappa del sito</p></a>
              </div>

              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-5 text-center">
                <h4>©2022 freestyleconceptstore <br>Tutti i diritti riservati</h4>
              </div>
              
          </div>  
        </div>

      </footer>
    ';
  }

  //footer livello2
  function footer2(){
    echo '
      <footer>

        <div class="container">  

          <div class="row">
            
              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
              <h1>AREA LEGALE</h1>
                <a href="../../pages/politiche/privacy" class="text-decoration-none"><p>Politica della privacy</p></a>
                <a href="../../pages/politiche/reso-e-spedizioni" class="text-decoration-none"><p>Reso e spedizioni</p></a>
                <a href="../../pages/politiche/aiuto-e-faq" class="text-decoration-none"><p>Aiuto e FAQ</p></a>
              </div>
          
              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
                <h1>IL NOSTRO STORE</h1>
                  <p>Via Giuseppe Giacosa 2,</p>
                  <p>Nichelino 10042 (TO)</p>
                  <p>+39 392 667 4386</p>
                  <p>P.IVA:12572410012</p>
              </div>

              <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4 mt-5 text-center">
                <h1>INFO</h1>
                  <a href="../../" style="text-decoration:none;"><p>Home</p></a>
                  <a href="../../pages/collezione/tutta-la-collezione" style="text-decoration:none;"><p>Collezione</p></a>
                  <a href="../../pages/utente/i-miei-dati" style="text-decoration:none;"><p>Utente</p></a>
                  <a href="../../pages/carrello/carrello" style="text-decoration:none;"><p>Carrello</p></a>
                  <a href="../../sitemap" style="text-decoration:none;"><p>Mappa del sito</p></a>
              </div>

              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mt-5 text-center">
                <h4>©2022 freestyleconceptstore <br> Tutti i diritti riservati</h4>
              </div>
              
          </div>  
        </div>

      </footer>
    ';
  }

  //scadenza codice sconto
  function cod_sconto() {
    $conn = db();
    $today = date("Y-m-d");
    
    // Rimuovi bonus scaduti      
    $r_bonus=$conn->prepare("DELETE FROM cod_sconto WHERE durata < ?");		
    $r_bonus->bind_param("s", $today);
    $r_bonus->execute();
    $r_bonus->close();
  }
  
?>