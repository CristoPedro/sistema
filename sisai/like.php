<?php

session_start();

  // Conexão com o banco de dados
  $conn = new mysqli("localhost", "root", "", "publicacao");


  // Verificar a conexão
  if ($conn->connect_error) {
      die("Erro de conexão: " . $conn->connect_error);
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$postId = $_POST['post_id'];
	$userId = $_SESSION["id"];

	//verficar
	$stmt = $conn->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
	$stmt->bind_param('ii', $postId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();

	if($result->num_rows === 0){
		$stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
		$stmt->bind_param('ii', $postId, $userId);
		$stmt->execute();
		$action ="liked";

		
	}else {
		$stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
		$stmt->bind_param('ii', $postId, $userId);
		$stmt->execute();
        $action ="unliked";
	}
     
	//Contar o número de like na publicação 
     $stmt = $conn->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
	 $stmt->bind_param("i", $postId);
	 $stmt->execute();
	 $result = $stmt->get_result();
	 $likeCount = $result->fetch_assoc()["like_count"];


	// header("Location: {$_SERVER['HTTP_REFERER']}");
	echo json_encode(["action" => $action, "like_count" => $likeCount]);

	exit;
  }
  ?>