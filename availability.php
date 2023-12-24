<?php
// Подключение к базе данных
include("db.php");

if (isset($_POST["startDate"]) && isset($_POST["endDate"])) {
    $start_date = $_POST["startDate"];
    $end_date = $_POST["endDate"];

    // Выполните SQL-запрос для получения свободных комнат и оборудования
    $sql = "Ваш SQL-запрос здесь"; // Замените на ваш SQL-запрос

    // Выполнение запроса
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<h2>Свободные комнаты:</h2>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>Комната ID: " . $row["ID_Room"] . "</li>";
            }
            echo "</ul>";

            // Отобразите свободное оборудование здесь, аналогично свободным комнатам
        } else {
            echo "Нет свободных комнат и оборудования в указанный период времени.";
        }
    } else {
        echo "Произошла ошибка при выполнении SQL-запроса: " . $conn->error;
    }
} else {
    echo "Неверные параметры запроса.";
}
?>