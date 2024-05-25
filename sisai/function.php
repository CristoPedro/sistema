<?php

$conn = new mysqli("localhost", "root", "", "publicacao");


 // Verificar a conexão
 if ($conn->connect_error) {
     die("Erro de conexão: " . $conn->connect_error);
 }

 // Verificar se os valores estão definidos
if (!isset($_POST["post_id"]) || !isset($_POST["user_id"]) || !isset($_POST["status"])) {
    die("Erro: Valores não definidos.");
}

echo "post_id: $post_id, user_id: $user_id, status: $status";

$post_id = $_POST["post_id"];

$user_id = $_POST["user_id"];
$status = $_POST["status"];

$ratings = mysqli_query($conn, "SELECT * FROM ratings WHERE post_id = $post_id AND user_id = $user_id");
if(mysqli_num_rows($ratings) > 0){
    $ratings = mysqli_fetch_assoc($ratings);

    if($ratings['status'] == $status){
        mysqli_query($conn, "DELETE FROM ratings WHERE post_id = $post_id AND user_id = $user_id");
        echo "delete" . $status;
    }else {
        mysqli_query($conn, "UPDATE ratings SET status = '$status' WHERE post_id = $post_id AND user_id = $user_id");
        echo "changeto" . $status;
    }
}
else {
    mysqli_query($conn, "INSERT INTO ratings VALUES ('', '$post_id', '$user_id', '$status')");
    echo "new" . $status;
}
// Obter o ID do usuário que fez a publicação
$sql_post_user_id = "SELECT idusuario FROM publica_incendio WHERE id = ?";
$stmt_post_user_id = $conn->prepare($sql_post_user_id);
$stmt_post_user_id->bind_param("i", $post_id);
$stmt_post_user_id->execute();
$stmt_post_user_id->store_result();

if ($stmt_post_user_id->num_rows > 0) {
    $stmt_post_user_id->bind_result($post_user_id);
    $stmt_post_user_id->fetch();

    if ($user_id != $post_user_id) {
        $sql_notificacao = "INSERT INTO notificacoes (user_id, post_id, type) VALUES (?, ?, ?)";
        $stmt_notificacao = $conn->prepare($sql_notificacao);
        $stmt_notificacao->bind_param("iis", $post_user_id, $post_id, $status);
        $stmt_notificacao->execute();
        $stmt_notificacao->close();
    }
}

$stmt_post_user_id->close();
$conn->close();
