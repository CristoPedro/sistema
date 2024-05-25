<?php
session_start();
 // Certifique-se de que o caminho está correto
// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");



// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $notificationId = $_POST['id'];

    // Atualizar a notificação para marcá-la como lida
    $sql = "UPDATE notificacoes SET lido = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notificationId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo 'success';
} else {
    echo 'error';
}
?>
