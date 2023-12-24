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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contractID"])) {
    $contractID = $_POST["contractID"];
    $sqlDeleteSelectedEquipment = "DELETE FROM SelectedEquipment WHERE ID_Contract = $contractID";
    if ($conn->query($sqlDeleteSelectedEquipment) === TRUE) {
        $sql = "DELETE FROM Contracts WHERE ID_Contract = $contractID";
        if ($conn->query($sql) !== TRUE) {
            echo "error of deleting contract";
        } else {
            echo "success";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
$conn->close();
?>
