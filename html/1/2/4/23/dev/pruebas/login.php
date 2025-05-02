<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servidor = "localhost";
    $usuario_db = "newuser";
    $clave = "password";
    $db = "soberbia";

    $user = $_POST['usuario'];
    $pass = $_POST['password'];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$db", $usuario_db, $clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $consulta = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
        $result = $conexion->query($consulta);

        if ($result && $result->rowCount() > 0) {
            $usuario_info = $result->fetch(PDO::FETCH_ASSOC);
            $_SESSION['usuario'] = $usuario_info;
            header("Location:comentarios.php");
        } 
        else {
            echo "Credenciales incorrectas";
        }

    } catch (PDOException $exception) {
        echo "Fallo en la conexión: " . $exception->getMessage();
    }

    $conexion = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        <label for="usuario">Usuario:</label> 
        <input type="text" id="usuario" name="usuario">
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>


