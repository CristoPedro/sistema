<script src="jquery.min.js"></script>
<?php
  require_once "function_tempo.php";

date_default_timezone_set('Africa/Luanda');
  // Conexão com o banco de dados
  $conn = new mysqli("localhost", "root", "", "publicacao");

 if(session_status() == PHP_SESSION_NONE) {
    session_start();
 }

  // Verificar a conexão
  if ($conn->connect_error) {
      die("Erro de conexão: " . $conn->connect_error);
  }

  //definir constantes
  //definir constantes
  define("ITENS_POR_PAGINA", 12);

  // consulta para obter o número total de intes
  $sql_total = "SELECT COUNT(*) AS total FROM publica_incendio";
  $result_total = $conn->query($sql_total);
  $row_total = $result_total->fetch_assoc();

  $total_itens = $row_total["total"]; 
  //------------------------------------------------------
  //Calcular o numero total de paginas
  $total_paginas = ceil($total_itens / ITENS_POR_PAGINA);

  if(isset($_GET['pagina'])){
    // se a pagina foi definida na url guarde na sessão

    $_SESSION['pagina_atual'] = $_GET['pagina'];
  }else if(isset($_SESSION['pagina_atual'])){
    // se a pagina não foi definida na URL, mas existe na sessão, use-a
    $_GET['pagina'] =  $_SESSION['pagina_atual'];
  }else {
    $_GET['pagina'] = 1;
  }
  //Obter o número de paginas atual da URL
  $pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

  // calcular o deslocamento
  $offset = ($pagina_atual -1) * ITENS_POR_PAGINA;
  //------------------------------------------------------
  
  $user_id = $_SESSION['id'];
  //------------------------------------------------------
 // Consulta SQL para obter todos os incêndios de forma aleatória
 $sql = "SELECT id, location, cidade, detalhes, tempo_publicacao, foto_publica, idusuario FROM publica_incendio ORDER BY tempo_publicacao desc Limit $offset, " . ITENS_POR_PAGINA;

 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
     // Exibir os incêndios
     while($row = $result->fetch_assoc()) {
        $post_id = $row['id'];
        
        /******************likes******************** */
        $likesCount = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) AS likes FROM ratings WHERE post_id = $post_id AND status = 'like'"))['likes'];

        $dislikesCount = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) AS dislikes FROM ratings WHERE post_id = $post_id AND status = 'dislike'"))['dislikes'];

        $status = mysqli_query($conn, "SELECT status FROM ratings WHERE post_id = $post_id AND user_id = $user_id");
        if(mysqli_num_rows($status) > 0) {
            $status = mysqli_fetch_assoc($status)['status'];
        }else {
            $status = 0;
        }
        /************************************** */
        
        $user_ids = $row["idusuario"];
         $tempoDecorrido = contarTempo(($row["tempo_publicacao"]));
         // Obter o nome de usuário e a foto do usuário que publicou o incêndio
         $user_sql = "SELECT username, photo FROM usuarios WHERE id = $user_ids";
         $user_result = $conn->query($user_sql);
         if($user_result->num_rows > 0) {
             $user_row = $user_result->fetch_assoc();
             // Exibir a caixa de incêndio com estilo
              
         
 
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
         $textoResumo = resumirTexto($texto, 20);
         echo '<div id="texto_'. $post_id . '_resumido">' . $textoResumo;
          if(strlen($texto) > 20){
             echo '<a href= "#" class="ver-mais"  onclick="mostrarTex(\'texto_'. $post_id . '\'); return false;"> Ver mais</a>';
          }
          echo "</div>";
          echo '<p id="texto_' . $post_id . '_completo" style="display: none;">' . htmlspecialchars($row['detalhes']) . '</p>';
     

         
      
       
             echo '<img src="pb/' . $row["foto_publica"] . '" class="tt" alt="Incêndio" >';
         echo "
         <div class='mb-3'>
             <span class='badge t bg-danger'>". $row["location"]."</span>
            <span class='badge t bg-info'>". $row["cidade"]."</span>
         </div>
         
         ";
         ?>
            <div class="likes-conteudo">
                <button class="like <?php if($status == 'like') echo "selected"; ?>" data-post-id = <?php echo $post_id; ?>>
                          <i class=" bi bi-hand-thumbs-up-fill"></i>
                          <span class="likes_count<?php echo $post_id; ?>" data-count = <?php echo $likesCount; ?>> <?php echo $likesCount;?></span>
                        </button>
                        <button class="dislike <?php if($status == 'dislike') echo "selected"; ?>" data-post-id = <?php echo $post_id; ?>>
                            <i class=" bi bi-hand-thumbs-down-fill"></i>
                            <span class="dislikes_count<?php echo $post_id; ?>" data-count = <?php echo $dislikesCount; ?>> <?php echo $dislikesCount;?></span>
                        </button>
                        <button >
                        <a href="publica_coment.php?id= <?php echo $post_id; ?>">
                                <i class=" bi-chat-right-text-fill"></i>
                                
                                
                            </a>
                        </button>
            </div>
         <?php
     echo "
          
             </div>
             </div>
         </div>
         </div>
 
     ";
 }
}
} else {
     echo "Nenhum incêndio encontrado.";
 }
?>

 <nav aria-label="Page Navigation">
 <ul class="pagination">
 <?php   
 for($i = 1; $i <= $total_paginas; $i++){
   
    echo "
  
        <li class='page-item' id='linkPaginacao'>
            <a class='page-link' href='home.php?pagina=$i' aria-label='Previous'>
                <span aria-hidden='true'>
                $i
                </span>
            </a>
        </li>
       
 
    ";
    
 }
 ?>
    </ul>
</nav>
 <?php
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
		<script src="jquery.min.js"></script>
        <style media="screen">
	
            .selected{
                color: blue;
                outline: 1px solid black;
            }
            .likes-conteudo {
                display: flex;
                width: 100%;
              
            }
            .likes-conteudo button {
                border-style: none;
                margin: 10px;
               border-radius: 50px;
                width: 100%;
            }
            .likes-conteudo button i {
                font-size: 19px;
            }
    </style>

<script>

					
                    $('.like, .dislike').click(function(){
                        var data = {
                            post_id: $(this).data('post-id'),
                            user_id: <?php echo $user_id; ?>,
                            status: $(this).hasClass('like') ? 'like' : 'dislike',
                        };
                        $.ajax({
                            url: 'function.php',
                            type: 'post',
                            data: data,
                            success:function(response) {
                                var post_id = data['post_id'];
                                var likes  = $('.likes_count' + post_id);
                                var likesCount = likes.data('count');
                                var dislikes  = $('.dislikes_count' + post_id);
                                var dislikesCount = dislikes.data('count');
            
                                var likeButton = $(".like[data-post-id=" + post_id + "]");
            
                                var dislikeButton = $(".dislike[data-post-id=" + post_id + "]");
                                if(response == 'newlike') {
                                    likes.html(likesCount + 1);
                                    likeButton.addClass('selected');
                                }else if(response == 'newdislike'){
                                    dislikes.html(dislikesCount - 1);
                                    dislikeButton.addClass('selected');
                                }
                                else if(response == 'changetolike'){
                                    likes.html(parseInt($('.likes_count' + post_id).text()) + 1);
                                    dislikes.html(parseInt($('.dislikes_count' + post_id).text()) - 1);
                                    likeButton.addClass('selected'); 
                                    dislikeButton.removeClass('selected'); 
                                }
                                else if(response == 'changetodislike'){
                                    likes.html(parseInt($('.likes_count' + post_id).text()) - 1);
                                    dislikes.html(parseInt($('.dislikes_count' + post_id).text()) + 1);
                                    likeButton.removeClass('selected'); 
                                    dislikeButton.addClass('selected'); 
                                }
                                else if(response == "deletelike"){
                                    likes.html(parseInt($('.likes_count' + post_id).text()) - 1);
                                    likeButton.removeClass('selected'); 
                                }
                                else if(response == "deletedislike"){
                                    dislikes.html(parseInt($('.dislikes_count' + post_id).text()) - 1);
                                    dislikeButton.removeClass('selected'); 
                                }
                            }
                        });
                    });

                    
 </script>            