<?php
include("admin.php");
include("db.php");
?>
<style>
    .form-group label {
        color: #04303E;
        display: inline-block;
        border-radius: 5px;
        padding: 2px;
        background: #ADD8E6;
        margin-top: 5px;
        margin-bottom: 5px;
    }

</style>

<link rel="stylesheet" href="css/menu.css">
<!-- <div class="container d-flex align-items-center" style="margin-top: 100px;">
<form action="" method="post" id="contract" class="mx-auto"> -->
<div class="container text-center mx-auto">
<div class="row">
    <div class="col-md-6 mx-auto">
    <form action="" method="post" id="contract">
    <h4 style="margin-bottom: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Создание договора</h4>
    <div class="form-group">
    <label for="startDate">Дата и время начала:</label>
    <input type="datetime-local" name="startDate" id="startDate" value="<?=$_POST["startDate"]?>" class="form-control">
    </div>

        <div class="form-group">
    <label for="endDate">Дата и время окончания:</label>
    <input type="datetime-local" name="endDate" id="endDate" value="<?=$_POST["endDate"]?>" class="form-control">
        </div>

    <div class="form-group">
    <label for="clientID">Номер паспорта клиента:</label>
    <input type="number" name="clientID" id="clientID" value="<?=$_POST["clientID"]?>" class="form-control">
    </div>

    <div class="form-group">
    <button type="submit" name="choice" id="choice" class="btn btn-success" style="margin-top: 10px;">Выбрать</button> 
    </div>
    

    <div class="form-group">
    <label for="serviceID">Название услуги:</label>
    <select name="serviceID" id="serviceID" class="form-control">
      <option value="repetition">Аренда помещения</option>
      <option value="recording">Звукозапись</option>
    </select> 
    </div>

    <div class="form-group">
    <label for="room">Свободные залы:</label>
    <select name="room" id="room" class="form-control" style="margin-bottom: 10px">
        <?php
        if (isset($_POST["choice"]) || isset($_POST["sumOfContract"])) {
            $start_date = $_POST["startDate"];
            $end_date = $_POST["endDate"];
            $sql = "SELECT R.ID_Room, R.RoomNumber
            FROM Rooms R
            WHERE NOT EXISTS (
                SELECT 1
                FROM Contracts C
                WHERE R.ID_Room = C.ID_Room
                AND (
                    ('$start_date' >= C.StartDate AND '$start_date' < C.EndDate) OR
                    ('$end_date' > C.StartDate AND '$end_date' <= C.EndDate) OR
                    ('$start_date' <= C.StartDate AND '$end_date' >= C.EndDate)
                )
            )";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['ID_Room'] . "'>" . $row['RoomNumber'] . "</option>";
                }
            } else {
                echo "<option value=''>Нет свободных залов</option>";
                
            }
        }
        ?>
        
    </select>
    </div>
    <div class="form-group">
  <select id="equipment" class="selectpicker form-control" multiple aria-label="Дополнительное оборудование" data-none-selected-text="Дополнительное оборудование" data-size="10" name="equipment[]">
    <?php
    if (isset($_POST["choice"]) || isset($_POST["sumOfContract"])) {
      $start_date = $_POST["startDate"];
      $end_date = $_POST["endDate"];
      $sql = "SELECT DISTINCT ME.ID_Equipment, ME.Nomination, ME.CostPerHour
              FROM MusicEquipment ME
              LEFT JOIN SelectedEquipment SE ON ME.ID_Equipment = SE.ID_Equipment
              WHERE ME.ID_Equipment NOT IN (
                SELECT SE.ID_Equipment
                FROM Contracts C
                INNER JOIN SelectedEquipment SE ON C.ID_Contract = SE.ID_Contract
                WHERE
                  (? >= C.StartDate AND ? < C.EndDate) OR
                  (? > C.StartDate AND ? <= C.EndDate) OR
                  (? <= C.StartDate AND ? >= C.EndDate))";

      $stmt = $conn->prepare($sql);
      // Используйте 's' для всех параметров, так как они все строки
      $stmt->bind_param("ssssss", $start_date, $start_date, $end_date, $end_date, $start_date, $end_date);
      $stmt->execute();
      $result = $stmt->get_result();

      // Вывод чекбоксов на основе данных из базы
      if ($result->num_rows > 0) {
        while ($equipment = $result->fetch_assoc()) {
          echo '<option value="' . $equipment['ID_Equipment'] . '"> ' . $equipment['Nomination'] . ' (' . $equipment['CostPerHour'] . ' руб)</option>';
        }
      } else {
        echo '<option value="Нет доступного оборудования.">"Нет дополнительного оборудования"</option>';
      }
    }
    ?>
  </select>
</div>
      
        <div class="form-group">
      <button type="submit" name="sumOfContract" class="btn btn-success" style="margin-top: 10px;">Рассчитать общую сумму</button> 
        </div>

        <div class="form-group">
        <label for="price">Общая сумма:</label>
		<input type="number" name="price" id="price" readonly class="form-control">
        </div>
  <input type="submit" name="submit" value="Создать договор" class="btn btn-success" style="margin-top: 10px;">
  <input type="hidden" name="selectedRoom" id="selectedRoom" value="">
  
</form>
</div>  
</div>   <!-- -->
</div>   <!-- -->



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Restore selected equipment options
    var selectedEquipment = localStorage.getItem("selectedEquipment");
    if (selectedEquipment) {
        var equipmentSelect = document.getElementById("equipment");
        var selectedOptions = selectedEquipment.split(",");
        for (var i = 0; i < selectedOptions.length; i++) {
            equipmentSelect.querySelector("option[value='" + selectedOptions[i] + "']").selected = true;
        }
    }
});

document.getElementById("contract").addEventListener("submit", function (event) {
    // Save selected equipment options to local storage
    var selectedEquipment = Array.from(document.getElementById("equipment").selectedOptions).map(function (option) {
        return option.value;
    });
    localStorage.setItem("selectedEquipment", selectedEquipment);
});
</script>

<?php
if (isset($_POST['sumOfContract'])) {

    $startDate = strtotime($_POST['startDate']);
    $endDate = strtotime($_POST['endDate']);
    $selectedService = $_POST['serviceID'];
    $serviceID = 0;

    if ($selectedService === "recording")
    {
      $serviceID = 1; // recording
    }
    else
    {
      $serviceID = 2; // repetition
    }

    // Извлекаем цену услуги из базы данных
    $sql = "SELECT CostPerHour FROM Services WHERE ID_Service = $serviceID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $servicePrice = floatval($row["CostPerHour"]);
    } else {
        echo "Ошибка выбора цены";
    }

    $equipment = isset($_POST["equipment"]) ? $_POST["equipment"] : [];

    $hours = ($endDate - $startDate) / 3600;

    $room = $_POST['room'];
    $sql = "SELECT TarifPerHour FROM Rooms WHERE ID_Room  = $room";
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Извлекаем результат запроса
    $roomTarif = $row["TarifPerHour"]; // Получаем значение из результата
} else {
    echo "Ошибка при выполнении запроса к базе данных";
}

    $totalPrice = $hours * $roomTarif;
    if (!empty($equipment)) {
        $sql = "SELECT SUM(CostPerHour) AS equipmentPrice FROM MusicEquipment WHERE ID_Equipment IN (" . implode(",", $equipment) . ")";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $equipmentPrice = $row["equipmentPrice"];
            $totalPrice += $equipmentPrice * $hours;
        }
    }

    echo "<script>document.getElementById('price').value = $totalPrice;</script>";
 }
?>
<?php
if (isset($_POST['submit'])) 
{
    
    $selectedService = $_POST['serviceID'];
    $serviceID = 0;

    if ($selectedService === "recording")
    {
      $serviceID = 1; // recording
    }
    else
    {
      $serviceID = 2; // repetition
    }

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $clientPassport = $_POST['clientID'];

    $clientIDSelect = "SELECT ID_Client FROM Clients WHERE passport = $clientPassport";
$clientIDResult = $conn->query($clientIDSelect);

if ($clientIDResult) {
    $clientIDRow = $clientIDResult->fetch_assoc();
    $clientID = $clientIDRow['ID_Client'];
} else {
    echo "Ошибка при выборе клиента: " . $conn->error;
}

    $room = $_POST['room'];
    $contractCost = $_POST['price'];

    $sql = "INSERT INTO `Contracts`(`StartDate`, `EndDate`, `GeneralCost`, `ID_Service`, `ID_Client`, `ID_Room`)
     VALUES ('$startDate','$endDate',$contractCost,$serviceID,$clientID,$room)";

if ($conn->query($sql) === TRUE) {
    $contractID = $conn->insert_id; 

    if (isset($_POST['equipment'])) {
        $equipmentIDs = $_POST['equipment'];
        echo $equipmentIDs;

        foreach ($equipmentIDs as $equipmentID) {

            $query = "INSERT INTO SelectedEquipment (ID_Contract, ID_Equipment) 
                      VALUES ('$contractID', '$equipmentID')";
            $conn->query($query);
        }
    }

    echo "Договор успешно создан.";
    echo "<script> document.location.href = 'createContract.php'</script>";
} else {
    echo "Ошибка при создании договора: " . $conn->error;
}

}

?>


<script>
if (typeof(Storage) !== "undefined") {
    document.addEventListener("DOMContentLoaded", function() {
        // Восстанавливаем выбранное значение для "Название услуги"
        var savedServiceValue = localStorage.getItem("selectedServiceOption");
        if (savedServiceValue) {
            document.getElementById("serviceID").value = savedServiceValue;
        }

        // Восстанавливаем выбранное значение для "Свободные залы"
        var savedRoomValue = localStorage.getItem("selectedRoomOption");
        if (savedRoomValue) {
            document.getElementById("room").value = savedRoomValue;
        }
    });

    document.getElementById("contract").addEventListener("submit", function(event) {
        // Сохраняем выбранное значение для "Название услуги"
        var selectedServiceOption = document.getElementById("serviceID").value;
        localStorage.setItem("selectedServiceOption", selectedServiceOption);

        // Сохраняем выбранное значение для "Свободные залы"
        var selectedRoomOption = document.getElementById("room").value;
        localStorage.setItem("selectedRoomOption", selectedRoomOption);
    });
} else {
    alert("localStorage не поддерживается вашим браузером.");
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>