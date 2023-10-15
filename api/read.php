<?php
	// add headers cos it http request
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	// initiliazing api
	include_once('../core/init.php');

	//instantiate the post class
	$post = new Post($db);

	// query blog post
	$result = $post->read();
	
	//get the row count
	$num = $result->rowCount();

	if($num > 0){
		$post_arr = array();
		$post_arr['data'] = array();

		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			$post_item = array(
				'id' => $id,
				'title' => $title,
				'body' => html_entity_decode($body),
				'author' => $author,
				'category_id' => $category_id,
				'category_name' => $category_name,
				'created-at' => $created_at
			);
			array_push($post_arr['data'], $post_item);
		}
		// convert to json and output
		echo json_encode($post_arr);

	} else {
		echo json_encode(array('message' => 'No post found'));
	}
?>