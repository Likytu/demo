<?php
include('connect/session.php');
include('connect/dbcon.php');

$message = '';
$error = '';

if(isset($_POST['register'])){
    $login = $_POST ['login'];
    $name = $_POST ['name'];
    $phone = $_POST ['phone'];
    $email = $_POST ['email'];
    $password = $_POST ['password'];
    $repassword = $_POST ['repassword'];

    //Проверка логина на длину (больше 6 символов) и содержания (латинские буквы и цифры)
    if(strlen($login)>=6 & ctype_alnum($login) == true) {

        //Проверка пароля на длину (больше 8 символов) 
        if(strlen($password)>=8) {

            //Проверка соответствия повтора пароля
            if($password == $repassword){
                $sql_test = "SELECT * FROM `users` WHERE LOGIN = '$login'";
                $sql_test_result = $cms -> query($sql_test);

                //проверка на уникальность логина
                if($sql_test_result && $sql_test_result -> num_rows == 1){
                    $error = 'Пользователь с таким логином уже существует';
                }
                //Если все условия соблюдены, данные вносятся в БД
                else{
                    $message = 'Вы успешно зарегистрированы!';
                    $sql = "INSERT INTO `users`
                    (`LOGIN`, `NAME`, `PHONE`, `EMAIL`, `PASSWORD`, `RANK`) 
                    VALUES 
                    ('$login','$name','$phone','$email','$password','20')";
                    $rezultat = $cms -> query($sql);
                }
            }
            else{
                $error = 'Пароли не совпадают';
            }
        }
        else{
            $error = 'Пароль должен содержать не менее 8 символов';
        }
    }
    else{
        $error = 'Логин должен состоять из латинских букв и цифр, не менее 6 символов';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница регистрации</title>
    <link rel="stylesheet" href="static/bootstrap.min.css">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <nav class="nav-block">
        <div class="container">
            <div class="nav-inner">
                <img class="logo" src="static/лого.jpg" alt="логотип">
                <div class="nav-links">
                    <a href="index.php">Регистрация</a>
                    <a href="login.php">Авторизация</a>
                    <a href="look.php">Мои заявки</a>
                    <a href="form.php">Сформировать заявку</a>
                    <a href="admin.php">Панель администратора</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="page-title">Страница регистрации</h1>
    </div>
    <div class="container">
        <div class="success-message">
            <?php
                echo $message;
            ?>
        </div>
        <div class="error-message">
            <?php
                echo $error;
            ?>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12">
                <div class="form-block">
                    <form action="index.php" method="POST">
                        <label>Логин</label>
                        <input class="form-control" type="text" name="login" required>
                        <p class="hint">Логин должен содержать латинские буквы и цифры, не менее 6 символов</p>
                        <label>ФИО</label>
                        <input class="form-control" type="text" name="name" required>
                        <label>Телефон</label>
                        <input class="form-control" type="tel" name="phone" pattern="\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}" 
                            placeholder="+7 (XXX) XXX-XX-XX" title="Введите номер в формате +7 (XXX) XXX-XX-XX" required>
                        <label>Почта</label>
                        <input class="form-control" type="email" name="email" required>
                        <label>Пароль</label>
                        <input class="form-control" type="password" name="password" required>
                        <p class="hint">Пароль должен быть не менее 8 символов</p>
                        <label>Повторите пароль</label>
                        <input class="form-control" type="password" name="repassword" required>
                        <button class="register-btn" name="register">Зарегистрироваться</button>
                    </form>
                    <a class="login-link" href="login.php">Уже зарегистрированы? <span>Авторизоваться</span></a>
                </div>
            </div>
            <div class="col-lg-6 col-12 text-center">
                <img class="side-image" src="static/фото.jpg" alt="рисунок">
            </div>
        </div>
    </div>
</body>
</html>