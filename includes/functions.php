<?php
	function success($data){
		echo json_encode([
			"status" => "success",
			"data" => $data
		]);
	}