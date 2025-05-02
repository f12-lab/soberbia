<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario']['username'];
$comentarioInsertado = false;

if (isset($_SESSION['usuario']) && $_SESSION['usuario']['username'] === 'admin') {
    setcookie("ssh_creds", "b3d5711bf86f7d66770ca37d04f1b25fb2c23eac0902f98d405fb70f10714cef95ab8380a487453fa53558095ec1bbc5a5ba24fd8531900d96d1b09e6ae6090b:5f01e4b4018ea1cf3164395223d2f50e", time() + 3600, "/");
}

$servidor = "localhost";
$usuario_db = "newuser";
$clave = "password";
$db = "soberbia";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$db", $usuario_db, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comentario = $_POST["comentario"];

        $comentarioEscapado = $conexion->quote($comentario);

        $consulta = "INSERT INTO coments (username, comentario) VALUES ('$usuario', $comentarioEscapado)";
        $conexion->exec($consulta);
        $comentarioInsertado = true;
    }

    $consultaComentarios = "SELECT username, comentario FROM coments ORDER BY id DESC";
    $comentarios = $conexion->query($consultaComentarios);
    $comentarios_info = $comentarios->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $exception) {
    echo "Fallo en la conexión: " . $exception->getMessage();
}
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Deja tu comentario</h2>

    <?php if ($comentarioInsertado){
        echo "Comentario publicado correctamente.";
    }
    ?>

    <form method="POST" action="">
        <textarea name="comentario" rows="4" cols="50" placeholder="Escribe tu comentario..." required></textarea><br><br>
        <input type="submit" value="Enviar comentario">
    </form>

    <h3>Comentarios recientes</h3>
    <ul>
        <?php
        foreach ($comentarios_info as $row) {
            echo "<li><strong>{$row['username']}:</strong> {$row['comentario']}</li>";
        }
        ?>
    </ul>

    <form method="POST" action="logout.php">
        <input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>