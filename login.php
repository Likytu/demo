<?php
include ('connect/session.php');
include ('connect/dbcon.php');

//Проверка выхода пользователя из аккаунта
if(isset($_GET['exit']) && $_GET['exit'] == 1) {
    $_SESSION = [];
    session_destroy();
}

$error=$message='';

//Проверка нажатия кнопки входа в аккаунт
if (isset($_POST['loginin'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    //Проверка заполнения полей логина и пароля
    if ($login == '' || $password == '') {
        $error = 'Нет данных пользователя';
    }
    else {
        $sql = "SELECT * FROM `users` WHERE LOGIN='$login'";
        $rezultat = $cms -> query($sql);

        //Проверка существования пользователя
        if ($rezultat && $rezultat->num_rows == 1) {
            $row = $rezultat->fetch_object();

            //Проверка соответствия пароля
            if($password == $row->PASSWORD) {
                //Создание пользовательской сессии
                $_SESSION['userid'] = $row->ID;
                $_SESSION['name'] = $row->NAME;
                $_SESSION['rank'] = $row->RANK;   
            }
            else {
                $error = 'Логин или пароль указаны неверно';
            }   
        }
        else {
            $error = 'Логин или пароль указаны неверно';
        }    
    }
}

$str_login='';

if (isset($_SESSION['userid'])){
    $str_login="<p class='hello'>Вы вошли в аккаунт как {$_SESSION['name']}!</p>";

    //Проверка уровня доступа пользователя
    if ($_SESSION['rank'] > 40) {
        $str_login.="<p class='hello-2'>Добро пожаловать в панель администратора портала « »</p>";
    }
    else {
        $str_login.="<p class='hello-2'>Добро пожаловать на портал « »</p>";
    }
    $str_login.='<a class="btn-2" href="?exit=1">Выйти из аккаунта</a>';  
}
else {
    $str_login.='<form action="login.php" method="POST">
                    <label>Логин</label>
                    <input class="form-control" type="text" name="login" value="" require>
                    <label>Пароль</label>
                    <input class="form-control" type="password" name="password" value="" require>
                    <button class="register-btn" name="loginin" value="">Войти в аккаунт</button>
                </form>
                <a class="login-link" href="index.php">Ещё не зарегистрированы? <span>Регистрация</span></a>';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница авторизации</title>
    <link rel="stylesheet" href="static/bootstrap.min.css">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <nav class="nav-block">
        <div class="container">
            <div class="nav-inner">
                <img class="logo" src="static/лого.webp" alt="логотип">
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
        <h1 class="page-title">Страница авторизации</h1>
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
                    <?php 
                        echo $str_login;
                    ?>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="slider-wrapper">
                    <button class="slider-btn prev" onclick="changeSlide(-1)">&#10094;</button>
                    <div class="slider" id="slider">
                        <img src="static/фото1.jpg" alt="Слайд 1">
                        <img src="static/фото2.jpg" alt="Слайд 2">
                        <img src="static/фото3.jpg" alt="Слайд 3">
                        <img src="static/фото4.jpg" alt="Слайд 4">
                    </div>
                    <button class="slider-btn next" onclick="changeSlide(1)">&#10095;</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let current = 0;
        const total = 4;
        let autoplay;

        function updateSlider() {
            document.getElementById('slider').style.transform = `translateX(-${current * 100}%)`;
        }
        function changeSlide(dir) {
            current = (current + dir + total) % total;
            updateSlider();
            resetAutoplay();
        }
        function goToSlide(index) {
            current = index;
            updateSlider();
            resetAutoplay();
        }
        function resetAutoplay() {
            clearInterval(autoplay);
            autoplay = setInterval(() => changeSlide(1), 3000);
        }

        autoplay = setInterval(() => changeSlide(1), 3000);
    </script>
</body>
</html>