<?php 
include ('connect/session.php');
include ('connect/dbcon.php');

$massage = '';
$str = '';

//Проверка авторизации пользователя
if(isset($_SESSION['userid'])) {

    //Проверка отправки формы отзыва
    if(isset($_POST['submit_review'])) {
        $id = $_POST['id'];
        $review = $_POST['review'];
        
        //Проверка заполнения поля отзыва
        if(trim($review) == '') {
            $massage .= 'Отзыв не может быть пустым';
        } 
        else {
            $sql = "UPDATE `forma` SET `RATING`='$review' 
                    WHERE ID=$id AND USER=".$_SESSION['userid'];
            $rezultat = $cms->query($sql);

            if($rezultat) {
                $massage .= 'Отзыв сохранён';
            } else {
                $massage .= 'Ошибка сохранения';
            }
        }
    }

    $sql = "SELECT * FROM `forma` WHERE `USER`=".$_SESSION['userid'];
    $rezultat = $cms->query($sql);

    if($rezultat->num_rows > 0) {

        $str .= "<div class='table-responsive'>
        <table class='table table-bordered text-center align-middle'>
        <tr>
        <td><b>Большое описание</b></td>
        <td><b>Список</b></td>
        <td><b>Текст</b></td>
        <td><b>Телефон</b></td>
        <td><b>Дата</b></td>
        <td><b>Радио-кнопки</b></td>
        <td><b>Чек-бокс</b></td>
        <td><b>Отзыв</b></td>
        <td><b>Оставить отзыв</b></td>
        <td><b>Статус</b></td>
        </tr>";

        while ($row = $rezultat->fetch_object()) {
            $review = ($row->RATING == '') ? 'Нет отзыва' : $row->RATING;

            if($row->STATUS == 0) {
                $status_info = 'Новое';
            }
            elseif($row->STATUS == 1) {
                $status_info = 'В разработке';
            }
            else {
                $status_info = 'Выполнено';
            }

            if($row->STATUS == 2) {
                if($row->RATING == '') {
                    $reviewForm = "
                    <form method='POST' action='look.php'>
                        <input type='hidden' name='id' value='$row->ID'>
                        <textarea class='form-control' name='review' rows='2' placeholder='Напишите ваш отзыв...' required></textarea>
                        <button class='register-btn' type='submit' name='submit_review'>Отправить</button>
                    </form>";
                } else {
                    $reviewForm = 'Отзыв уже оставлен';
                }
            }
            else {
                $reviewForm = 'Ещё в разработке';
            }

            $str .= "<tr>
                <td>$row->BIG_TEXT</td>
                <td>$row->SPISOK</td>
                <td>$row->TEXT</td>
                <td>$row->PHONE</td>
                <td>$row->DATA</td>
                <td>$row->RADIO</td>
                <td>$row->CHECK</td>
                <td>$review</td>
                <td>$reviewForm</td>
                <td>$status_info</td>
            </tr>";
        }

        $str .= '</table></div>';

    } else {
        $massage = 'У вас нет заявок';
    }

} else {
    $massage = "Вы не авторизованы";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница мои заявки</title>
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
        <h1 class="page-title">Страница просмотра заявок</h1>
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
            <img class="side-image" src="static/фото.jpg" alt="рисунок">
        </div>
    </div>
</body>
</html>