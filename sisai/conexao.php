<?php

date_default_timezone_set('Africa/Luanda');
  // Conexão com o banco de dados
  $conn = new mysqli("localhost", "root", "", "publicacao");

  session_start();

  // Verificar a conexão
  if ($conn->connect_error) {
      die("Erro de conexão: " . $conn->connect_error);
  }
