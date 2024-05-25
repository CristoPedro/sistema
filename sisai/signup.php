<?php

// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");



// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para limpar os dados de entrada
function limpar_dados($dados) {
	global $conn;
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
	$dados = mysqli_escape_string($conn, $dados);
    return $dados;
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar o campo username
    if (empty($_POST["username"])) {
        $em = "Nome de usuário é obrigatório.";
		header("Location: signup.php?error=$em");
    } else {
        $username = limpar_dados($_POST["username"]);
        // Verificar se o username contém apenas letras e números
        if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
            $em = "Nome de usuário deve conter apenas letras e números.";
			header("Location: signup.php?error=$em");
        }

		if(is_numeric($username)){
			$em = "O nome de usuário não pode ser um número.";
			header("Location: signup.php?error=$em");
		}
    }

    // Validar o campo email
    if (empty($_POST["email"])) {
        $em = "Endereço de email é obrigatório.";
		header("Location: signup.php?error=$em");
    } else {
        $email = limpar_dados($_POST["email"]);
        // Verificar se o email está em um formato válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $em = "Formato de email inválido.";
			header("Location: signup.php?error=$em");
        }
    }

    // Validar o campo password
    if (empty($_POST["password"])) {
        $em = "Senha é obrigatória.";
		header("Location: signup.php?error=$em");

    } else {
        $password = limpar_dados($_POST["password"]);
        // Aqui você pode adicionar outras verificações, como a força da senha
		  # checking the database if the username is taken
		  $sql = "SELECT username 
		  FROM usuarios
		  WHERE username = '$username' ";
		$result = $conn->query($sql);

		if($result){
			if(mysqli_num_rows($result) > 0){
		$em = "O nome de usuario ($username) Ja esta a seu usado por alguem";
		header("Location: signup.php?error=$em");
		exit;
		}
	 }
		  $sql2 = "SELECT email 
		  FROM usuarios
		  WHERE email = '$email' ";
		$resultado = $conn->query($sql2);

		if($resultado){
			if(mysqli_num_rows($resultado) > 0){
		$em = "O email ($email) Ja esta a seu usado por alguem";
		header("Location: signup.php?error=$em");
		exit;
		}
	 }
    }

   
        // $foto_nome = $_FILES["profile_photo"]["name"];
        // $foto_tipo = $_FILES["profile_photo"]["type"];
        // $foto_tamanho = $_FILES["profile_photo"]["size"];
        // $foto_temp = $_FILES["profile_photo"]["tmp_name"];
        
        // Aqui você pode adicionar outras verificações, como tipo de arquivo e tamanho máximo


    // Se não houver erros, você pode prosseguir com o processamento dos dados
    if (isset($_FILES['profile_photo'])) {
        // Processar os dados aqui
        
        // Upload da foto de perfil

    

    $formatoPerm = array("png","jpeg","jpg","gif");
    $extensao = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);

         if(in_array($extensao, $formatoPerm)):
            $pasta = "upload/";
            $temporario = $_FILES['profile_photo']['tmp_name'];
            $novoNome = uniqid().".$extensao";

             if(move_uploaded_file($temporario, $pasta.$novoNome)):
               // Validar os dados (neste exemplo, vamos supor que todos os campos são obrigatórios)
			
        
        // E então inserir os dados no banco de dados, lembrando-se de usar prepared statements para evitar injeção SQL
		 // Hash da senha
		 
		  	else:
				  $em = "Erro ao fazer o upload";
				header("Location: signup.php?error=$em");

			  endif;
		  else:
			 $em = "Ficheiro inválido (tem que ser: .jpeg, .png, .gif, .jpg)";
			header("Location: signup.php?error=$em");

		  endif;
 
    }
	if (isset($novoNome)) {

	$hashed_password = md5($password);
        
		 // Preparar e executar a consulta SQL
		 $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email, photo) VALUES (?, ?, ?, ?)");
		 $stmt->bind_param("ssss", $username, $hashed_password, $email, $novoNome);
		 
		 if ($stmt->execute()) {
			$sm = "Conta SISPI criada com sucesso";
			header("Location: login.php?success=$sm");
     		exit;
		 } else {
			$sm = "Deu erro ao criar conta";
			

			header("Location: login.php?error=$sm");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }else {
		$hashed_password = md5($password);
        
		 // Preparar e executar a consulta SQL
		 $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)");
		 $stmt->bind_param("sss", $username, $hashed_password, $email);
		 
		 if ($stmt->execute()) {
			$sm = "Conta SISPI criada com sucesso";
			header("Location: login.php?success=$sm");
     		exit;
		 } else {
			$sm = "Deu erro ao criar conta";
			

			header("Location: login.php?error=$sm");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }
}

?>

<!DOCTYPE html>
<html lang="pt">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Criar conta no SISPI</title>

		<!-- Meta -->
		<meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
		<meta name="author" content="Bootstrap Gallery" />
		<link rel="canonical" href="https://www.bootstrap.gallery/">
		<meta property="og:url" content="https://www.bootstrap.gallery">
		<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
		<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Bootstrap Gallery">
		<link rel="shortcut icon" href="assets/images/favicon.svg" />

		<!-- *************
			************ CSS Files *************
		************* -->
		<link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
		<link rel="stylesheet" href="assets/css/main.min.css" />
		<style>
			#foto {
				display: none;
			}
			.foto {
				font-size: 23px;
				font-size: normal;
				cursor: pointer;

			}
			i {
				cursor: pointer;
			}
		</style>
	</head>

	<body>
		<!-- Container start -->
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-sm-6 col-12">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data" class="my-5">
						<div class="border border-dark rounded-2 p-4 mt-5">
							<div class="login-form">
								<a href="index.html" class="mb-4 d-flex">
									<img src="../image/icones/icones2/logo_transparent.png" width="150px"  alt="Sistema de publicação de incêndios" />
								</a>
								<h5 class="fw-light mb-5">Criar uma uma conta no SISPI.</h5>
								<?php if (isset($_GET['error'])) { ?>
								<div class="alert alert-warning" role="alert">
								<?php echo htmlspecialchars($_GET['error']);?>
								</div>
								<?php } 
								
								if (isset($_GET['name'])) {
									$name = $_GET['name'];
								}else $name = '';

								if (isset($_GET['username'])) {
									$username = $_GET['username'];
								}else $username = '';
								?>
								<div class="mb-3">

									<div class="was-validated">
										<label for="validationCustom01" class="form-label">Nome de usuário</label>
										<input type="text" name="username" value="<?php echo isset($username) ? $username : ''; ?>"class="form-control" id="validationCustom01" required/>
										
										<div class="valid-feedback">Obrigatorio!</div>
									</div>
								</div>
								<div class="mb-3">
									<div class="was-validated">
										<label for="validationCustom02" class="form-label">Seu e-mail</label>
										<input type="email" value="<?php echo isset($email) ? $email : ''; ?>" name="email" class="form-control" id="validationCustom02" required/>
  										 
										<div class="invalid-feedback">
											Precisamos de um email válido.
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="foto">
										<i class="fs-3 bi bi-file-earmark-image"></i>
										<span class="foto">Foto de Perfil</span>
									</label>
									<input type="file" name="profile_photo" id="foto" />
									
								</div>
								<div class="mb-3">
									<label for="form-control">
										Palavra-passe
									</label>
									<input type="password" name="password" class="form-control" required />
   									 

								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div class="form-check m-0">
										<div class="form-check was-validated">
											<input type="checkbox" class="form-check-input" id="validationFormCheck1" required />
											<label class="form-check-label" for="validationFormCheck1">Aceitar termos e condições</label>
										</div>
									</div>
								</div>
								<div class="d-grid py-3 mt-4">
									<input type="submit" name="submit" value="Criar a minha conta"  class="btn btn-lg btn-primary">
										

								</div>
								
								<div class="text-center pt-4">
									<span>Já tens uma conta?</span>
									<a href="login.php" class="text-blue text-decoration-underline ms-2">
										Entrar</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Container end -->
	</body>
	<script src="assets/js/custom.js"></script>
	<script src="assets/js/validations.js"></script>
</html>