


<?php

// Este código PHP parece lidar com a exibição dos detalhes de um incêndio, incluindo sua localização em um mapa usando a API do Google Maps. Vou revisá-lo para verificar se há melhorias possíveis:

//     1. **Prevenção de Injeção SQL:** O código atual é vulnerável a ataques de injeção SQL. É recomendável usar declarações preparadas para evitar isso.
//     2. **Validação de Entrada:** Sempre valide e filtre a entrada do usuário antes de usá-la em consultas SQL para evitar ataques.
//     3. **Tratamento de Erros:** Adicionar tratamento de erros robusto, especialmente ao lidar com operações de banco de dados e geocodificação.
//     4. **Segurança da API do Google Maps:** Se estiver usando a API do Google Maps, verifique se as chaves da API estão protegidas e se há restrições adequadas aplicadas.
//     5. **Mensagens de Saída Amigáveis:** Melhore as mensagens de saída para fornecer uma experiência mais amigável ao usuário.
//     6. **Separação de Concerns:** Considere separar a lógica do PHP do HTML usando um sistema de templates ou algum tipo de estrutura MVC.
    
//     Aqui está uma versão modificada do código com algumas dessas melhorias:
// Conectar ao banco de dados
$conexao = new mysqli("localhost", "root", "", "publicacao");

// Verificar a conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Função para evitar injeção SQL
function limparEntrada($entrada) {
    global $conexao;
    return mysqli_real_escape_string($conexao, $entrada);
}

// Verificar se o parâmetro id_incendio está presente na URL e é um número válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_incendio = limparEntrada($_GET['id']);

    // Consultar o banco de dados para obter os detalhes do incêndio
    $sql = "SELECT * FROM publica_incendio WHERE id = $id_incendio";
    $resultado = $conexao->query($sql);

    // Verificar se a consulta retornou resultados
    if ($resultado) {
        if ($resultado->num_rows > 0) {
            // Exibir os detalhes do incêndio
            $incendio = $resultado->fetch_assoc();
            $localizacao = htmlentities($incendio['location']);
            $status = htmlentities($incendio['status']);
            $detalhes = htmlentities($incendio['detalhes']);
            $foto = htmlentities($incendio['foto_publica']);

            echo "<h2>Detalhes do Incêndio</h2>";
            echo "<p>Localização: $localizacao</p>";
            echo "<p>Status: $status</p>";
            echo "<p>Detalhes: $detalhes</p>";
            echo "<p>Foto: <img src='$foto' alt='Foto do Incêndio'></p>";

            // Exibir o mapa com a localização do incêndio
            echo "<h2>Localização no Mapa</h2>";
            echo "<div id='map' style='width: 100%; height: 400px;'></div>";
            echo "<script>
                    function initMap() {
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 12,
                            center: {lat: -23.5505, lng: -46.6333} // Coordenadas de São Paulo, Brasil (exemplo)
                        });
                        var geocoder = new google.maps.Geocoder();
                        var address = '$localizacao'; // Localização do incêndio
                        geocoder.geocode({'address': address}, function(results, status) {
                            if (status === 'OK') {
                                map.setCenter(results[0].geometry.location);
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    title: 'Localização do Incêndio'
                                });
                            } else {
                                alert('Geocode falhou: ' + status);
                            }
                        });
                    }
                </script>";
        } else {
            echo "Nenhum incêndio encontrado com o ID especificado.";
        }
    } else {
        echo "Erro na consulta: " . $conexao->error;
    }
} else {
    echo "ID do incêndio não especificado ou inválido na URL.";
}

// Fechar a conexão com o banco de dados
$conexao->close();

// saEss alterações visam tornar o código mais seguro, robusto e fácil de manter. Certifique-se de substituir "usuario", "senha" e "publicacao" pelos valores reais do seu banco de dados.

/*
Para que este código funcione corretamente, você precisará fazer o seguinte:

1. **Configurar o Banco de Dados:** Certifique-se de que o banco de dados MySQL esteja configurado corretamente com uma tabela chamada `publica_incêndio` contendo os campos necessários (como `id_incendio`, `localization`, `status`, `detalhes` e `foto_publica`).

2. **Substituir as Credenciais do Banco de Dados:** No código, substitua `"localhost"`, `"usuario"`, `"senha"` e `"publicacao"` pelos detalhes de conexão corretos para o seu banco de dados.

3. **Substituir o Caminho da Foto do Incêndio:** Certifique-se de que a coluna `foto_publica` na tabela `publica_incêndio` contenha os caminhos corretos para as fotos dos incêndios. Ou, se preferir, adapte o código para buscar as imagens de outra fonte, como um diretório no servidor.

4. **Configurar a API do Google Maps:** Certifique-se de incluir a biblioteca da API do Google Maps no seu projeto e de que você tenha uma chave de API válida. Se não tiver uma chave, você pode obtê-la no Console do Google Cloud Platform.

5. **Adicionar a Função de Inicialização do Mapa:** No código JavaScript, substitua as coordenadas de exemplo (`{lat: -23.5505, lng: -46.6333}`) pelo centro do mapa que você deseja exibir. Além disso, verifique se o ID do mapa (`'map'`) corresponde ao ID do elemento HTML onde deseja exibir o mapa.

6. **Ajustar a Lógica do Mapa:** Se necessário, ajuste a lógica de inicialização do mapa para atender às suas necessidades específicas, como definir o zoom inicial, estilos do mapa, etc.

7. **Verificar as Permissões de Arquivos:** Certifique-se de que as permissões de arquivo e diretório estão configuradas corretamente para que o servidor da web possa acessar e exibir as fotos dos incêndios, bem como para que o JavaScript possa carregar corretamente.

Depois de realizar esses passos, o código deve ser capaz de conectar-se ao banco de dados, recuperar os detalhes do incêndio, exibir as informações na página da web e mostrar a localização do incêndio em um mapa do Google Maps. Certifique-se de testar exaustivamente para garantir que tudo funcione conforme o esperado.
*/
?>


