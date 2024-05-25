
<?php
date_default_timezone_set('Africa/Luanda');

$conn = new mysqli("localhost","root","","publicacao");

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
    $cidade = $_POST['cidade'];


     // Validar o campo username
   
    if (empty($_POST['location'])) {
        $em = "Preencha a localização do incêndio!";
		header("Location: index.php?error=$em#animo");
    } else {
        $location = limpar_dados($_POST['location']);
      

		if(is_numeric($location)){
			$em = "Especifique bem sua localização isso é um número";
			header("Location: index.php?error=$em#animo");
		}
    }

    if(empty($_POST['detalhes'])){
        $em = "Preencha os detalhes do incêndio para sabermos melhor.";
        header("Location: index.php?error=$em#animo");
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
            $pasta = "incendios_aninimos/";
            $temporario = $_FILES['foto_publica']['tmp_name'];
            $novoNome = uniqid().".$extensao";

             if(move_uploaded_file($temporario, $pasta.$novoNome)):
               // Validar os dados (neste exemplo, vamos supor que todos os campos são obrigatórios)
			
        
        // E então inserir os dados no banco de dados, lembrando-se de usar prepared statements para evitar injeção SQL
		 // Hash da senha
		 
		  	else:
				  $em = "Erro ao fazer o upload";
				header("Location: index.php?error=$em#animo");

			  endif;
		  else:
			 $em = "Ficheiro inválido (tem que ser: .jpeg, .png, .gif, .jpg)";
			header("Location: index.php?error=$em#animo");

		  endif;
 
    }

	if (isset($novoNome)) {


		 // Preparar e executar a consulta SQL
         $stmt = $conn->prepare("INSERT INTO incendio_anonimo (cidade, location,tempo_publica,foto_incendio, detalhes) VALUES (?, ?, Now(), ?, ?)");
         $stmt->bind_param("ssss", $cidade , $location, $novoNome , $detalhes);
		 
		 if ($stmt->execute()) {
			$sm = "A sua publicação foi postada com sucesso, podes acessar a pagina principal";
			header("Location: index.php?success=$sm#animo");
     		exit;
		 } else {
			$sm = "Deu erro ao publicar conta";
			

			header("Location: area_publica.php?error=$sm#animo");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }else {
		
		 // Preparar e executar a consulta SQL
     $stmt = $conn->prepare("INSERT INTO incendio_anonimo (cidade, location,tempo_publica, detalhes) VALUES (?, ?, Now(), ?)");
     $stmt->bind_param("sss", $cidade , $location , $detalhes);
		 
		 if ($stmt->execute()) {
			$sm = "A sua publicação anónima foi postada o quartel de bombeiros já recebeu";
			header("Location: index.php?success=$sm#animo");
     		exit;
		 } else {
			$sm = "Deu erro publicar: " . $stmt->error;
			

			header("Location: index.php?error=$sm#animo");

		 }
		 
		 // Fechar a declaração e a conexão
		 $stmt->close();
		 $conn->close();
   }
    
 
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>SISPI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css">
  <script src="css/buscar.js"></script>
  <link rel="shortcut icon" href="image/icones/logo.png" type="image/x-icon">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
  <style>
    #foto {
  display: none;
}

.postanimo {
  background-color: rgba(11, 26, 234, 0.289);
  color: white;
  cursor: pointer;
  font-size: 19px;
  border-style: none;
}
.postanimo:hover {
  background-color: green;
}
.about .image1 {
  width: 90%;
  height: 450px;
}
@media only screen and (max-width: 768px) {
  .about .image1 {
    width: 100%;
  }

}

  </style>
</head>

<body>
  <header class="header" id="navigation-menu">
    <div class="container">
      <nav style="position: relative;">
        <a href="#" class="logo"> <img src="image/icones/icones2/linkedin_banner_image_1.png" alt=""> </a>
        <ul class="nav-menu">
          <li>
            <a href="#home" class="nav-link">Inicio</a>
          </li>
          <li>
            <a href="#about" class="nav-link">Sobre</a>
          </li>
          <li>
            <a href="#animo" class="nav-link">Publicação anonima</a>
          </li>
          <li>
            <a href="#restaurant" class="nav-link  ">Agencias</a>
          </li>
          <li>
            <a href="#gallary" class="nav-link">Relacionados</a>
          </li>
        </ul>
        <div class="hamburger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </div>
  </header>


  <script>
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    hamburger.addEventListener("click", mobileMenu);

    function mobileMenu() {
      hamburger.classList.toggle("active");
      navMenu.classList.toggle("active");
    }
    const navLink = document.querySelectorAll(".nav-link");

    navLink.forEach((n) => n.addEventListener("click", closeMenu));

    function closeMenu() {
      hamburger.classList.remove("active");
      navMenu.classList.remove("active");
    }
  </script>

  <section class="home" id="home">
    <div class="head_container">
      <div class="box">
        <div class="text">
          <h1>SEJA BEM-VINDO</h1>
          <p>Ajude a salvar vidas, publique um incêndio aqui neste site, faça o cadastro de usuarios e ajude-nos a protejer sua cidade contra incêndio ocorridos no setor do país, obrigado por acessar a este site e boa sorte.</p>
          <button id="open-modal" >Publicar</button>
        </div>
        <div class="image">
          <img src="image/banner-1.png" class="slide">
        </div>
        <div class="image_item">
          <img src="image/fire_5.jpg" class="slide active" onclick="img('image/fire_5.jpg')">
          <img src="image/fire_12.jpeg" class="slide" onclick="img('image/fire_12.jpeg')">
          <img src="image/fire_7.jpg" class="slide" onclick="img('image/fire_7.jpg')">
          <img src="image/fire_8.jpg" class="slide" onclick="img('image/fire_8.jpg')">
        </div>
      </div>
    </div>
  </section>

  <script>
    function img(anything) {
      document.querySelector('.slide').src = anything;
    }

    function change(change) {
      const line = document.querySelector('.image');
      line.style.background = change;
    }

    
  </script>



  <section class="book">
    <div class="container flex">
     
      <div class="buscar-box">
        <div class="lupa-buscar">
            <i class="bi bi-search"></i>
        </div><!--lupa-buscar-->

        <div class="input-buscar">
            <input type="text" name="" id="" placeholder="Faça uma busca">
        </div><!--input-buscar-->

        <div class="btn-fechar">
            <i class="bi bi-x-circle"></i>
        </div><!--btn-fechar-->
    </div><!--buscar-box-->

    <script src="buscar.js"></script>
    </div>
  </section>

  <section class="about top" id="about">
    <div class="container flex">
      <div class="left">
        <div class="img">
          <img src="image/icones/icones2/youtube_profile_image.png" class="image1">
      
        </div>
      </div>
      <div class="right">
        <div class="heading">
          <h5>NOSSOS OBJETIVOS E COMPROMISSOS PARA CONTIGO!</h5>
          <h2>Sobre o site.</h2>
          <p> Olá caro usuarios, mais uma vez seja bem vindo ao site de publicar incêndios, neste site você podera publicar incêndio e essa mesma publicação chegará à estação de bombeiros em tempo real, tem como objetivo ajudar a protejer residências, vidas de cidadãos Angolano contra incêndios.
          </p>
          <p>Este problema vêm assustando a sociedade Angolana em geral, encontramos uma uma forma de sulucionar seus problemas de uma vez, com essa ferramenta suas vidas estaram seguras pois o sistema funciona 24/24 🌗🌗🔥</p>
          <button class="btn1">Saber Mais</button>
        </div>
      </div>
    </div>
  </section>

  <section class="wrapper top" id="animo">
    <div class="container">
   
      <div class="text">
      <?php if(isset($_GET['error'])) { ?>
								<div class="erro">
								<?php echo htmlspecialchars($_GET['error']);?>
								</div>
								<?php } ?>
                          <?php if (isset($_GET['success'])) { ?>
								<div class="sucesso">
								<?php echo htmlspecialchars($_GET['success']);?>
								</div>
								<?php } ?>
        <div class="publicar">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div>
              <label class="form-label">Informe sua localizado 🟢</label>
               <input type="text" require name="location" placeholder="Sua localização">
            </div>
            <div>
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
            <div>
               <textarea name="detalhes" require width="100%" rows="7" id=""></textarea>
            </div>
            <div>
              <label for="foto">
                <img src="image/clip.png" class="upload" width="100px" alt="">
              </label>
               <input type="file"   name="foto_publica" id="foto">
            </div>
            <div>
             <input type="submit" class="postanimo"  value="Publicar anonimamente">
                    </div>
          </form>
      </div>
    </div>
  </section>
 
  <section class="room top" id="room">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading">
          <h5>INCÊNDIOS PUBLICADOS RECENTEMENTE</h5>
          <h2>Publicação de incêndio no SISPI..</h2>
        </div>
        <div class="button">
          <button class="btn1">VISUALIZAR TODOS</button>
        </div>
      </div>

      <div class="content grid" id="incendios">
      <?php
        include "dados_novos.php";
      ?>
      </div>
    </div>
  </section>
  <script>
						 function atualizar() {
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function (){
								if(this.readyState == 4 && this.status == 200) {
									document.querySelector('#incendios').innerHTML = this.responseText;
								}
							};
							xhttp.open("GET", "dados_novos.php", true);
							xhttp.send();
						 }

						 setInterval(atualizar, 2000);
					</script>
  <section class="wrapper wrapper2 top">
    <div class="container">
      <div class="text">
        <div class="heading">
          <h5>CURIOSIDADES ...</h5>
          <h2>Você Sabia que?</h2>
        </div>

        <div class="para">
          <p>Atualmente em Angola a cidade de Luanda é a cidade com mais casos de incêndio , neste caso, no setor do país , Luanda tem apresentado nos ultimos tempos um indice muito elevado de caso de incêndio</p>
          <div class="box flex">
            <div class="img  ">
              <img src="image/fire_20.jpeg" alt="">
            </div>
            <div class="name">
              <h5>EMISSOR</h5>
              <h5>EQUIPA DE BOMBEIROS</h5>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <section class="restaurant top" id="restaurant">
    <div class="container flex departamento">
      <div class="left">
        <img src="image/fire_5.jpg" alt="">
      </div>
      <div class="right">
        <div class="text">
          <h2>Departamento de Bomebeiros</h2>
          <p> Equipa de bomberios sempre estará la para ti não se preocupes.</p>
        </div>
        <div class="accordionWrapper">
          <div class="accordionItem open">
            <h2 class="accordionItemHeading">Lema dos Bombeiros.</h2>
            <div class="accordionItemContent"> 
              <p>Um lema comum dos bombeiros é: "Coragem, Dedicação e Sacrificio". Este lema reflete o espirito de bravura, compromisso e serviço que os bombeiros demonstram ao enfrentar situações pergosas para proteger vidas e propriedades.
              </p>
            </div>
          </div>

          <div class="accordionItem close">
            <h2 class="accordionItemHeading">Onde ficamos</h2>
            <div class="accordionItemContent">
              <p>O departamento oficial dos bombeiros de Angola na cidade de Luanda concretamente na Chicala.
              </p>
            </div>
          </div>

          <div class="accordionItem close">
            <h2 class="accordionItemHeading">Objetivos</h2>
            <div class="accordionItemContent">
              <p>Os bombeiros tenhem como objetivo protejer a vida e a propriedade de um cidadão, isso exige muito sacrifício e coragem conforme o lema diz.
              </p>
            </div>
          </div>

          <div class="accordionItem close">
            <h2 class="accordionItemHeading">Mais</h2>
            <div class="accordionItemContent">
              <p>
                ...
              </p>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>


  <script>
    var accItem = document.getElementsByClassName('accordionItem');
    var accHD = document.getElementsByClassName('accordionItemHeading');
    for (i = 0; i < accHD.length; i++) {
      accHD[i].addEventListener('click', toggleItem, false);
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;
      for (i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
      }
      if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
      }
    }
  </script>


  <section class="gallary top" id="gallary">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading">
          <h5>Geleria de imagens</h5>
          <h2>A qui estão algumas imagens.
          </h2>
        </div>
        <div class="button">
          <button class="btn1">Visualizar Galeria</button>
        </div>
      </div>

      <div class="owl-carousel owl-theme">
        <div class="item">
          <img src="image/icones/youtube_profile_image.png" alt="">

        </div>
        <div class="item">
          <img src="image/icones/icones2/youtube_profile_image.png" alt="">

        </div>
        <div class="item">
          <img src="image/icones/icones2/youtube_profile_image.png" alt="">
        </div>
        <div class="item">
          <img src="image/icones/youtube_profile_image.png" alt="">

        </div>
        <div class="item">
          <img src="image/icones/youtube_profile_image.png" alt="">
        </div>
        <div class="item">
          <img src="image/icones/icones2/youtube_profile_image.png" alt="">
        </div>
       
      </div>
    </div>
  </section>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script>
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: false,
      navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    })
  </script>

   <div class="conteudo">
     <div id="fade" class="hide"></div>
     <div id="modal" class="hide">
       <div class="modal-header">
         <h2>Conectar-se</h2>
         <button class="buttons" id="close-modal">X</button>
        </div>
        <div class="modal-body">
         
          <a href="sisai/signup.php"><button class="buttons2" id="close-modal">Cadastrar-se</button></a>
          <a href="sisai/login.php"><button style="background-color: blue;" class="buttons2" id="close-modal">Iniciar sessão</button></a>
          
       </div>
     </div>
   </div>

  <section class="map top">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57848.02622893053!2d13.23376657408338!3d-8.811182584162571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a51f3cb2c3dcc39%3A0x8ed4786700cbdb91!2sQuartel%20de%20Bombeiros%20da%20Chicala!5e0!3m2!1spt-PT!2sao!4v1714879085700!5m2!1spt-PT!2sao" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </section>

  <footer>
    <div class="container grid mtop">
      <div class="box">
        <img src="image/icones/logo_transparent.png" width="100px" />
        <p> Sistema de Publicação de Incêndio, uma inovação nacional para protejer, sua vida</p>
        <p>Publique incêndios e salve vidas</p>
       
      </div>

      <div class="box">
        <h3>Parceiros</h3>

        <ul>
          <li>Instituto Aguia Branca</li>
          <li>Unitel</li>
          <li>Bombeiros de Angola</li>
          <li>Mais</li>
        </ul>
      </div>

      <div class="box">
        <h3>Sobre os Desenvolvidores</h3>
        <ul>
          <li>Sobre nós!</li>
          <li>Quem somos</li>
          <li>Onde nos encontrar</li>
          <li>Privacidade do site</li>
          <li>Termos e condições</li>
        </ul>
      </div>

      <div class="box">
        <h3>Contacte-nos</h3>
        <ul>

          <li>Luanda/Angola/Viana</li>

          <li> <i class="far fa-envelope"></i>
            pedrocristo49@gmail.com</li>
          <br>
          <li>
            <i class="far fa-phone-alt"></i>
            931194961
          </li>
          <li><i class="far fa-phone-alt"></i>
            929006333</li>
          <br>
          <li><i class="far fa-comments"></i>
            24/24 disponivel para serviços</li>
        </ul>

      </div>
    </div>
  </footer>
  <script src="scripts.js"></script>
  <link rel="stylesheet" href="css/css.css">
</body>

</html>