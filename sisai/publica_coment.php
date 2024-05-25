<?php 
date_default_timezone_set('Africa/Luanda');

 
 session_start();

 // Verificar se o usuário está logado
 if (!isset($_SESSION['id'])) {
     header("Location: login.php");
     exit();
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
		
		<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
		<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
		<meta property="og:type" content="Website">
		<meta property="og:site_name" content="Bootstrap Gallery">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://user.fontawesome.com/fe459689.js"></script>

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
			#conteudo {
				opacity: 0;
				transition: opacity 1s ease;
			}
			#conteudo.mostrar {
				opacity: 1;
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
            .t {
               margin-top: 10px;
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
						<a href="../index.html">
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
										<a href="area_publica.php">Fazer uma publicação</a>
									</li>
									<li>
										<a href="incendios_anonimos.php">Incêndios Anónimos</a>
									</li>
									
								</ul>
							</li>
							
						
							<li>
								<a href="#">
									<i class="bi bi-border-all"></i>
									<span class="menu-text">Saber mais acerca</span>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="bi bi-check-circle"></i>
									<span class="menu-text">Novas atualizações</span>
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
								<a href="perfil_user.php">
									<i class="bi bi-person-square"></i>
									<span class="menu-text">Perfil usuario</span>
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
								<a href="#">
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
						<h5 class="fw-light">Atualização em tempo real,</h5>
						<h3 class="fw-light mb-5">
							<span>Incêndios Publicados</span> / <span class="menu-text">Localização</span>
						</h3>
					</div>
					
					<script>
						function atribuirEventosDeLikes() {
    $('.like, .dislike').off('click').on('click', function() {
        var data = {
            post_id: $(this).data('post-id'),
            user_id: <?php echo $user_id; ?>,
            status: $(this).hasClass('like') ? 'like' : 'dislike',
        };
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success: function(response) {
                var post_id = data['post_id'];
                var likes = $('.likes_count' + post_id);
                var likesCount = parseInt(likes.data('count'));
                var dislikes = $('.dislikes_count' + post_id);
                var dislikesCount = parseInt(dislikes.data('count'));

                var likeButton = $(".like[data-post-id=" + post_id + "]");
                var dislikeButton = $(".dislike[data-post-id=" + post_id + "]");

                if (response == 'newlike') {
                    likes.html(likesCount + 1).data('count', likesCount + 1);
                    likeButton.addClass('selected');
                } else if (response == 'newdislike') {
                    dislikes.html(dislikesCount + 1).data('count', dislikesCount + 1);
                    dislikeButton.addClass('selected');
                } else if (response == 'changetolike') {
                    likes.html(likesCount + 1).data('count', likesCount + 1);
                    dislikes.html(dislikesCount - 1).data('count', dislikesCount - 1);
                    likeButton.addClass('selected');
                    dislikeButton.removeClass('selected');
                } else if (response == 'changetodislike') {
                    likes.html(likesCount - 1).data('count', likesCount - 1);
                    dislikes.html(dislikesCount + 1).data('count', dislikesCount + 1);
                    likeButton.removeClass('selected');
                    dislikeButton.addClass('selected');
                } else if (response == "deletelike") {
                    likes.html(likesCount - 1).data('count', likesCount - 1);
                    likeButton.removeClass('selected');
                } else if (response == "deletedislike") {
                    dislikes.html(dislikesCount - 1).data('count', dislikesCount - 1);
                    dislikeButton.removeClass('selected');
                }
            }
        });
    });
}

// Chame a função para atribuir os eventos quando a página for carregada
$(document).ready(function() {
    atribuirEventosDeLikes();
});

 
						document.addEventListener("DOMContentLoaded", function(){
							var linksPaginacao = document.querySelectorAll("#linkPaginacao a");

							linksPaginacao.forEach(function(link) {
								link.addEventListener("click", function(event) {
									event.preventDefault();
									var pagina = this.getAttribute("href");
									carragarPagina(pagina);
								});
							});

							// carregar

							function carregarPagina(url) {
								var conteudo = document.getElementById("conteudo");
								conteudo.classList.remove("mostrar");

								setTimeout(function(){
									window.location.href = url;
								}, 500);
							}

							document.getElementById("conteudo").classList.add("mostrar");
						});
						
					 function mostrarTex(id){
						
						//console.log("pedro");
						var elementoResumido = document.getElementById(id + "_resumido");
						var elementoCompleto = document.getElementById(id + "_completo");

						elementoResumido.style.display = "none";

						elementoCompleto.style.display = "block";
						
					 }
					</script>
					<script>
						 function atualizar() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.querySelector('.row').innerHTML = this.responseText;
            
            // Reatribuir eventos de likes e dislikes após atualizar o conteúdo
            atribuirEventosDeLikes();
			
        }
    };
    xhttp.open("GET", "comentando.php", true);
    xhttp.send();
}

setInterval(atualizar, 1000);

					</script>
					<!-- App Hero header ends -->

					<!-- App body starts -->
			<div class="app-body">

					

        <div class="row" id="conteudo">
	<?php

	
		include 'dados_incendio.php';
		
		
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