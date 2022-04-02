<?php 
	session_start();
	session_destroy();
	echo '<script>
			document.cookie = "access=; max-age=0; path=/";
			document.cookie = "cod_carrello=; max-age=0; path=/";
			location.replace("../../");
		</script>';
 ?>