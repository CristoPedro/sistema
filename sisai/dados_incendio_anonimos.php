<?php
date_default_timezone_set('Africa/Luanda');
  // Conexão com o banco de dados
  $conn = new mysqli("localhost", "root", "", "publicacao");


  // Verificar a conexão
  if ($conn->connect_error) {
      die("Erro de conexão: " . $conn->connect_error);
  }

 // Consulta SQL para obter todos os incêndios de forma aleatória
 $sql = "SELECT id, cidade, location, tempo_publica, foto_incendio, detalhes FROM incendio_anonimo ORDER BY tempo_publica desc";

 $result = $conn->query($sql);

 if ($result->num_rows > 0) {
     // Exibir os incêndios
     while($row = $result->fetch_assoc()) {
        
         $tempoDecorrido = contarTempo(($row["tempo_publica"]));
         // Obter o nome de usuário e a foto do usuário que publicou o incêndio
         
        
             // Exibir a caixa de incêndio com estilo
              
             $idp = $row['id'];
         
 
         echo '<div class="col-lg-4 col-sm-6 col-12">';
         echo '<div class="card shadow mb-4 rounded-5">';
         echo '<div class="card-body">';
         echo '<div class="d-flex align-items-center flex-column">';
         echo '<div class="mb-3">';
         echo '<img src="../image/noprofil.jpg " class="img-6x rounded-circle" alt="Foto do Usuário">';
         echo '</div>';
         echo '<h5 class="mb-3"> Anónimo</h5>';
         echo '<p class="time">'. $tempoDecorrido.'</p>';
         $texto = $row["detalhes"];
         $textoResumo = resumirTexto($texto, 20);
         echo '<div id="texto_'. $idp . '_resumido">' . $textoResumo;
          if(strlen($texto) > 20){
             echo '<a href= "#" class="ver-mais"  onclick="mostrarTex(\'texto_'. $idp . '\'); return false;"> Ver mais</a>';
          }
          echo "</div>";
          echo '<p id="texto_' . $idp . '_completo" style="display: none;">' . htmlspecialchars($row['detalhes']) . '</p>';
     

         
      
       
          echo '<img src="../incendios_aninimos/' . $row["foto_incendio"] . '" class="tt" alt="Incêndio" >';
         echo "
         <div class='mb-3'>
             <span class='badge t bg-danger'>". $row["location"]."</span>
            <span class='badge t bg-info'>". $row["cidade"]."</span>
         </div>
         ";
     echo "
             </div>
             </div>
         </div>
         </div>
 
     ";

}
} else {
     echo "Nenhum incêndio encontrado.";
 }

 
    // Fechar a conexão
    $conn->close();
    
    /**
     * Conta o tempo decorrido de uma data
     * @param string $data
     * @return string
     */
    function contarTempo(string $data): string
    {
        $agora = strtotime(date('Y-m-d H:i:s'));
        $tempo = strtotime($data);
        $diferenca = $agora - $tempo;
        $segundos = $diferenca;
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);
        
        if ($segundos <= 60) {
            return 'agora';
    } elseif ($minutos <= 60) {
        return $minutos == 1 ? 'há 1 minuto' : 'há ' . $minutos . ' minutos';
    } elseif ($horas <= 24) {
        return $horas == 1 ? 'há 1 hora' : 'há ' . $horas . ' horas';
    } elseif ($dias <= 7) {
        return $dias == 1 ? 'ontem' : 'há ' . $dias . ' dias';
    } elseif ($semanas <= 4) {
        return $dias == 1 ? 'há 1 semana' : 'há ' . $semanas . ' semanas';
    } elseif ($meses <= 12) {
        return $meses == 1 ? 'há 1 mês' : 'há ' . $meses . ' mêses';
    } else {
        return $anos == 1 ? 'há 1 ano' : 'há ' . $anos . ' anos';
    }
}


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