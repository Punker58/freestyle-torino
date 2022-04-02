<?php 
	session_start();
	session_destroy();
	echo '<script>
			document.cookie = "access_admin=; max-age=0; path=/";
			location.replace("login");
		</script>';
 ?>