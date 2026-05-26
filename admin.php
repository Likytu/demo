<?php 
include ('connect/session.php');
include ('connect/dbcon.php');

$massage = '';
$str = '';

// Проверка авторизации администратора
if(isset($_SESSION['rank']) && $_SESSION['rank'] >= 40) {

    // Проверка передачи статуса через GET-запрос
    if(isset($_GET['status'])) {

        // Определение нового статуса заявки
        if($_GET['status'] == 0) {
            $stat = 1;
        }
        if($_GET['status'] == 1) {
            $stat = 2;
        }

        $sql = "UPDATE `forma`
                SET `STATUS`='$stat' 
                WHERE ID=".$_GET['id'];
        $rezultat = $cms->query($sql);

        // Проверка успешности изменения статуса
        if($rezultat) {
            $massage .= 'Статус изменен';
        }
        else {
            $massage .= 'Данные не сохранены в БД';
        }
    }

    $sql = "SELECT * FROM `forma` WHERE 1";
    $rezultat = $cms->query($sql);

    // Проверка наличия заявок
    if($rezultat->num_rows > 0) {
        $str .= "<div class='table-responsive'>
        <table class='table table-hover table-bordered text-center align-middle'>
        <tr>
        <td><b>Пользователь</b></td>
        <td><b>Большой текст</b></td>
        <td><b>Список</b></td>
        <td><b>Обычный текст</b></td>
        <td><b>Телефон</b></td>
        <td><b>Дата</b></td>
        <td><b>Радио-кнопки</b></td>
        <td><b>Чек-бокс</b></td>
        <td><b>Отзыв</b></td>
        <td><b>Статус</b></td>
        <td><b>Действие</b></td>
        </tr>";

        // Перебор всех заявок
        while ($row = $rezultat->fetch_object()) {

            // Определение текстового статуса заявки
            if($row->STATUS == 0) {
                $status_prob = 'Новое';
            }
            elseif($row->STATUS == 1) {
                $status_prob = 'В разработке';
            }
            else {
                $status_prob = 'Выполнено';
            }

            // Проверка наличия отзыва
            $review = ($row->RATING == '') ? 'Нет отзыва' : $row->RATING;

            $str .= "<tr>
            <td>$row->USER</td>
            <td>$row->BIG_TEXT</td>
            <td>$row->SPISOK</td>
            <td>$row->TEXT</td>
            <td>$row->PHONE</td>
            <td>$row->DATA</td>
            <td>$row->RADIO</td>
            <td>$row->CHECK</td>
            <td>$review</td>
            <td>$status_prob</td>
            <td>";

            if($row->STATUS == 0) {
                $str .= "<a class='btn button' href='admin.php?status=0&id=$row->ID'>Принять</a>";
            }
            elseif($row->STATUS == 1) {
                $str .= "<a class='btn button' href='admin.php?status=1&id=$row->ID'>Завершить</a>";
            }
            else {
                $str .= "Заявка завершена";
            }

            $str .= "</td>
            </tr>";
        }

        $str .= '</table></div>';

    }
    else {
        $massage .= 'Нет заявок';
    }
}
else {
    $massage .= "Вы не авторизованы";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница администратора</title>
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
        <h1 class="page-title">Панель администратора</h1>
    </div>
    <div class="container">
        <div class="error-message">
            <?php echo $massage; ?>
        </div>
    </div>
    <div class="container">
        <div class="form-block">
            <?php echo $str; ?>
        </div>
        <div class="text-center">
            <img class="side-image" src="static/back.jpg" alt="рисунок">
        </div>
    </div>
</body>
</html>