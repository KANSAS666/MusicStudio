<?php
    include("db.php");
    include("admin.php");
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
<div class="container text-center mx-auto">
<div class="row">
    <div class="col-md-6 mx-auto">
        <form method="POST" action="" id="form">
            <h4 style="margin-bottom: 10px; color: #04303E; background: #ADD8E6; display: inline-block; border-radius: 5px; padding: 2px;">Регистрация клиента</h4>
            <div class="form-group">
        <label for ="lastname">Фамилия:</label>
        <input type="text" name="last_name" id="last_name" required class="form-control"> 
            </div>

            <div class="form-group">
        <label for ="first_name">Имя:</label>
        <input type="text" name="first_name" id="first_name" required class="form-control"> 
            </div>

            <div class="form-group">
        <label for ="father_name">Отчество:</label>
        <input type="text" name="father_name" id="father_name" required class="form-control"> 
            </div>

            <div class="form-group">
        <label for ="passport">Серия и номер паспорта:</label>
        <input type="number" name="passport" id="passport" required class="form-control"> 
            </div>

            <div class="form-group">
        <label for ="adress">Адрес проживания:</label>
        <input type="text" name="adress" id="adress" required class="form-control"> 
            </div>

            <div class="form-group">
        <label for ="birth_date">Дата рождения:</label>
        <input type="date" name="birth_date" id="birth_date" required class="form-control"> 
            </div>

            
            <div class="form-group">
        <label for ="phone_number">Номер телефона:</label>
        <input type="text" name="phone_number" id="phone_number" required class="form-control"> 
            </div>
        
            <div class="form-group">
		<input type="submit" name="submit" value="Внести в список клиентов" class="btn btn-success" style="margin-top: 10px;">  <!-- style="margin-top: 10px; background-color: #ADD8E6; color: #04303E; border: 1px solid #ADD8E6"-->
            </div>
        </form>
    </div>
    </div>

    <div id="success-message" style="display: none;">
    Данные успешно внесены!
</div>

    <?php
        if (isset($_POST['submit'])){
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $fatherName = $_POST['father_name'];
            $phoneNumber = $_POST['phone_number'];
            $passport = $_POST['passport'];
            $adress = $_POST['adress'];
            $birthDate = $_POST['birth_date'];

            $mysql = "INSERT INTO `Clients`(`Lastname`, `Firstname`, `Fathername`, `Phone`, `Passport`, `Birthdate`, 
            `Adress`) VALUES ('$lastName','$firstName','$fatherName','$phoneNumber','$passport','$birthDate','$adress')";

            $result=mysqli_query($conn,$mysql);

            if($result == TRUE)
            {
                // echo "Данные успешно внесены!";
                // echo "<script> document.location.href = 'clientRegistration.php'</script>";

        //         echo "<script>
        //     document.getElementById('success-message').style.display = 'block';
        //     setTimeout(function() {
        //         document.location.href = 'clientRegistration.php';
        //     }, 3000); // Ждать 3 секунды перед перенаправлением
        //   </script>";

        echo "<script>
            var successMessage = document.getElementById('success-message');
            successMessage.style.display = 'block';
            successMessage.style.color = 'white'; // Установите белый цвет текста
            setTimeout(function() {
                document.location.href = 'clientRegistration.php';
            }, 1000); // Ждать 3 секунды перед перенаправлением
          </script>";
            }
            else{
                 echo "Ошибка";
            }


        }
    ?>
</div>