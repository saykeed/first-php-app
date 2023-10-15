<?php
	// add headers cos it http request
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Conrol-Allow-Headers: Access-Conrol-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

	// initiliazing api
	include_once('../core/init.php');

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		echo json_encode(
			array('message' => "Method {$_SERVER['REQUEST_METHOD']} not allowed")
		);
		return;
	}

	//instantiate the post class
	$post = new Post($db);

	// get posted data
	$data = json_decode(file_get_contents("php://input"));

	$post->title = $data->title;
	$post->body = $data->body;
	$post->author = $data->author;
	$post->category_id = $data->category_id;

	// create post
	if($post->create()) {
		echo json_encode(
			array('message' => 'Post created')
		);
	} else {
		echo json_encode(
			array('message' => 'Post not created')
		);
	}

?>