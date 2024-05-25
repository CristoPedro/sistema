<?php 
date_default_timezone_set('Africa/Luanda');

 
 session_start();
// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");

require_once "function_tempo.php";

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
 // Verificar se o usuário está logado
 if (!isset($_SESSION['id'])) {
     header("Location: login.php");
     exit();
 }

 
 $user_id = $_SESSION['id'];

 // Consultar mensagens

//  $sql_msg = "SELECT mensagem FROM mensagens_enviadas WHERE id_usuarios = $user_id";
//  $result_msg = $conn->query($sql_msg);

//  if($result->num_rows > 0) {
// 	//exibir mensagens

// 	$row = $result->fetch_assoc();

// 	$mensagem_usuarios = $row["mensagem"];

// 	echo "<p>Mensagem: $mensagem_usuarios </p>";
//  }else {
// 	echo "Sem nenhuma mensagem enviada no corpo de bombeiros";
//  }
//  $conn->close();

 $sql = "SELECT * FROM usuarios WHERE id = '$user_id' " ;
    $result = $conn->query($sql);
	$rows = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Principal</title>

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

		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />
		<style>
		.box-publica {
				margin-top: 10px;
			}
			.usuarios {
				margin-left: 10px;
				margin-bottom: 10px;

			}
			
			.ver-mais {
				color: #5e5ee74e;
				cursor: pointer;
				font-size: 12px;
				margin-left: 10px;
				text-decoration: none;
			}
			.ver-mais:hover {
				color: green;
			}
			.usuarios span {
				margin-left: 5px;
			}
			.icones {
				margin-top: 10px;
				
			}
			.descricao {
				margin: 8px;
			}
			.span {
				margin-left: 10px;
				
			}
			.sispi {
				display: flex;
				
			}
            .tt {
                height: 150px;
                width: 409.5px;
            }
            .coluna {
                display: flex;
            }
			@media only screen and (max-width: 1176px) {
				
			
		}
			@media only screen and (max-width: 1586px) {
				.tt {
					width: 100%;
				}
				.col-ms-4{
			 	padding: 0px;
			}
			.card {
				width: 100%;
				margin: 0px;
			}
		}
			@media only screen and (max-width: 505px) {
				.tt {
					width: 100%;
				}
				.col-ms-4{
			 	padding: 0px;
			}
			.card {
				width: 100%;
				margin: 0px;
			}
		}
		@media only screen and (max-width: 375px) {
			.tt {
				width: 100%;
			}
			
			}
           
		</style>
	</head>

	<body>
		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">

				<!-- Sidebar wrapper start -->
				<nav id="sidebar" class="sidebar-wrapper">

					<!-- App brand starts -->
					<div class="app-brand px-3 py-3 d-flex align-items-center">
						<a href="index.html">
							<img src="../image/icones/icones2/logo_transparent.png" width="100%"  alt="Sistema de Publicação de incêndios" />
						</a>
					</div>
					<!-- App brand ends -->

					
					<!-- Sidebar profile ends -->

					<!-- Sidebar menu starts -->
					<div class="sidebarMenuScroll">
						<ul class="sidebar-menu">
						
						
							<li class="treeview">
								<a href="#!">
									<i class="bi bi-columns-gap"></i>
									<span class="menu-text">Meu interece</span>
								</a>
								<ul class="treeview-menu">
									
									<li>
										<a href="home.php">Pagina principal</a>
									</li>
									<li>
										<a href="area_publica.php">Publicar incêndio</a>
									</li>
									
								</ul>
							</li>
							
						
							<li>
								<a href="#">
									<i class="bi bi-border-all"></i>
									<span class="menu-text">Saber mais</span>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="bi bi-check-circle"></i>
									<span class="menu-text">Posts Concluído</span>
								</a>
							</li>
							<li class="active current-page">
								<a href="#">
									<i class="bi bi-wallet2"></i>
									<span class="menu-text">Enviar um pedido</span>
								</a>
							</li>
							<li class="treeview">
								<a href="#!">
									
									<i class="bi bi-gear"></i>
									<span class="menu-text">Definições</span>
								</a>
								<ul class="treeview-menu">
									
									<li>
										<a href="#">Configurações do site</a>
									</li>
									
									
								</ul>
							</li>
							<li>
								<a href="#"  data-bs-toggle="modal"
										data-bs-target="#exampleModalFullscreen">
									<i class="bi bi-person-square"></i>
									<span class="menu-text" >Editar Perfil do usuário</span>
								</a>
							</li>
							<li class="treeview">
								<a href="#!">
									<i class="bi bi-code-square"></i>
									<span class="menu-text">Terminar</span>
								</a>
								<ul class="treeview-menu">
									<li>
										<a href="sair.php">Sair do sistema</a>
									</li>
								</ul>
							</li>
					
							<li>
								<a href="#">
									<i class="bi bi-pin-map"></i>
									<span class="menu-text">Localização</span>
								</a>
							</li>
						
							<li>
								<a href="maintenance.html">
									<i class="bi bi-exclamation-octagon"></i>
									<span class="menu-text">Termos e condições</span>
								</a>
							</li>
							
						</ul>
					</div>
					<!-- Sidebar menu ends -->

				</nav>
				<!-- Sidebar wrapper end -->

			
				<!-- App container starts -->
				<div class="app-container">

				<?php  include('top.php');?>
                
                    <div class="app-hero-header">
						<h5 class="fw-light">Bem-vindo ao seu perfil</h5>
						<h5 class="fw-light">Olá,  <?php echo $user_row['username']?> </h5>
						
					</div>
					<!-- App Hero header ends -->

<!-- App body ends -->	<script>
					 function mostrarTex(id){
						//console.log("pedro");
						var elementoResumido = document.getElementById(id + "_resumido");
						var elementoCompleto = document.getElementById(id + "_completo");

						elementoResumido.style.display = "none";

						elementoCompleto.style.display = "block";
						
					 }
					</script>
				<!-- App body starts -->
				<div class="app-body">

<!-- Row start -->


<div class="row">
<?php

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "publicacao");


// Verificar a conexão
if ($conn->connect_error) {
die("Erro de conexão: " . $conn->connect_error);
}

// Consulta SQL para obter as publicações do usuário
$user_id = $_SESSION['id'];
$sql = "SELECT id, location, cidade, detalhes, tempo_publicacao, foto_publica FROM publica_incendio WHERE idusuario = $user_id ORDER BY tempo_publicacao desc";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// Exibir as publicações
	while($row = $result->fetch_assoc()) {

		$tempoDecorrido = contarTempo(($row["tempo_publicacao"]));
		// Obter o nome de usuário e a foto do usuário que publicou o incêndio
	  
		$user_sql = "SELECT username, photo FROM usuarios WHERE id = $user_id";
		$user_result = $conn->query($user_sql);
		if ($user_result->num_rows > 0) {
			$user_row = $user_result->fetch_assoc();

			$idp = $row['id'];
            

			echo '<div class="col-lg-4 col-sm-6 col-12">';
			echo '<div class="card shadow mb-4 rounded-5">';
			echo '<div class="card-body">';
			echo '<div class="d-flex align-items-center flex-column">';
			echo '<div class="mb-3">';
			echo '<img src="upload/' . $user_row["photo"] . '"  class="img-6x rounded-circle" alt="Foto do Usuário">';
			echo '</div>';
			echo '<h5 class="mb-3">' . $user_row["username"]. '</h5>';
			echo '<p class="time">'. $tempoDecorrido.'</p>';
			$texto = $row["detalhes"];
			$textoResumo = resumirTexto($texto, 20) ;
			echo '<div id="texto_'. $idp . '_resumido">' . $textoResumo;
			 if(strlen($texto) > 20){
				echo '<a href= "#" class="ver-mais"  onclick="mostrarTex(\'texto_'. $idp . '\'); return false;"> Ver mais</a>';
			 }
			 echo "</div>";
			 echo '<p id="texto_' . $idp . '_completo" style="display: none;">' . htmlspecialchars($row['detalhes']) . '</p>';
		

			
         
          
				echo '<img src="pb/' . $row["foto_publica"] . '" class="tt" alt="Incêndio" >';
			echo "
			<div class='mb-3'>
			    <span class='badge icones bg-danger'>". $row["location"]."</span>
			   <span class='badge icones bg-info'>". $row["cidade"]."</span>
			</div>
			";
		echo "
				</div>
				</div>
			</div>
			</div>
	
		";
    }
}
} else {
echo "Você ainda não Publicou nada.";
}


// Fechar a conexão
$conn->close();



/********************************************* */

/**
 * Resume um texto
 * 
 * @param string $texto texto para resumir
 * @param int $limite limite predefinido ou quantidade de caracteres
 * @param string $continue continuar opcional -> O que deve ser exibido ao final do texto
 * @return string -> retornara o texto todo resumido   
 */
function resumirTexto(string $texto, int $limite, string $continue = '...'): string
{
    $TextoLimpo = trim(strip_tags($texto));

    if (mb_strlen($TextoLimpo) <= $limite) {
        return $TextoLimpo;
    }

    $resumirTexto = mb_substr($TextoLimpo, 0, mb_strrpos(mb_substr($TextoLimpo, 0, $limite), ''));

	



    return $resumirTexto.$continue;
}
/********************************************* */
?>


</div>
</div>
<!-- App body ends -->

<!-- App footer start -->
<div class="app-footer">
    <span>© SISPI -> Sistema de Publicação de incêndios</span>
    <a href="envia.php">click</a>
					</div>
					<!-- App footer end -->

				</div>
				<!-- App container ends -->

			</div>
			<!-- Main container end -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Overlay Scroll JS -->
		<!-- Modal Fullscreen -->
	
										<!-- Modal Fullscreen -->
										<div class="modal fade" id="exampleModalFullscreen" tabindex="-1"
											aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
											<div class="modal-dialog modal-fullscreen">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title h4" id="exampleModalFullscreenLabel">
															Editar Perfil do Usuário
														</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
														
	<!-- Container start -->
    <div class="container">
		
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-sm-6 col-12">
					<form method="post" action="edit_profile.php" enctype="multipart/form-data"  class="my-5" >
						<div class="border border-dark rounded-2 p-4 mt-5">
							<div class="login-form">
								<a href="index.html" class="mb-4 d-flex">
									<img src="../image/icones/icones2/logo_transparent.png" width="150px"  alt="Sistema de publicação de incêndios" />
								</a>
							
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
										<input type="text" name="username" value="<?php echo $rows['username']; ?>" class="form-control" id="validationCustom01" required/>
										
										<div class="valid-feedback">Obrigatorio!</div>
									</div>
								</div>
								<div class="mb-3">
									<div class="was-validated">
										<label for="validationCustom02" class="form-label">Seu e-mail</label>
										<input type="email" value="<?php echo $rows['email']; ?>" name="email" class="form-control" id="validationCustom02" required/>
  										 
										<div class="invalid-feedback">
											Precisamos de um email válido.
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label for="foto">
										
										<img class="rounded-circle img-3x" src="upload/<?php echo $rows["photo"]?>" alt="">
									</label>
									<input type="file" name="photo" id="foto" style="display: none;">
								</div>
								<div class="mb-3">
									<label for="form-control">
										Palavra-passe
									</label>
									<input type="password" id="inputpassword" name="password"  class="form-control" />
									<br>
   									<span onclick="ver()" class="btn btn-primary">
										ver
							</span>

								</div>
							
								<div class="d-grid py-3 mt-4">
									<input type="hidden" name="id" value="<?php echo $rows['id']?>" >
									<input type="submit" name="Enviar_dados" value="Atualizar dados"  class="btn btn-lg btn-primary">
										

								</div>
								
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Container end -->
													</div>
													
												</div>
											</div>
										</div>
		<!-- Overlay Scroll JS -->
		<script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
		<script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>
		<script>
			function ver() {
				let pass = document.getElementById("inputpassword");

				if(pass.type == "password"){
					pass.type = "text";
				}else{
					pass.type = "text";
				}
			}
		</script>
	</body>

</html>