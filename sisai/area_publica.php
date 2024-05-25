<?php 
date_default_timezone_set('Africa/Luanda');

 
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

 // Função para limpar os dados de entrada
function limpar_dados($dados) {
	global $conn;
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
	$dados = mysqli_escape_string($conn, $dados);
    return $dados;
}

 
// Processamento do formulário de publicação de incêndio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $id = $_SESSION['id'];
    $cidade = $_POST['cidade'];


     // Validar o campo username
   
    if (empty($_POST['location'])) {
        $em = "Preencha a localização do incêndio!";
		header("Location: area_publica.php?error=$em");
    } else {
        $location = limpar_dados($_POST['location']);
      
    }

    if(empty($_POST['detalhes'])){
        $em = "Preencha os detalhes do incêndio para sabermos melhor.";
        header("Location: area_publica.php?error=$em");
    }else {
        $detalhes = limpar_dados($_POST['detalhes']);
    }

    // Preparar e executar a consulta SQL para inserir o incêndio

    if (isset($_FILES['foto_publica'])) {
        // Processar os dados aqui
        
        // Upload da foto de perfil

    

    $formatoPerm = array("png","jpeg","jpg","gif");
    $extensao = pathinfo($_FILES['foto_publica']['name'], PATHINFO_EXTENSION);

         if(in_array($extensao, $formatoPerm)):
            $pasta = "pb/";
            $temporario = $_FILES['foto_publica']['tmp_name'];
            $novoNome = uniqid().".$extensao";

             if(move_uploaded_file($temporario, $pasta.$novoNome)):
               // Validar os dados (neste exemplo, vamos supor que todos os campos são obrigatórios)
			
        
        // E então inserir os dados no banco de dados, lembrando-se de usar prepared statements para evitar injeção SQL
		 // Hash da senha
		 
		  	else:
				  $em = "Erro ao fazer o upload";
				header("Location: area_publica.php?error=$em");

			  endif;
		  else:
			 $em = "Ficheiro inválido (tem que ser: .jpeg, .png, .gif, .jpg)";
			header("Location: area_publica.php?error=$em");

		  endif;
 
    }

	if (isset($novoNome)) {


		 // Preparar e executar a consulta SQL
         $stmt = $conn->prepare("INSERT INTO publica_incendio (idusuario, location, cidade, detalhes, tempo_publicacao, foto_publica) VALUES (?, ?, ?, ?, Now(), ?)");
         $stmt->bind_param("issss", $id, $location, $cidade, $detalhes, $novoNome);
		 
		 if ($stmt->execute()) {
			$sm = "A sua publicação foi postada com sucesso, podes acessar a pagina principal";
			header("Location: area_publica.php?success=$sm");
     		exit;
		 } else {
			$sm = "Deu erro ao publicar conta";
			

			header("Location: area_publica.php?error=$sm");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }else {
		
		 // Preparar e executar a consulta SQL
         $stmt = $conn->prepare("INSERT INTO publica_incendio (idusuario, location, cidade, detalhes, tempo_publicacao) VALUES (?, ?, ?, ?, Now())");
         $stmt->bind_param("isss", $id, $location, $cidade, $detalhes);
		 
		 if ($stmt->execute()) {
			$sm = "A sua publicação foi postada com sucesso, podes acessar a pagina principal $novoNome";
			header("Location: area_publica.php?success=$sm");
     		exit;
		 } else {
			$sm = "Deu erro publicar: " . $stmt->error;
			

			header("Location: area_publica.php?error=$sm");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }
    
 

}
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
			.usuarios span {
				margin-left: 5px;
			}
			.time {
				position: absolute;
				left: 75px;
				top: 40px;
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
                width: 400px;
            }
            .coluna {
                display: flex;
            }
           #foto {
                display: none;
            }
            .upload_image {
                margin: 10px;
                cursor: pointer;
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
							
								</ul>
							</li>
							
						
							<li>
								<a href="#">
									<i class="bi bi-border-all"></i>
									<span class="menu-text">Saber mais</span>
								</a>
							</li>
							<li>
								<a href="subscribers.html">
									<i class="bi bi-check-circle"></i>
									<span class="menu-text">Novas atualizações</span>
								</a>
							</li>
							<li class="active current-page">
								<a href="contacts.html">
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
									<li>
										<a href="perfil_user.php">Configurações de perfil</a>
									</li>
									
								</ul>
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
								<a href="maps.html">
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
						<h5 class="fw-light">Fazer publicação de incêndio</h5>
						<h5 class="fw-light">Olá,  <?php echo $user_row['username']?> </h5>
						
					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
		<div class="app-body">
			<div class="row">
				<div class="col-xl-12">
					<div class="card shadow mb-4">
						<?php if (isset($_GET['error'])) { ?>
							<div class="alert alert-danger" role="alert">
								<?php echo htmlspecialchars($_GET['error']);?>
							</div>
							<?php } ?>
							<?php if (isset($_GET['success'])) { ?>
								<div class="alert alert-success" role="alert">
									<?php echo htmlspecialchars($_GET['success']);?>
								</div>
								<?php } ?>
								<div class="card-header">
									<h5 class="card-title">Publique um incêndio,  <?php echo $user_row['username']?></h5>
								</div>
								<div class="card-body">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="create-invoice-wrapper">
              <!-- Row start -->
                <div class="row">
                 <div class="col-sm-6 col-12">
                  <!-- Row start -->
                 <div class="row">
                    <div class="col-sm-12 col-12">
                  <!-- Form group start -->
                 <div class="mb-3">
                 <label for="customerName" class="form-label">Localização do incêndio 🟢</label>
                      <input type="text" require maxlength="80" name="location" id="customerName" class="form-control" require  placeholder="Informe a localização" />
                  </div>
                            <!-- Form group end -->
                  </div>
             <div class="col-lg-3 col-sm-4 col-12">
                  <div class="mb-3">
               <label class="form-label">Selecione a provincia onde estas localizado 🔴</label>
                   <select class="form-select" require name="cidade">
                 <option value="Luanda">Luanda</option>
                  <option value="Benguela">Benguela</option>
                         <option value="Malange">Malange</option>
                 <option value="Cabinda">Cabinda</option>
                  <option value="Huambo">Huambo</option>
                         <option value="Bengo">Bengo</option>
                 <option value="Cuanza Norte">Cuanza Norte</option>
                  <option value="Cuanza Sul">Cuanza Sul</option>
                         <option value="Caxito">Caxito</option>
                 <option value="Uige">Uíge</option>
                  <option value="Namibe">Namibe</option>
                         <option value="Zaire">Zaire</option>
                 <option value="Moxico">Moxico</option>
                  <option value="Cunene">Cunene</option>
                         <option value="Bie">Bie</option>
                 <option value="Cuando Cubango">Cuando Cubango</option>
                  <option value="Huila">Huila</option>
                         <option value="Lunda Norte">Lunda Norte</option>
                    </select>
               </div>
          </div>
                                                                    
               <div class="col-sm-12 col-12">
                 <!-- Form group start -->
                  <div class="mb-2">
               <label for="msgCustomer" class="form-label">Detalhes do incêndio</label>
                <textarea rows="9" require maxlength="200" name="detalhes" id="msgCustomer" class="form-control"></textarea>
             </div>
               <!-- Form group end -->
                
            </div>

            <label for="foto">
                <img src="../image/clip.png" class="upload_image" width="30px" alt="">
                <span>foto do incêndio (Opcional)</span>
            </label>
                 <input type="file" name="foto_publica" id="foto">
             </div>
                <!-- Row end -->
                 </div>
                 </div>
               <!-- Row end -->
                </div>
                 <input type="submit" class="btn btn-success"  value="Publicar agora">
              </form>

										
				</div>
					</div>
							</div>
						</div>
						<!-- Row end -->
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
		<script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
		<script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>
	</body>

</html>