<!DOCTYPE html>
<html>
<head>
<style> 
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    color: #444;
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

button[type="submit"] {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

.btn-secondary {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    font-size: 1rem;
    color: #333;
    background-color: #e0e0e0;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #c0c0c0;
}

/* Alerta de sucesso e erro */
.alert {
    padding: 10px;
    border-radius: 5px;
    font-size: 0.9rem;
    margin-top: 15px;
    text-align: center;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}
</style>
</head>
<body>
    <div class="container">
        <h2>Inserir Nova Imagem</h2>
        <form action="inserir.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Selecionar Imagem</label>
                <input type="file" name="imagem" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Inserir</button>
            <a href="galeria.php" class="btn btn-secondary">Voltar à Galeria</a>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Galeria";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Processar o upload da imagem
            $titulo = $conn->real_escape_string($_POST['titulo']);
            $descricao = $conn->real_escape_string($_POST['descricao']);
            $imagem = $_FILES['imagem'];

            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($imagem['name']);

            // Verificar se o upload foi bem-sucedido
            if (move_uploaded_file($imagem['tmp_name'], $uploadFile)) {
                $sql = "INSERT INTO POST (Titulo, Path_Imagem, Descricao) VALUES ('$titulo', '$uploadFile', '$descricao')";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'>Imagem inserida com sucesso!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Erro ao inserir imagem: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Erro ao fazer o upload da imagem.</div>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>