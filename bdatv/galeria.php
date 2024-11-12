<!DOCTYPE html>
<html>
<head>
<style>
  /* Reset básico */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* Cabeçalho da galeria */
.titulo {
    text-align: center;
    padding: 20px;
    color: #333;
    border-bottom: 2px solid #ddd;
    margin-bottom: 20px;
}

.titulo h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #444;
}

.titulo a.btn {
    margin-top: 15px;
    padding: 10px 20px;
    font-size: 1rem;
    color: #fff;
    background-color: #007bff;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.titulo a.btn:hover {
    background-color: #0056b3;
}

/* Layout da galeria */
.galery_row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.galery_column {
    position: relative;
    width: 250px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.galery_column:hover {
    transform: translateY(-10px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
}

/* Estilo das imagens */
.galery_column img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Conteúdo da imagem */
.galery_column h5 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    padding: 15px 10px 5px 10px;
    text-align: center;
}

.galery_column p {
    font-size: 0.9rem;
    color: #666;
    padding: 0 10px 15px 10px;
    text-align: center;
}

/* Modal de exibição de imagem */
.modal-content img {
    border-radius: 8px;
}

.modal-header .close {
    font-size: 1.5rem;
}
</style>
</head>
<body>
    <div class="titulo">
        <h1>Melhores Itens para levar ao ENEM 2024
        </h1>
    </div>
<a href="inserir.php" class="btn btn-primary">Inserir Nova Imagem</a>

    <?php
    // Conectar ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Galeria";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Buscar imagens da tabela POST
    $sql = "SELECT Titulo, Path_Imagem, Descricao FROM POST";
    $result = $conn->query($sql);

    $n_col = 3; // Número de colunas
    $contador = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($contador % $n_col == 0) echo '<div class="galery_row">'; // Início de uma linha
            echo '<div class="galery_column">';
            echo '<img src="' . $row["Path_Imagem"] . '" style="width: 100%" />';
            echo '<h5>' . $row["Titulo"] . '</h5>';
            echo '<p>' . $row["Descricao"] . '</p>';
            echo '</div>';
            $contador++;
            if ($contador % $n_col == 0) echo '</div>'; // Fim da linha
        }
        if ($contador % $n_col != 0) echo '</div>'; // Fecha a última linha
    } else {
        echo "<p>Nenhuma imagem encontrada.</p>";
    }

    $conn->close();
    ?>
</body>
</html>