<?php
    include("db.php");
    include("accountant.php");
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
    h4{
      margin-bottom: 10px;
      color: #04303E;
      background: #ADD8E6;
      display: inline-block;
      border-radius: 5px;
      padding: 2px;
}
 
</style>

<!-- <div style="margin-top: 100px">
<div class="row about">
<h4 align="center" style="max-width: 200px; margin-left: 700px;">Отчеты</h4>
<form action="" method="post">
<div class="form-group">
<label for="serviceID" style="margin-left: 10px;">Выбор услуги:</label>
    <select name="serviceID" id="serviceID" class="form-control" style="margin-left: 10px; width: 20%;">
      <option value="2" <?php //if(isset($_POST['submit']) && $_POST['serviceID'] == 2) echo "selected"; ?>>Аренда помещения</option>
      <option value="1" <?php //if(isset($_POST['submit']) && $_POST['serviceID'] == 1) echo "selected"; ?>>Запись композиции</option>
    </select> 
    </div>
    <button type="submit" name="submit" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px; margin-left: 10px;">Выбрать</button>

</form>
</div>
<div class="row about">
<form action="" method="post">
<div class="form-group">
<label for="serviceID" style="margin-left: 10px;">Сортировать по дате:</label>
    <select name="serviceID" id="serviceID" class="form-control" style="margin-left: 10px; width: 20%;">
      <option value="day">День</option>
      <option value="month">Месяц</option>
      <option value="year">Год</option>
    </select> 
    </div>
</form>
</div>
</div> -->


<!-- <div class="container" style="margin-top: 100px; margin-right: 700px;">
<h4 align="center" style="max-width: 200px; margin-left: 700px;">Отчеты</h4>
    <div class="row">
        <form action="" method="post" class="col-md-4">
            <div class="form-group">
                <label for="serviceID">Выбор услуги:</label>
                <select name="serviceID" id="serviceID" class="form-control">
                    <option value="2" <?php //if(isset($_POST['submit']) && $_POST['serviceID'] == 2) echo "selected"; ?>>Аренда помещения</option>
                    <option value="1" <?php //if(isset($_POST['submit']) && $_POST['serviceID'] == 1) echo "selected"; ?>>Запись композиции</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px;">Выбрать</button>
        </form>
        <form action="" method="post" class="col-md-4">
            <div class="form-group">
                <label for="sortBy">Сортировать по дате:</label>
                <select name="sortBy" id="sortBy" class="form-control">
                    <option value="day">День</option>
                    <option value="week">Неделя</option>
                    <option value="month">Месяц</option>
                    <option value="year">Год</option>
                </select>
            </div>
        </form>
    </div>
</div> -->


<div class="container" style="margin-top: 100px; margin-right: 700px;">
    <h4 align="center" style="max-width: 200px;  margin-left: 800px">Отчеты</h4>
    <form action="" method="post" class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="serviceID">Выбор услуги:</label>
                <select name="serviceID" id="serviceID" class="form-control">
                    <option value="2" <?php if(isset($_POST['submit']) && $_POST['serviceID'] == 2) echo "selected"; ?>>Аренда помещения</option>
                    <option value="1" <?php if(isset($_POST['submit']) && $_POST['serviceID'] == 1) echo "selected"; ?>>Запись композиции</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px;">Выбрать</button>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="sortBy">Сортировать по дате:</label>
                <select name="sortBy" id="sortBy" class="form-control">
                    <option value="day" <?php if(isset($_POST['submit']) && $_POST['sortBy'] == 'day') echo "selected"; ?>>День</option>
                    <option value="week" <?php if(isset($_POST['submit']) && $_POST['sortBy'] == 'week') echo "selected"; ?>>Неделя</option>
                    <option value="month" <?php if(isset($_POST['submit']) && $_POST['sortBy'] == 'month') echo "selected"; ?>>Месяц</option>
                    <option value="year" <?php if(isset($_POST['submit']) && $_POST['sortBy'] == 'year') echo "selected"; ?>>Год</option>
                </select>
            </div>
        </div>
    </form>
</div>


<?php
    if(isset($_POST['submit']))
    {
        $idService = $_POST["serviceID"];
        $sortByDate = $_POST["sortBy"];
        $currentDate = date('Y-m-d');

        if ($sortByDate === 'day') {

            $reportDate .= " AND DATE(StartDate) = '$currentDate'";
        } elseif ($sortByDate === 'week') {

            $endOfWeek = date('Y-m-d', strtotime('-7 days')); 
            $reportDate .= " AND DATE(StartDate) BETWEEN '$endOfWeek' AND '$currentDate'";
        } elseif ($sortByDate === 'month') {

            $endOfMonth = date('Y-m-d', strtotime('-30 days')); 
            $reportDate .= " AND DATE(StartDate) BETWEEN '$endOfMonth' AND '$currentDate'";
        } elseif ($sortByDate === 'year')
        {
            $endOfYear = date('Y-m-d', strtotime('-365 days')); 
            $reportDate .= " AND DATE(StartDate) BETWEEN '$endOfYear' AND '$currentDate'";
        }
        


        if ($idService == 2)
        {

                $sql = "SELECT Contracts.ID_Contract, StartDate, EndDate, Clients.Lastname, Clients.Firstname, Clients.Fathername, GeneralCost
                FROM Contracts
                INNER JOIN Clients ON Contracts.ID_Client = Clients.ID_Client WHERE Contracts.Status = 1 AND Contracts.ID_Service = 2";
                

                $sql .=$reportDate;
                $result = $conn->query($sql);

                $equipmentCosts = [];

// Запрос для получения стоимости оборудования для каждого договора
$sqlEquipmentCost = "SELECT Contracts.ID_Contract, SUM(MusicEquipment.CostPerHour) AS TotalEquipmentCost
                    FROM Contracts
                    LEFT JOIN SelectedEquipment ON Contracts.ID_Contract = SelectedEquipment.ID_Contract
                    LEFT JOIN MusicEquipment ON SelectedEquipment.ID_Equipment = MusicEquipment.ID_Equipment
                    WHERE Contracts.Status = 1 AND Contracts.ID_Service = 2
                    GROUP BY Contracts.ID_Contract";
$resultEquipmentCost = $conn->query($sqlEquipmentCost);

if ($resultEquipmentCost->num_rows > 0) {
    while ($row = $resultEquipmentCost->fetch_assoc()) {
        $contractID = $row['ID_Contract'];
        $equipmentCost = $row['TotalEquipmentCost'];
        $equipmentCosts[$contractID] = $equipmentCost;
    }
}
                

                    echo "<h4 style='margin-left: 10px;'>Отчет по проведенным репетициям</h4>";
                
                
                    echo "<div style='margin-right: 10px; margin-left: 10px;'><table class='table table-bordered table-sm'>
                     <tr class='table-success'><th>Номер договора</th><th>Дата начала</th>
                     <th>Дата окончания</th>
                    <th >Клиент</th>
                    <th>Дополнительное оборудование</th>
                    <th >Общая стоимость</th>
                    <th >Стоимость услуги</th>
                    <th >Стоимость оборудования</th>";
                    $contractSum = 0;
                    $serviceSum = 0;
                    $equipmentSum = 0;
                
                    while ($row = $result->fetch_assoc()) {
                        $contractID = $row['ID_Contract'];
                        $startDate = $row['StartDate'];
                        $endDate = $row['EndDate'];

                        
                        $hoursStart = strtotime($startDate);
                        $hoursEnd = strtotime($endDate);

                        $hours = ($hoursEnd - $hoursStart) / 3600;
                        $clientName = $row['Lastname'] . ' ' . $row['Firstname']. ' ' . $row['Fathername']; 
                  
                        // Получение выбранного оборудования для договора
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
                         $equipmentCost = isset($equipmentCosts[$contractID]) ? $equipmentCosts[$contractID] * $hours : 0;
                         $serviceCost = $totalCost - $equipmentCost;
                         //$totalCost += $equipmentCost;
                         
                         $serviceSum += $serviceCost; 
                         $equipmentSum += $equipmentCost;
                         $contractSum += $totalCost;
                  
                        echo "<tr class='table-success'>";
                        echo "<td>$contractID</td>";
                        echo "<td>$startDate</td>";
                        echo "<td>$endDate</td>";
                        echo "<td>$clientName</td>";
                        echo "<td>$equipmentList</td>";
                        echo "<td>$totalCost</td>";
                        echo "<td>$serviceCost</td>";
                        echo "<td>$equipmentCost</td>";
                        echo "</tr>";
                      }
                
                    //  echo "<tr>";
                    // echo "<td><b>Итого:</b></td><td></td>
                    // <td><b>$count</b></td><td><b>$sum</b></td>";
                    // echo "</td>";
                    // echo "</table>";
                    echo "<tr class='table-success'>";
                    echo "<td><b>Итого:</b></td><td></td><td></td><td></td><td></td><td><b>$contractSum</b></td>
                    <td><b>$serviceSum</b></td><td><b>$equipmentSum</b></td>";
                    echo "</td>";
                    echo "</table>";
                    echo "</div>";

                
                }
                elseif($idService == 1)
                {
                  $sql = "SELECT Contracts.ID_Contract, StartDate, EndDate, Clients.Lastname, Clients.Firstname, Clients.Fathername, GeneralCost
                FROM Contracts
                INNER JOIN Clients ON Contracts.ID_Client = Clients.ID_Client WHERE Contracts.Status = 1 AND Contracts.ID_Service = 1";
                

                $sql .=$reportDate;
                $result = $conn->query($sql);

                $equipmentCosts = [];

// Запрос для получения стоимости оборудования для каждого договора
$sqlEquipmentCost = "SELECT Contracts.ID_Contract, SUM(MusicEquipment.CostPerHour) AS TotalEquipmentCost
                    FROM Contracts
                    LEFT JOIN SelectedEquipment ON Contracts.ID_Contract = SelectedEquipment.ID_Contract
                    LEFT JOIN MusicEquipment ON SelectedEquipment.ID_Equipment = MusicEquipment.ID_Equipment
                    WHERE Contracts.Status = 1 AND Contracts.ID_Service = 1
                    GROUP BY Contracts.ID_Contract";
$resultEquipmentCost = $conn->query($sqlEquipmentCost);

if ($resultEquipmentCost->num_rows > 0) {
    while ($row = $resultEquipmentCost->fetch_assoc()) {
        $contractID = $row['ID_Contract'];
        $equipmentCost = $row['TotalEquipmentCost'];
        $equipmentCosts[$contractID] = $equipmentCost;
    }
}
                

                    echo "<h4 style='margin-left: 10px;'>Отчет по проведенным звукозаписям</h4>";
                
                
                    echo "<div style='margin-right: 10px; margin-left: 10px;'><table class='table table-bordered table-sm'>
                     <tr class='table-success'><th>Номер договора</th>
                     <th >Дата начала</th>
                     <th >Дата окончания</th>
                    <th >Клиент</th>
                    <th >Дополнительное оборудование</th>
                    <th >Общая стоимость</th>
                    <th >Стоимость услуги</th>
                    <th >Стоимость оборудования</th>";

                    $contractSum = 0;
                    $serviceSum = 0;
                    $equipmentSum = 0;
                
                    while ($row = $result->fetch_assoc()) {
                        $contractID = $row['ID_Contract'];
                        $startDate = $row['StartDate'];
                        $endDate = $row['EndDate'];

                        
                        $hoursStart = strtotime($startDate);
                        $hoursEnd = strtotime($endDate);

                        $hours = ($hoursEnd - $hoursStart) / 3600;
                        $clientName = $row['Lastname'] . ' ' . $row['Firstname']. ' ' . $row['Fathername']; 
                  
                        // Получение выбранного оборудования для договора
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
                         $equipmentCost = isset($equipmentCosts[$contractID]) ? $equipmentCosts[$contractID] * $hours : 0;
                         $serviceCost = $totalCost - $equipmentCost;
                         //$totalCost += $equipmentCost;
                         
                         $serviceSum += $serviceCost; 
                         $equipmentSum += $equipmentCost;
                         $contractSum += $totalCost;
                  
                        echo "<tr class='table-success'>";
                        echo "<td>$contractID</td>";
                        echo "<td>$startDate</td>";
                        echo "<td>$endDate</td>";
                        echo "<td>$clientName</td>";
                        echo "<td>$equipmentList</td>";
                        echo "<td>$totalCost</td>";
                        echo "<td>$serviceCost</td>";
                        echo "<td>$equipmentCost</td>";
                        echo "</tr>";
                      }
                
                    //  echo "<tr>";
                    // echo "<td><b>Итого:</b></td><td></td>
                    // <td><b>$count</b></td><td><b>$sum</b></td>";
                    // echo "</td>";
                    // echo "</table>";
                    echo "<tr class='table-success'>";
                    echo "<td><b>Итого:</b></td><td></td><td></td><td></td><td></td><td><b>$contractSum</b></td>
                    <td><b>$serviceSum</b></td><td><b>$equipmentSum</b></td>";
                    echo "</td>";
                    echo "</table>";
                    echo "</div>";
                }
        }
?>




