<?php
	function redirectTo($url){
		echo '<script>lcoation.assign("'. $url .'")</script>';
		die();
	}
	if(isset($_SESSION['admin'])){
		redirectTo("dashboard");
	} else {
		redirectTo("login");
	}