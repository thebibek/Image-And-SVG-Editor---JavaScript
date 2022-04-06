<?php
	require_once("../includes/db.php");
	// Upload Background
	if(isset($_POST['uploadMedia'])){
		$category_id = $db->validNum($_POST['uploadMedia']);
		$success = 0;
		$error = 0;
		$name = $_POST['name'];
		$count = 0;
		foreach($_FILES['file']['name'] as $file){
			if($count < count($_FILES['file'])){
				$file = $_FILES['file']['tmp_name'][$count];
				$file_name = $_FILES['file']['name'][$count];
				$file_name_array = explode(".", $file_name);
				$extension = strtolower(end($file_name_array));
				$new_image_name = md5(time()) . $count . '.' . $extension;
				$allowed_extension = array("jpg", "gif", "png", "svg");
				if(in_array($extension, $allowed_extension)){
					if(move_uploaded_file($file, "../../images/editor/media/" . $new_image_name)){
						$insert = $db->insert("media", [
							"name" => $name,
							"src" => $new_image_name,
							"category_id" => $category_id
						]);
						if($insert){
							$success++; 
						} else {
							$error++;
						}
					}
				} else {
					$error++;
				}
			}
			$count++;
		}
		$msg = "";
		if($success > 0){
			$msg .= $success . " Files Uploaded Successfully ";
		}
		if($error > 0){
			$msg .=  $error . " Files Failed";
		}
		if($msg == ""){
			echo error();
		} else {
			echo success($msg);
		}
	}
	// Add Category
	if(isset($_POST['addCategory'])){

		unset($_POST['addCategory']);
		$_POST['dontEncode'] = "icon";


		$insert = $db->insert("categories", $_POST);
		// Update
		if(isset($_POST['updateCategory'])){
			$insert = $db->update("categories", array(
				"name" => $_POST['name'],
				"icon" => $_POST['icon'],
				"dontEncode" => "icon"
			), array(
				"id" => $_POST['updateCategory']
			));
		}
		if($insert){
			echo success("New Category Added Successfully", "categories");
		}
	}
	// Change Pasword
	if(isset($_POST['changePassword'])){
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		// Check Current Pasword
		if(password_verify($current_password, $admin['password'])){
			if($new_password === $confirm_password){
				$new_password = password_hash($new_password, PASSWORD_BCRYPT);
				$update = $db->update("admins", array("password" => $new_password), array("id"=>$admin['id']));
				if($update){
					echo json_encode([
						"status" => "success",
						"data" => "Your password has been changed successfully",
						"heading" => "Password Updated"
					]);
				}
			} else {
				echo error("Confirm Password is not matching with New Password. Please Enter the same password", "Passowrd Not Matching");
			}
		} else {
			echo error("Please try again with valid password!", "Existing Password is Wrong");
		}
	}
	// Delete Media File
	if(isset($_POST['deleteFile'])){
		$media_id = $_POST['deleteFile'];
		$media = $db->selectSingle("media", array("id"=>$media_id));
		if($media){
            unlink("../../images/editor/media/" . $media['src']);
            $delete = $db->delete("media",array("id"=>$media_id));
            if($delete){
                echo "success";
            }
        }
	}
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
		$limitOffset = $pageNo * 12;
		$limit = "12 offset " . $limitOffset;

		// Search Query
		$search = "";
		if(isset($_POST['search_query'])){
			$search_query = strtolower($db->validText($_POST['search_query']));
			if(strlen($search_query) > 0){
				$search = " AND LOWER(name) LIKE '%". $search_query ."%'";
			}
		}

		// Fetch Media
		$path = "../images/editor/media/";
		$media = array();
		$media_files = $db->query("SELECT * FROM media WHERE category_id='$category_id' $search ORDER BY id DESC LIMIT $limit");
		if($media_files){
			foreach($media_files as $file){
				array_push($media, array(
					"id" => $file['id'],
					"name" => $file['name'],
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
	// Change Media Name
	if(isset($_POST['changeMediaName'])){
		$media_id = $db->validNum($_POST['changeMediaName']);
		$name = ($_POST['name']);

		$update = $db->update("media", array("name"=> $name), array("id" => $media_id));
		if($update){
			echo "success";
		} else {
			echo "error";
		}
	}