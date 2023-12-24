<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MusicStudio";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idEqp"])) {
    $equipmentId = $conn->real_escape_string($_POST["idEqp"]);
    
    $sql = "DELETE FROM MusicEquipment WHERE ID_Equipment = $equipmentId";
    $result = $conn->query($sql);
    if ($result !== TRUE)
    {
        echo "error of deleting equipment". $conn->error;
    }
    else
    {
        echo "success";
    }
}
else{
    echo "invalid of response";
}
$conn->close();
?>
