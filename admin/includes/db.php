<?php
	session_start();
	require_once("inc/database.php");
	if(!isset($_SESSION['admin'])){
		redirectTo("login");
	}
	$admin_id = $_SESSION['admin'];
	$admin = $db->selectSingle("admins",array("id" => $admin_id));
	if(!$admin){
		redirectTo("login");
	}