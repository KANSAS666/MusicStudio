<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MusicStudio";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $equipmentId = $_POST['id'];
    $sql = "DELETE FROM MusicEquipment WHERE ID_Equipment = $equipmentId";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
} else {
    echo "invalid response";
}
$conn->close();
?>