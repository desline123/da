<?php session_start(); include 'db.php';
if(!isset($_SESSION['login']) || $_SESSION['login']=='Admin26') header('Location: login.php');
$error=''; $success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $room=trim($_POST['room_type']);
    $date=trim($_POST['start_date']); // формат ДД.ММ.ГГГГ
    $time=trim($_POST['start_time']);
    $pay=trim($_POST['payment_method']);
    // Преобразуем в datetime
    $datetime=date('Y-m-d H:i:s', strtotime(str_replace('.','-',$date).' '.$time));
    if(!$datetime || $datetime<date('Y-m-d H:i:s')) $error='Неверная дата или дата в прошлом';
    else{
        mysqli_query($con,"INSERT INTO bookings (user_id,room_type,start_datetime,payment_method,status) VALUES ({$_SESSION['client_id']},'$room','$datetime','$pay','Новая')");
        $success='Заявка создана!';
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Новая заявка</title><link rel="stylesheet" href="styles/style.css"><script src="js/script.js"></script></head>
<body>
<header class="main-header"><div class="container header-inner"><div class="logo"><img src="images/1282150.png" class="logo-img"><h1>Бронирование</h1></div><nav><a href="profile.php" class="btn">Личный кабинет</a><a href="logout.php" class="btn btn-outline">Выход</a></nav></div></header>
<main class="container"><div class="card"><h2>Оформление заявки</h2>
<?php if($error) echo "<div class='alert'>$error</div>"; if($success) echo "<div class='alert' style='background:#d4edda'>$success</div>"; ?>
<form method="POST">
    <div class="form-group"><label>Тип помещения</label><select name="room_type" required><option value="">Выберите</option><option>Аудитория</option><option>Коворкинг</option><option>Кинозал</option></select></div>
    <div class="form-group"><label>Дата начала (ДД.ММ.ГГГГ)</label><input type="text" name="start_date" placeholder="25.12.2026" oninput="maskDate(this)" required></div>
    <div class="form-group"><label>Время начала</label><input type="time" name="start_time" required></div>
    <div class="form-group"><label>Способ оплаты</label><select name="payment_method" required><option>Наличные</option><option>Банковская карта</option><option>Безналичный расчет</option></select></div>
    <button type="submit" class="btn btn-primary">Отправить заявку</button>
</form>
</div></main>
</body>
</html>