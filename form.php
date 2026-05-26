<?php
include ('connect/session.php');
include ('connect/dbcon.php');

$str = '';
$massage = '';

//Проверка выхода пользователя из аккаунта
if(isset($_GET['exit']) && $_GET['exit'] == 1) {
    $_SESSION = [];
    session_destroy();
}

//Проверка авторизации пользователя и уровня доступа
if (isset($_SESSION['userid']) && ($_SESSION['rank'] >= 20)) {

    //Проверка нажатия кнопки отправки формы
    if(isset($_POST['add'])) {
        $user = $_SESSION['userid'];
        $big_text = $_POST['big_text'];
        $spisok = $_POST['spisok'];
        $text = $_POST['text'];
        $phone = $_POST['phone'];
        $data = $_POST['data'];
        $radio = $_POST['radio'];

        //Преобразование выбранных чек-боксов в строку для сохранения в БД
        $check = '';
        if(isset($_POST['check'])) {
            $check = implode(', ', $_POST['check']);
        }

        //Проверка установки обязательного чек-бокса согласия
        $agree = isset($_POST['agree']) ? 1 : 0;

        $sql = "INSERT INTO `forma`
        (`USER`, `BIG_TEXT`, `SPISOK`, `TEXT`, `PHONE`, `DATA`, `RADIO`, `CHECK`, `AGREE`, `STATUS`)
        VALUES
        ('$user','$big_text','$spisok','$text','$phone','$data','$radio','$check','$agree','0')";

        $rezultat = $cms->query($sql);

        //Проверка успешности сохранения данных
        if($rezultat == 1) {
            $massage = 'Успешно сохранено';
        } else {
            $massage = 'Ошибка сохранения';
        }
    }

    //Вывод сообщения и формы
    $str .= '
    <form action="form.php" method="POST">

        <label>Большой текст</label>
        <textarea class="form-control" name="big_text" required></textarea>

        <label>Список</label>
        <select class="form-control" name="spisok" required>
            <option value="">Выберите вариант</option>
            <option value="Вариант1">Вариант1</option>
            <option value="Вариант2">Вариант2</option>
            <option value="Вариант3">Вариант3</option>
            <option value="Вариант4">Вариант4</option>
            <option value="Вариант5">Вариант5</option>
        </select>

        <label>Телефон</label>
        <input class="form-control" type="tel" name="phone"
            pattern="\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}"
            placeholder="+7 (XXX) XXX-XX-XX"
            title="Введите номер в формате +7 (XXX) XXX-XX-XX" required>

        <label>Обычный текст</label>
        <input class="form-control" type="text" name="text" required>

        <label>Дата и время</label>
        <input class="form-control" type="datetime-local" name="data" required>

        <label>Радио-кнопки</label>
        <div class="radio-group">
            <label><input type="radio" name="radio" value="Вариант1" required> Вариант1</label>
            <label><input type="radio" name="radio" value="Вариант2"> Вариант2</label>
            <label><input type="radio" name="radio" value="Вариант3"> Вариант3</label>
        </div>

        <label>Чек-бокс</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="check[]" value="Вариант1"> Вариант1</label>
            <label><input type="checkbox" name="check[]" value="Вариант2"> Вариант2</label>
            <label><input type="checkbox" name="check[]" value="Вариант3"> Вариант3</label>
            <label><input type="checkbox" name="check[]" value="Вариант4"> Вариант4</label>
        </div>

        <div class="agree-box">
            <label>
                <input type="checkbox" name="agree" required> Обязательная кнопка чек-бокса
            </label>
        </div>

        <button class="register-btn" name="add">Отправить</button>
    </form><br>

    <a class="btn-2" href="?exit=1">Выйти из аккаунта</a>';

} else {
    $massage .= 'У вас нет прав к этой странице';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница формирования заявки</title>
    <link rel="stylesheet" href="static/bootstrap.min.css">
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
    <nav class="nav-block">
        <div class="container">
            <div class="nav-inner">
                <img class="logo" src="static/hands-donation-png.webp" alt="логотип">
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
        <h1 class="page-title">Страница формирования заявки</h1>
    </div>
    <div class="container">
        <div class="error-message">
            <?php echo $massage; ?>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12">
                <div class="form-block">
                    <?php echo $str; ?>
                </div>
            </div>
            <div class="col-lg-6 col-12 text-center">
                <img class="side-image" src="static/back.jpg" alt="рисунок">
            </div>
        </div>
    </div>
</body>
</html>