<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formularioprueba";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$action = $_POST['action'];

if ($action === 'guardar') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $sexo = $_POST['sexo'];
    $email = $_POST['email'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $activo = $_POST['activo'];

    if ($id) {
        $sql = "UPDATE usuarios SET 
                    nombre='$nombre', apellido='$apellido', sexo='$sexo', 
                    email='$email', fecha_nacimiento='$fecha_nacimiento', activo=$activo 
                WHERE id=$id";
    } else {
        $sql = "INSERT INTO usuarios (nombre, apellido, sexo, email, fecha_nacimiento, activo) 
                VALUES ('$nombre', '$apellido', '$sexo', '$email', '$fecha_nacimiento', $activo)";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => $id ? "Usuario actualizado correctamente." : "Usuario registrado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
} elseif ($action === 'listar') {
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);
    $usuarios = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    echo json_encode($usuarios);
} elseif ($action === 'obtener') {
    $id = $_POST['id'];
    $sql = "SELECT * FROM usuarios WHERE id=$id";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_assoc());
} elseif ($action === 'eliminar') {
    $id = $_POST['id'];
    $sql = "DELETE FROM usuarios WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Usuario eliminado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
}

$conn->close();
?>
