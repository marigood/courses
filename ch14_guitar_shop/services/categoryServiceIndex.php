<?php
try
{
	require('../model/database.php');
	require('../model/category.php');
	require('../model/category_db.php');
	require('../model/product.php');
	require('../model/product_db.php');
	
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
        header('Access-Control-Allow-Headers: token, Content-Type');
        header('Access-Control-Max-Age: 1728000');
        header('Content-Length: 0');
        header('Content-Type: text/plain');
        die();
    }

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    $action = filter_input(INPUT_POST, 'action');
	if ($action == NULL) {
		$action = filter_input(INPUT_GET, 'action');
		if ($action == NULL) {
			$action = 'getCategories';
		}
	}

	if ($action == 'getCategories') {
	
	}	
	else if ($action == 'deleteCategory') {
		$category_id = filter_input(INPUT_POST, 'category_id', 
			FILTER_VALIDATE_INT);
		if ($category_id == NULL || $category_id == FALSE) {
			$error = "Missing or incorrect category id.";
		} else { 
			CategoryDB::deleteCategory($category_id);
		}
	}
	else if ($action == 'addCategory') {
		$name = filter_input(INPUT_POST, 'name');
		if ($name == NULL || $name == false) {
			$error = "Invalid category name. Try again.";
		} else { 
			CategoryDB::addCategory($name);
		}
	}
	else {
		$error = "Invalid action";
	}
	
	if (!isset($error)) {
		$categories = CategoryDB::getCategories();
		echo json_encode($categories);
	}
	else {
		header('HTTP/1.1 500 Internal Server Booboo');
		$result = array();
		$result['status'] = 500;
		$result['message'] = $error;
		echo json_encode($result);
	}
		
}
catch (PDOException $e) {
	header('HTTP/1.1 500 Internal Server Booboo');
	$error = $e->getMessage();
	$result = array();
	$result['status'] = 500;
	$result['message'] = $error;
	echo json_encode($result);
}
?>