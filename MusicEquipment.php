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
</style>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<div class="container" style="margin-top: 100px">
<div class="row about">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <form method="POST" action="" id="form" style="left: 5%; top:0%; width: 1wh;">
            <h4 style="margin-bottom: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Новое оборудование</h4>
            <div class="form-group">
        <label for ="Nomination">Наименование оборудования:</label>
        <input type="text" name="Nomination" id="Nomination" required class="form-control"> 
            </div>


            <div class="form-group">
        <label for ="CostPerHour">Стоимость в час:</label>
        <input type="number" name="CostPerHour" id="CostPerHour" required class="form-control"> 
            </div>

		<input type="submit" name="submit" value="Добавить" class="btn btn-success" style="margin-top: 10px;">
        </form>
    </div>
    

    <?php
        if (isset($_POST['submit'])){
            $nomination = $_POST['Nomination'];
            $costPerHour = $_POST['CostPerHour'];
        
            $mysql = "INSERT INTO `MusicEquipment`(`Nomination`, `CostPerHour`) VALUES ('$nomination','$costPerHour')";

            $result=mysqli_query($conn,$mysql);

            if($result == TRUE)
            {
                echo "Данные обновлены!!";
                echo "<script> document.location.href = 'MusicEquipment.php'</script>";
            }
            else{
                 echo "Ошибка";
            }


        }
    ?>
<!-- </div> -->


<!-- </div> -->
    <div class="col-lg-8 col-md-8 col-sm-12 desc">
        <?php
          
          $sql = "SELECT ID_Equipment, Nomination, CostPerHour FROM MusicEquipment";
          $result = mysqli_query($conn, $sql);
          if (!$result) {
            die('Ошибка выполнения запроса: ' . mysqli_error($conn));
          }
         
            echo "<h4 style='margin-bottom: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;'>Список музыкального оборудования</h4>";
            echo "<table class='table table-bordered table-sm'>
            <tr class='table-success'><th>Наименование</th>
            <th>Стоимость в час</th>
            <th></th>";

            while ($myrow=mysqli_fetch_array($result)){
                // $idEqp = $myrow['ID_Equipment'];
                echo "<tr class='table-success'>";
                echo "<td>".$myrow['Nomination']."</td>";
                echo "<td>".$myrow['CostPerHour']."</td>";
                
                // echo "<td>

                // <button type='button' name='edit' value='' class='btn btn-danger' data-toggle='modal' data-target='#myModal'
                //      data-nomination='".$myrow['Nomination']."' data-cost='".$myrow['CostPerHour']."' >
                //         Редактировать
                //     </button>
                //   </td>";
                echo "<td>
                <button type='button' name='edit' value='' class='btn btn-success edit-button' 
                data-toggle='modal' data-target='#myModal' data-nomination='" . $myrow['Nomination'] . "' 
                data-cost='" . $myrow['CostPerHour'] . "'>
                    Редактировать
                </button>
              </td>";
           
            //   echo "<td><button onclick=\"delEqp($idEqp)\">Удалить оборудование</button></td>";



                echo "</tr>";
            }
            echo "</table>"
        ?>
    </div>
</div>
</div>






 <!--  модальноe окнo -->
 <!--  модальноe окнo -->
 <div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <h4 class="modal-title">Редактирование стоимости</h4>
      </div>
      <!-- Основное содержимое модального окна -->
       <div class="modal-body">  
         <form  method="POST"  action="">
      
<?php

echo '<div class="form-group"><label for="nomination">Наименование</label><br><input type="text" id="nomination" name="nomination" readonly class="form-control"></div>';
echo '<div class="form-group"><label for="tarifPerHour">Стоимость в час</label><br><input type="number" id="tarifPerHour" name="tarifPerHour"
 class="form-control"></div>';
?>

</div>
<!-- Футер модального окна -->
<div class="modal-footer">
 <button type="button" class="close btn btn-danger" data-dismiss="modal" 
aria-hidden="true">Отмена</button>
 <button type="submit" name="submitEdit" class="btn btn-success">Изменить</button>
</form>
 </div>
</div>
</div>
 </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> Подключаем jQuery -->
<!-- Вызов модального окна -->
<script>
    $(document).ready(function () {
        $('.edit-button').click(function () {
            var nomination = $(this).data('nomination');
            var tarifPerHour = $(this).data('cost');
            $('#nomination').val(nomination);
            $('#tarifPerHour').val(tarifPerHour);
        });
    });
</script>

<?php
   if (isset($_POST['submitEdit'])) {
    $nomination = $_POST['nomination'];
    $tarifPerHour = $_POST['tarifPerHour'];
    
    // Ваш SQL-запрос для обновления стоимости в час
    $sql = "UPDATE MusicEquipment SET CostPerHour = '$tarifPerHour' WHERE Nomination = '$nomination'";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result === TRUE) {
        echo "Данные обновлены!!";
        echo "<script> document.location.href = 'MusicEquipment.php'</script>";
    } else {
        echo "Ошибка";
    }
}
?>

<!-- <script>
function delEqp(idEqp) {
  if (confirm("Вы уверены, что хотите удалить выбранное оборудование?")) {
    console.log('Удаляется оборудование с ID:', idEqp); // Добавьте эту строку для логирования
    $.ajax({
      type: "POST",
      url: "eqpDelete.php",
      data: { idEqp: idEqp },
      success: function(response) {
        if (response === "success") {
            console.log('Успешное удаление оборудования с ID:', idEqp);
          alert("Оборудование успешно удалено.");
          location.reload();
        } else {
            console.log('Ошибка при удалении оборудования с ID:', idEqp); // Добавьте эту строку для логирования
          alert("Произошла ошибка при удалении оборудования.");
        }
      }
    });
  }
}
</script> -->
<!-- 
 <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
 integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" 
 crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
   integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" 
   crossorigin="anonymous" referrerpolicy="no-referrer"></script>



