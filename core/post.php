<?php
	class Post{
		//db stuffs
		private $conn;
		private $table = 'post';

		// post properties
		public $id;
		public $category_id;
		public $category_name;
		public $title;
		public $body;
		public $author;
		public $created_at;

		// constructor with db conn
		public function __construct($db){
			$this->conn = $db;
		}

		// getting post from db
		public function read(){
			// create query
			$query = 'SELECT
				c.name as category_name,
				p.id,
				p.category_id,
				p.title,
				p.body,
				p.author,
				p.created_at
				FROM
				' .$this->table. ' p
				LEFT JOIN
					categories c ON p.category_id = c.id
					ORDER BY p.created_at ASC';
			
			// prepare statement
			$stmt = $this->conn->prepare($query);
			// execute
			$stmt->execute();

			return $stmt;
		}

		public function readSingle() {
			$query = 'SELECT
				c.name as category_name,
				p.id,
				p.category_id,
				p.title,
				p.body,
				p.author,
				p.created_at
				FROM
				' .$this->table. ' p
				LEFT JOIN
					categories c ON p.category_id = c.id
					WHERE p.id = ? LIMIT 1';

			// prepare statement
			$stmt = $this->conn->prepare($query);

			// bind param
			$stmt->bindParam(1, $this->id);

			//executing query
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->title = $row['title'];
			$this->body = $row['body'];
			$this->author = $row['author'];
			$this->category_id = $row['category_id'];
			$this->category_name = $row['category_name'];
			$this->created_at = $row['created_at'];
		}

		public function create() {
			// create query
			$query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';

			// prepare statemnt
			$stmt = $this->conn->prepare($query);

			//clean data to be saved
			$this->title = htmlspecialchars((strip_tags($this->title)));
			$this->body = htmlspecialchars((strip_tags($this->body)));
			$this->author = htmlspecialchars((strip_tags($this->author)));
			$this->category_id = htmlspecialchars((strip_tags($this->category_id)));

			// binding params
			$stmt->bindParam(':title', $this->title);
			$stmt->bindParam(':body', $this->body);
			$stmt->bindParam(':author', $this->author);
			$stmt->bindParam(':category_id', $this->category_id);

			// execute query
			if($stmt->execute()) {
				return true;
			}

			// print error if true
			printf("Error %s. \n", $stmt->error);
			return false;
		}

		public function update() {
			// create query
			$query = 'UPDATE ' . $this->table . ' 
			SET title = :title, body = :body, author = :author, category_id = :category_id
			WHERE id = :id';

			// prepare statemnt
			$stmt = $this->conn->prepare($query);

			//clean data to be saved
			$this->title = htmlspecialchars((strip_tags($this->title)));
			$this->body = htmlspecialchars((strip_tags($this->body)));
			$this->author = htmlspecialchars((strip_tags($this->author)));
			$this->category_id = htmlspecialchars((strip_tags($this->category_id)));
			$this->id = htmlspecialchars((strip_tags($this->id)));

			// binding params
			$stmt->bindParam(':title', $this->title);
			$stmt->bindParam(':body', $this->body);
			$stmt->bindParam(':author', $this->author);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':id', $this->id);

			// execute query
			if($stmt->execute()) {
				return true;
			}

			// print error if true
			printf("Error %s. \n", $stmt->error);
			return false;
		}

		public function delete() {
			// create delete query
			$query = 'DELETE FROM '. $this->table . ' WHERE id = :id';

			// prepare statement
			$stmt = $this->conn->prepare($query);

			//clean data
			$this->id = htmlspecialchars((strip_tags($this->id)));

			// bind param
			$stmt->bindParam(':id', $this->id);

			// execute query
			if($stmt->execute()) {
				return true;
			}

			// print error if true
			printf("Error %s. \n", $stmt->error);
			return false;
		}
	}
?>