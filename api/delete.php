<?php
	// add headers cos it http request
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Conrol-Allow-Headers: Access-Conrol-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	// initiliazing api
	include_once('../core/init.php');

	if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
		echo json_encode(
			array('message' => "Method {$_SERVER['REQUEST_METHOD']} not allowed")
		);
		return;
	}

	//instantiate the post class
	$post = new Post($db);

	if(isset($_GET['id']) && $_GET['id']) {

		$post->id = $_GET['id'];

		if($post->delete()) {
			echo json_encode(
				array('message' => 'Post deleted successfully')
			);
		} else {
			echo json_encode(
				array('message' => 'Unable to delete post')
			);
		}


	} else {
		echo json_encode(
			array('message' => 'id is required')
		);
	}

?>