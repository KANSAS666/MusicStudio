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
    // Защита от SQL-инъекций: используйте подготовленные запросы
    $contractID = $conn->real_escape_string($_POST["contractID"]);
    
    $sql = "UPDATE Contracts SET Status = 1 WHERE ID_Contract = $contractID";
    $result = $conn->query($sql);
    if ($result !== TRUE)
    {
        echo "error of changing status";
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
