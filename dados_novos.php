
<?php
date_default_timezone_set('Africa/Luanda');
// Conexão com o banco de dados
$conn = new mysqli("localhost","root","","publicacao");



// Verificar a conexão
if ($conn->connect_error) {
   die("Erro de conexão: " . $conn->connect_error);
}
// Consulta SQL para obter todos os incêndios de forma aleatória
$sql = "SELECT id, location, cidade, detalhes, tempo_publicacao, foto_publica FROM publica_incendio ORDER BY tempo_publicacao desc LIMIT 9";

$result = $conn->query($sql); 

if ($result->num_rows > 0) {
    // Exibir os incêndios
    while($row = $result->fetch_assoc()) {
      $tempoDecorrido = contarTempo(($row["tempo_publicacao"]));
      echo '
        <div class="box">
        <div class="imgs">
        <p>'. $row["detalhes"].'</p>
        <img src="sisai/pb/' . $row["foto_publica"] . '" class="tt" alt="Incêndio" >
        </div>
        <div class="text">
          <h3>Publicação de incêndio no SISPI..  <span class="cidade"> <span>|</span>'. $row["cidade"].' </span></h3>
          <p> <span>tempo</span><br> <span> '. $row["tempo_publicacao"].'</span> </p>
          <p> <span>Atualização</span><br> <span> '. $tempoDecorrido .'</span> </p>
          <p > <span>Local do incêndio</span><span style="color: green; font-weght: bold; font-size: 18px;"> '. $row["location"] .'</span> </p>
        </div>
      </div>
      
      ';
    }

} else {
    echo "Nenhum incêndio encontrado.";
}



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