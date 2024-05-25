
<?php
// Iniciar a sessão
session_start();
 if(isset($_POST['username']) &&
	isset($_POST['password'])){
 
	# database connection file
	
// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");



// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
	
	# get data from POST request and store them in var
	$password = $_POST['password'];
	$username = $_POST['username'];
	
	#simple form Validation
	if(empty($username)){
	   # error message
	   $em = "Verifica seu nome de usuario";
 
	   # redirect to 'index.php' and passing error message
	   header("Location: login.php?error=$em");
	}else if(empty($password)){
	   # error message
	   $em = "Digite bem a sua passe";
 
	   # redirect to 'index.php' and passing error message
	   header("Location: login.php?error=$em");
	}else {
	    // Preparar e executar a consulta SQL para obter as informações do usuário
		$stmt = $conn->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 1) {
			$password = md5($password);
			$row = $result->fetch_assoc();
			if ($password == $row['password']) {
				// Credenciais válidas, iniciar a sessão
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				
				// Redirecionar para a página principal ou qualquer outra página desejada
				header("Location: perfil_user.php");
				exit();
			} else {
				$em = "Senha incorreta. Tente novamente.";
 
				# redirect to 'index.php' and passing error message
				header("Location: login.php?error=$em");
				
			}
		  } else {
           $em = "Usuário não encontrado. tente novamente.";
		   header("Location: login.php?error=$em");
			
  		  }
	   }
	}
 ?>




<!DOCTYPE html>
<html lang="pt">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Entar no SISPI</title>

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
	</head>

	<body>
		<!-- Container start -->
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-sm-6 col-12">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="my-5">
						<div class="border border-dark rounded-2 p-4 mt-5">
							<div class="login-form">
								<a href="#" class="mb-4 d-flex">
									<img src="../image/icones/icones2/logo_transparent.png" class="img-fluid login-logo" id="logo" alt="Nyke Admin" />
								</a>
								<?php if (isset($_GET['error'])) { ?>
								<div class="alert alert-warning" role="alert">
								<?php echo htmlspecialchars($_GET['error']);?>
								</div>
								<?php } ?>
								
								<?php if (isset($_GET['success'])) { ?>
								<div class="alert alert-success" role="alert">
								<?php echo htmlspecialchars($_GET['success']);?>
								</div>
								<?php } ?>
								<h5 class="fw-light mb-5">Acesse sua conta</h5>
								<div class="mb-3">
									<label class="validationCustom01">Nome Usuario</label>
									<input type="text" name="username" class="form-control" placeholder="Seu nome de usuario" required/>
								</div>
								<div class="mb-3">
									<label class="form-label">Palavra-passe</label>
									<input type="password" name="password" class="form-control" placeholder="palavra-passe" required/>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div class="form-check m-0">
										<input class="form-check-input" type="checkbox" value="" id="rememberPassword" />
										<label class="form-check-label" for="rememberPassword">Manter logado</label>
									</div>
									
								</div>
								<div class="d-grid py-3 mt-4">
									<button type="submit" class="btn btn-lg btn-primary">
										Entrar
									</button>
								</div>
								<div class="text-center pt-4">
									<span>Não tenho um registro?</span>
									<a href="signup.php" class="text-blue text-decoration-underline ms-2">
										Criar conta</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Container end -->
	</body>

</html>