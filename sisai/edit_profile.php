
<?php


session_start();
// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");



// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
 // Verificar se o usuário está logado
 if (!isset($_SESSION['id'])) {
     header("Location: login.php");
     exit();
 }

 function limpar_dados($dados) {
	global $conn;
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
	$dados = mysqli_escape_string($conn, $dados);
    return $dados;
}


if(isset($_POST['Enviar_dados'])):
    

     $username = limpar_dados($_POST['username']);
     $email = limpar_dados($_POST['email']);
     $id = $_POST['id'];
     $password = limpar_dados($_POST['password']);
     
     $password = md5($password);
    
if($_FILES["photo"]["name"]){
    $foto = $_FILES["photo"]["name"];
    $foto_temp = $_FILES["photo"]["tmp_name"];
    $past = "upload/" . $foto;

    // verificar tipos permitidos
    $permitidos = array('jpg', 'jpeg', 'png', 'gif');
    $extensao = pathinfo($foto, PATHINFO_EXTENSION);
    if(!in_array($extensao, $permitidos)){
        die("Erro: esse tipo ou extensão da imagem carregada não é permitido");
    }

    if($_FILES["photo"]["size"] > 5 * 1024 * 1024){
        die("Erro arquivo muito grande no maximo deve ter 5MB");
    }

    move_uploaded_file($foto_temp, $past);
}

// Query de atualização

if($_FILES["photo"]["name"]){
    $sql = "UPDATE usuarios SET username = '$username', password = '$password',  email = '$email', photo = '$foto'  WHERE id = $id";

}else {
    $sql = "UPDATE usuarios SET username = '$username', password = '$password',  email = '$email'  WHERE id = $id";

}
    
    
    
   if($conn->query($sql) === TRUE){
       echo "Dados enviados";
       header("Location: perfil_user.php");
   }else{
       echo "erro". $conn->error;
   }
      
        
        else:
            echo "Erro ao enviar";
      endif;
?>