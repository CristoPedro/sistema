<?php 
date_default_timezone_set('Africa/Luanda');

 // Verificar se o usuário está logado
 if (!isset($_SESSION['id'])) {
     header("Location: login.php");
     exit();
 }

 // Conexão com o banco de dados
 $conn = new mysqli("localhost", "root", "", "publicacao");


 // Verificar a conexão
 if ($conn->connect_error) {
     die("Erro de conexão: " . $conn->connect_error);
 }
?>	
    <!-- App header starts -->
    <div class="app-header d-flex align-items-center">

<!-- Toggle buttons start -->
<div class="d-flex">
    <button class="btn btn-primary me-2 toggle-sidebar" id="toggle-sidebar">
        <i class="bi bi-chevron-left fs-5"></i>
    </button>
    <button class="btn btn-primary me-2 pin-sidebar" id="pin-sidebar">
        <i class="bi bi-chevron-left fs-5"></i>
    </button>
</div>
<!-- Toggle buttons end -->

<!-- App brand sm start -->
<div class="app-brand-sm d-md-none d-sm-block">
    <a href="index.html">
        <img src="assets/images/logo-sm.svg" class="logo" alt="Bootstrap Gallery">
    </a>
</div>
<!-- App brand sm end -->

<!-- App header actions start -->
<div class="header-actions">
    <div class="d-lg-block d-none me-2">

        <!-- Search container start -->
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" />
            <button class="btn btn-outline-primary" type="button">
                <i class="bi bi-search fs-5"></i>
            </button>
        </div>
        <!-- Search container end -->

    </div>
    <?php
  require_once "function_tempo.php";

?>

<div class="dropdown ms-3">
    <a class="dropdown-toggle d-flex p-2 py-3" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-2 lh-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end shadow">
        <?php 
        // Recuperar as notificações para o usuário atual
        $user_id = $_SESSION['id']; // ou qualquer outra forma de identificar o usuário atual

        $sql = "SELECT n.*, u.username, u.photo FROM notificacoes n 
                INNER JOIN ratings l ON n.post_id = l.post_id
                INNER JOIN usuarios u ON l.user_id = u.id
                WHERE n.user_id = ? AND l.user_id != ? ORDER BY timestamp DESC LIMIT 4";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $user_id); // Ajustado para "ii" para indicar dois parâmetros inteiros
        $stmt->execute();
        $result = $stmt->get_result();

        // Contar o número de notificações
        $num_notifications = $result->num_rows;

        // Exibir as notificações
        if ($num_notifications > 0) {
            echo "<div class='notification-badge'><span>$num_notifications</span></div>";
            while ($row = $result->fetch_assoc()) {
                $unreadClass = $row['lido'] ? '' : 'unread-notification';
                echo "<a href='publicacao.php?id=" . $row['post_id'] . "' class='notification-item' data-id='" . $row['id'] . "'>";
                
                if($row["type"] == "like") {
                    echo '
                    <div class="dropdown-item ' . $unreadClass . '">
                    <div class="d-flex py-2">
                        <img src="upload/'. $row["photo"].'" class="img-4x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h5 class="mb-1 fw-semibold">'. $row["username"].'</h5>
                            <p class="mb-2">Gostou da sua Publicação</p>
                            <p class="small m-0 text-primary">'. $row["timestamp"].'</p>
                            <p class="small m-0 text-primary">'. contarTempo($row["timestamp"]).'</p>
                        </div>
                    </div>
                </div>';
                } else {
                    echo '
                    <div class="dropdown-item ' . $unreadClass . '">
                    <div class="d-flex py-2">
                        <img src="upload/'. $row["photo"].'" class="img-4x me-3 rounded-3" alt="Admin Theme" />
                        <div class="m-0">
                            <h5 class="mb-1 fw-semibold">'. $row["username"].'</h5>
                            <p class="mb-2">Não gosta da Publicação</p>
                            <p class="small m-0 text-primary">'. $row["timestamp"].'</p>
                            <p class="small m-0 text-primary">'. contarTempo($row["timestamp"]).'</p>
                        </div>
                    </div>
                </div>';
                }
                echo '</a>';
            }
        } else {
            echo '
            <div class="dropdown-item">
            <div class="d-flex py-2">
                Sem notificação por agora
                <div class="m-0">
                </div>
            </div>
        </div>';
        }
        // Fechar a conexão e liberar os recursos
        ?>
        <div class="border-top py-2 px-3 text-end">
            <a href="javascript:void(0)">Ver todas</a>
        </div>
    </div>
</div>

<style>
.notification-badge {
    position: relative;
    display: inline-block;
    margin-right: 10px;
    left: 250px;
}

.notification-item {
    text-decoration: none;
}

.notification-badge span {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 14px;
}

.unread-notification {
    background-color: rgba(0, 0, 255, 0.2); /* azul transparente */
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.notification-item').on('click', function(event) {
        event.preventDefault();
        var notificationId = $(this).data('id');
        var notificationUrl = $(this).attr('href');
        $.ajax({
            url: 'marcar_como_lida.php',
            type: 'POST',
            data: { id: notificationId },
            success: function(response) {
                if (response == 'success') {
                    // Remover a classe de notificação não lida
                    $(event.currentTarget).find('.dropdown-item').removeClass('unread-notification');
                    // Reduzir o número de notificações
                    var badge = $('.notification-badge span');
                    var count = parseInt(badge.text()) - 1;
                    badge.text(count);
                    if (count == 0) {
                        badge.hide();
                    }
                    // Redirecionar para a publicação
                    window.location.href = notificationUrl;
                }
            }
        });
    });
});
</script>

    <div class="dropdown ms-3">
        <?php
         $user_sql = "SELECT username, photo FROM usuarios WHERE id = $user_id";
         $user_result = $conn->query($user_sql);
         $user_row = $user_result->fetch_assoc();
         $stmt->close();
        $conn->close();
        ?>
        <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
            href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            echo '<span class="d-none d-md-block me-2">'. $user_row["username"]. '</span>';
           echo ' <img src="upload/' . $user_row["photo"] . '" class="rounded-circle img-3x" alt="Bootstrap Gallery" />';
            ?>
        </a>
        <div class="dropdown-menu dropdown-menu-end shadow">
            <a class="dropdown-item d-flex align-items-center" href="perfil_user.php"><i
                    class="bi bi-person fs-4 me-2"></i>Perfil</a>
            <a class="dropdown-item d-flex align-items-center" href="settings.html"><i
                    class="bi bi-gear fs-4 me-2"></i>definições de conta</a>
            <a class="dropdown-item d-flex align-items-center" href="sair.php"><i
                    class="bi bi-escape fs-4 me-2"></i>Terminar sessão</a>
        </div>
    </div>
</div>
<!-- App header actions end -->

</div>

