<?php session_start(); include 'db.php';
if(!isset($_SESSION['login'])) header('Location: login.php');
$user_id = $_SESSION['client_id'];
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['booking_id'],$_POST['feedback'])){
    $id=(int)$_POST['booking_id']; $fb=trim($_POST['feedback']);
    mysqli_query($con,"UPDATE bookings SET feedback='$fb' WHERE id=$id AND user_id=$user_id AND status='Мероприятие завершено'");
    header('Location: profile.php'); exit;
}
$res = mysqli_query($con,"SELECT * FROM bookings WHERE user_id=$user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Личный кабинет</title><link rel="stylesheet" href="styles/style.css"><script src="js/script.js"></script></head>
<body>
<header class="main-header"><div class="container header-inner"><div class="logo"><img src="images/1282150.png" class="logo-img"><h1>Личный кабинет</h1></div><nav><a href="index.php" class="btn">Главная</a><a href="booking_create.php" class="btn btn-primary">Новая заявка</a><a href="logout.php" class="btn btn-outline">Выход</a></nav></div></header>
<main class="container">
    <!-- Слайдер в личном кабинете -->
    <div id="profileSlider" class="slider-container">
        <div class="slider">
            <div class="slide"><img src="images/ad4b1ceed37823f2225c0e7a.jpg"></div>
            <div class="slide"><img src="images/dizayn-interera-co-working-.jpg"></div>
            <div class="slide"><img src="images/978e0d84d6b940fe1.jpg"></div>
            <div class="slide"><img src="images/ec8a14264510f22a979f3.jpg"></div>
        </div>
        <button class="slider-btn prev">❮</button><button class="slider-btn next">❯</button>
        <div class="dots"></div>
    </div>
    <div class="card"><h2>Мои заявки</h2>
    <div class="table-wrapper"><table><thead><tr><th>ID</th><th>Помещение</th><th>Дата</th><th>Статус</th><th>Ответ админа</th><th>Отзыв</th><th>Действие</th></tr></thead>
    <tbody><?php while($row=mysqli_fetch_assoc($res)): $statusClass=$row['status']=='Новая'?'badge-new':($row['status']=='Мероприятие назначено'?'badge-scheduled':'badge-completed'); ?>
    <tr><td><?=$row['id']?></td><td><?=htmlspecialchars($row['room_type'])?></td><td><?=date('d.m.Y H:i',strtotime($row['start_datetime']))?></td>
    <td><span class="badge <?=$statusClass?>"><?=$row['status']?></span></td><td><?=nl2br(htmlspecialchars($row['admin_comment']?:'—'))?></td>
    <td><?=nl2br(htmlspecialchars($row['feedback']?:'—'))?></td>
    <td><?php if($row['status']=='Мероприятие завершено' && empty($row['feedback'])): ?>
        <form method="POST"><input type="hidden" name="booking_id" value="<?=$row['id']?>"><textarea name="feedback" rows="2" placeholder="Ваш отзыв..." required></textarea><button type="submit" class="btn btn-primary">Отправить</button></form>
        <?php elseif($row['status']=='Мероприятие завершено' && !empty($row['feedback'])): ?>✓ Отзыв дан<?php else: ?>—<?php endif; ?>
    </td></tr><?php endwhile; ?></tbody></table></div></div>
</main>
<script>initSlider('profileSlider');</script>
</body>
</html>