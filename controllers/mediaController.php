<?php
	require_once("../includes/db.php");
	// Fetch Media
	function fetchMedia($category_id, $pageNo = 1){
		global $db;
		$category_id = $db->validNum($category_id);
		$pageNo = $db->validNum($pageNo);
		$activePage = $pageNo;
		// Get Category
		$category = $db->selectSingle("categories", array("id" => $category_id));
		if(!$category) return false;

		// Limit
		$pageNo = intval($pageNo) - 1;
		if($pageNo < 0) $pageNo = 0;
		$limitOffset = $pageNo * 10;
		$limit = "10 offset " . $limitOffset;

		// Search Query
		$search = "";
		if(isset($_POST['search_query'])){
			$search_query = strtolower($db->validText($_POST['search_query']));
			if(strlen($search_query) > 0){
				$search = " AND LOWER(name) LIKE '%". $search_query ."%'";
			}
		}

		// Fetch Media
		$path = "./images/editor/media/";
		$media = array();
		$media_files = $db->query("SELECT * FROM media WHERE category_id='$category_id' $search ORDER BY id DESC LIMIT $limit");
		if($media_files){
			foreach($media_files as $file){
				array_push($media, array(
					"id" => $file['id'],
					"type" => $file['type'],
					"src" => $path . $file['src'])
				);
			}
		}
		// Total Count
		$total = 0;
		$countTotal = $db->query("SELECT * FROM media WHERE category_id='$category_id' $search");
		if($countTotal){
			$total = count($countTotal);
		}
		echo json_encode([
			"status" => "success",
			"data" => $media,
			"total" => $total,
			"type" => $category['name'],
			"typeId" => $category['id'],
			"activePage" => $activePage
		]);
	}
	// Get Media Images on Page Load
	if(isset($_POST['getMedia'])){
		$category_id = ($_POST['getMedia']);
		fetchMedia($category_id);
	}
	// Get Media By Pagination
	if(isset($_POST['paginationAction'])){
		$action = $_POST['paginationAction'];
		if($action == "fetchUserMedia"){
			fetchMedia($_POST['target'], $_POST['pageNo']);
		}
	}