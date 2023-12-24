<?php
include("admin.php");
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MusicStudio";

$conn = new mysqli($servername, $username, $password, $dbname);

?>

  
<!-- <div style="margin-top: 100px;" >
<div class="row">

    <form method="POST" action="" id="form"> 
    <h4 style="margin-bottom: 10px; margin-left: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Сортировать по фамилии</h4>
        <div class="form-group">
            <input type="text" name="search_term" class="form-control" placeholder="Введите фамилию" style="margin-left: 10px; width: 20%;">
        </div>
        <button type="submit" name="search" class="btn btn-success search-btn" style="margin-top: 10px; margin-left: 10px;">Искать</button>
        <button type="submit" name="show_all" class="btn btn-success show-all-btn" style="margin-top: 10px;">Показать всех</button>
    </form>

</div>
</div> -->



<div style="margin-top: 100px;">
<div class="row"> 

    <form method="POST" action="" id="form" class="col-md-4"> 
    <h4 style="margin-bottom: 10px; margin-left: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Сортировать по фамилии</h4>
        <div class="form-group">
            <input type="text" name="search_term" class="form-control" placeholder="Введите фамилию" style="margin-left: 10px; width: 72%;">
        </div>
        <button type="submit" name="search" class="btn btn-success search-btn" style="margin-top: 10px; margin-left: 10px;">Искать</button>
        <button type="submit" name="show_all" class="btn btn-success show-all-btn" style="margin-top: 10px;">Показать всех</button>
    </form>
    <form action="" method="post" class="col-md-4" id="formSortByDate">
            <div class="form-group">
            <h4 style="margin-bottom: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Сортировать по дате</h4>
                <select name="sortBy" id="sortBy" class="form-control" style="width: 58%">
                    <option value="day">День</option>
                    <option value="week">Неделя</option>
                    <option value="month">Месяц</option>
                </select>
            </div>
            <button type="submit" name="sortByDate" class="btn btn-success search-btn" style="margin-top: 10px;">Выбрать</button>
      </form>
</div>
</div>





<?php
$first = 0;
$kol = 10;
$page = 1;

if (isset($_GET['page'])){
    $page = $_GET['page'];
}else $page = 1;

$first = ($page * $kol) - $kol;

$sql = "SELECT COUNT(*) FROM Contracts WHERE ID_Service = 2";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result); //
$total = $row[0]; //
$str_pag = ceil($total/$kol);


echo '<nav aria-label="Page navigation example" style="margin-top: 10px; margin-left: 10px;">
    <ul class="pagination">';

// Создание ссылки "Предыдущая" (Previous)
if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Назад</span>
        </a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&laquo;</span></li>';
}

// Создание ссылок для каждой страницы
for ($i = 1; $i <= $str_pag; $i++){
    if ($i == $page) {
        echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
    }
}

// Создание ссылки "Следующая" (Next)
if ($page < $str_pag) {
    echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Следующая</span>
        </a></li>';
} else {
    echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&raquo;</span></li>';
}

echo '</ul>
  </nav>';


$sql = "SELECT Contracts.ID_Contract, StartDate, EndDate, Services.Nomination, Clients.Lastname, Clients.Firstname, Clients.Fathername, GeneralCost
    FROM Contracts
    INNER JOIN Services ON Contracts.ID_Service = Services.ID_Service
    INNER JOIN Clients ON Contracts.ID_Client = Clients.ID_Client
    WHERE Contracts.Status = 0 AND Services.ID_Service = 2";

if (isset($_POST['search'])) {
    $search_term = $conn->real_escape_string($_POST['search_term']);

    $sql = "SELECT Contracts.ID_Contract, StartDate, EndDate, Services.Nomination, Clients.Lastname, Clients.Firstname, Clients.Fathername, GeneralCost
    FROM Contracts
    INNER JOIN Services ON Contracts.ID_Service = Services.ID_Service
    INNER JOIN Clients ON Contracts.ID_Client = Clients.ID_Client
    WHERE Contracts.Status = 0 AND Services.ID_Service = 2 AND Clients.Lastname LIKE '%$search_term%'";
}

if (isset($_POST['sortByDate'])) {
  $sortBy = $_POST['sortBy'];

  // Получение текущей даты
  $currentDate = date('Y-m-d');

  if ($sortBy === 'day') {
      // Выборка по дню
      $sql .= " AND DATE(StartDate) = '$currentDate'";
  } elseif ($sortBy === 'week') {
      // Выборка по неделе
      // $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($currentDate)));
      // $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($currentDate)));
      $startOfWeek = date('Y-m-d'); 
      $endOfWeek = date('Y-m-d', strtotime('+7 days')); 
      $sql .= " AND DATE(StartDate) BETWEEN '$startOfWeek' AND '$endOfWeek'";
  } elseif ($sortBy === 'month') {
      // Выборка по месяцу
      // $startOfMonth = date('Y-m-01', strtotime($currentDate));
      // $endOfMonth = date('Y-m-t', strtotime($currentDate));
      $startOfMonth = date('Y-m-d'); // Получаем текущую дату
      $endOfMonth = date('Y-m-d', strtotime('+30 days')); 
      $sql .= " AND DATE(StartDate) BETWEEN '$startOfMonth' AND '$endOfMonth'";
  }
}

$sql .= " LIMIT $first, $kol";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div style='margin-left: 10px; margin-right: 10px;'><table class='table table-sm table-bordered'>   
    <tr class='table-success'>
      <th class='table-success'>Номер договора</th>
      <th class='table-success'>Дата начала</th>
      <th class='table-success'>Дата окончания</th>
      <th class='table-success'>Клиент</th>
      <th class='table-success'>Оборудование</th>
      <th class='table-success'>Общая сумма</th>
      <th class='table-success'></th>
      <th class='table-success'></th>
    </tr>";

    //class='container mt-3'

    while ($row = $result->fetch_assoc()) {
        $contractID = $row['ID_Contract'];
        $startDate = $row['StartDate'];
        $endDate = $row['EndDate'];
        $clientName = $row['Lastname'] . ' ' . $row['Firstname'] . ' ' . $row['Fathername'];

        $equipmentList = "";
        $sqlEquipment = "SELECT MusicEquipment.Nomination
            FROM SelectedEquipment
            INNER JOIN MusicEquipment ON SelectedEquipment.ID_Equipment = MusicEquipment.ID_Equipment
            WHERE SelectedEquipment.ID_Contract = $contractID";
        $resultEquipment = $conn->query($sqlEquipment);
        if ($resultEquipment->num_rows > 0) {
            while ($equipmentRow = $resultEquipment->fetch_assoc()) {
                $equipmentList .= $equipmentRow['Nomination'] . ', ';
            }
            $equipmentList = rtrim($equipmentList, ', ');
        } else {
            $equipmentList = "Нет выбранного оборудования";
        }

        $totalCost = $row['GeneralCost'];

        echo "<tr class='table-success'>";
        echo "<td>$contractID</td>";
        echo "<td>$startDate</td>";
        echo "<td>$endDate</td>";
        echo "<td>$clientName</td>";
        echo "<td>$equipmentList</td>";
        echo "<td>$totalCost</td>";
        echo "<td><button onclick=\"changeStatus($contractID)\" class='btn btn-success'>Завершить репетицию</button></td>";
        echo "<td><button onclick=\"deleteContract($contractID)\" class='btn btn-danger'>Отменить репетицию</button></td>";
        echo "</tr>";
        echo "</div>";
    }
    
} else {
    echo "<tr><td colspan='7'>В данный момент нет репетиций</td></tr>";
}
?>


<script>
function changeStatus(contractID) {
  if (confirm("Вы уверены, что хотите изменить статус договора?")) {
    $.ajax({
      type: "POST",
      url: "adminChangeStatus.php",
      data: { contractID: contractID },
      success: function(response) {
        if (response === "success") {
          alert("Статус договора успешно изменен.");
          location.reload();
        } else {
          alert("Произошла ошибка при изменении статуса договора.");
        }
      }
    });
  }
}
</script>

<script>
function deleteContract(contractID) {
  if (confirm("Вы уверены, что хотите отменить запись?")) {
    $.ajax({
  type: "POST",
  url: "deleteContract.php",
  data: { contractID: contractID },
  success: function(response) {
    if (response === "success") {
      alert("Запись успешно удалена!");
      location.reload();
    } else {
      alert("Произошла ошибка при отмене записи.");
    }
  },
  error: function(jqXHR, textStatus, errorThrown) {
    console.log("AJAX Error: " + textStatus, errorThrown);
  },
  complete: function() {
    // Действия, которые нужно выполнить независимо от успешного или неуспешного запроса
  }
});
  }
}
</script>

<script>
if (typeof(Storage) !== "undefined") {
    document.addEventListener("DOMContentLoaded", function() {

        var savedServiceValue = localStorage.getItem("selectedServiceOption");
        if (savedServiceValue) {
            document.getElementById("sortBy").value = savedServiceValue;
        }
    });

    document.getElementById("formSortByDate").addEventListener("submit", function(event) {

        var selectedServiceOption = document.getElementById("sortBy").value;
        localStorage.setItem("selectedServiceOption", selectedServiceOption);
    });
} else {
    alert("localStorage не поддерживается вашим браузером.");
}
</script>

