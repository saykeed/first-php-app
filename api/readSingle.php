<?php
	// add headers cos it http request
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	// initiliazing api
	include_once('../core/init.php');

	//instantiate the post class
	$post = new Post($db);

	if(isset($_GET['id']) && $_GET['id']) {

		$post->id = $_GET['id'];

		$post->readSingle();

		$post_arr = array(
			'id' => $post->id,
			'title' => $post->title,
			'body' => $post->body,
			'author' => $post->author,
			'category_id' => $post->category_id,
			'category_name' => $post->category_name,
			'created-at' => $post->created_at
		);

		// make a json
		print_r(json_encode($post_arr));

	} else {
		echo json_encode(
			array('message' => 'id is required')
		);
	}

	
?>