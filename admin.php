<?php session_start(); include 'db.php';
if(!isset($_SESSION['login']) || $_SESSION['login']!=='Admin26') header('Location: login.php');

// Обработка изменения статуса
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['booking_id'])){
    $id=(int)$_POST['booking_id'];
    $status=$_POST['status'];
    $comment=trim($_POST['admin_comment']);
    mysqli_query($con,"UPDATE bookings SET status='$status', admin_comment='$comment' WHERE id=$id");
    echo "<script>sessionStorage.setItem('toast','Статус обновлён');</script>";
}

// Параметры фильтрации и сортировки
$statusFilter = $_GET['status'] ?? '';
$roomFilter = $_GET['room'] ?? '';
$sort = $_GET['sort'] ?? 'id';
$order = $_GET['order'] ?? 'DESC';
$page = (int)($_GET['page'] ?? 1);
$perPage = 5;
$offset = ($page-1)*$perPage;

$where = [];
if($statusFilter) $where[] = "b.status='$statusFilter'";
if($roomFilter) $where[] = "b.room_type='$roomFilter'";
$whereSql = $where ? "WHERE ".implode(' AND ', $where) : "";

$totalRes = mysqli_query($con,"SELECT COUNT(*) as cnt FROM bookings b $whereSql");
$total = mysqli_fetch_assoc($totalRes)['cnt'];
$totalPages = ceil($total/$perPage);

$sql = "SELECT b.*, u.fullname, u.login FROM bookings b JOIN users u ON b.user_id=u.id $whereSql ORDER BY $sort $order LIMIT $offset,$perPage";
$result = mysqli_query($con,$sql);
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Админка</title><link rel="stylesheet" href="styles/style.css"><script src="js/script.js"></script></head>
<body>
<header class="main-header"><div class="container header-inner"><div class="logo"><img src="images/1282150.png" class="logo-img"><h1>Администратор</h1></div><nav><a href="index.php" class="btn">Главная</a><a href="logout.php" class="btn btn-outline">Выход</a></nav></div></header>
<main class="container">
<div class="card">
    <h2>Управление заявками</h2>
    <!-- Фильтры -->
    <form method="GET" class="filter-bar">
        <select name="status"><option value="">Все статусы</option><option <?=($statusFilter=='Новая')?'selected':''?>>Новая</option><option <?=($statusFilter=='Мероприятие назначено')?'selected':''?>>Мероприятие назначено</option><option <?=($statusFilter=='Мероприятие завершено')?'selected':''?>>Мероприятие завершено</option></select>
        <select name="room"><option value="">Все помещения</option><option <?=($roomFilter=='Аудитория')?'selected':''?>>Аудитория</option><option <?=($roomFilter=='Коворкинг')?'selected':''?>>Коворкинг</option><option <?=($roomFilter=='Кинозал')?'selected':''?>>Кинозал</option></select>
        <button type="submit" class="btn">Фильтровать</button>
        <a href="admin.php" class="btn btn-outline">Сброс</a>
    </form>
    <!-- Таблица с сортировкой -->
    <div class="table-wrapper">
    <table>
        <thead>
            <tr><th><a href="?<?=http_build_query(array_merge($_GET,['sort'=>'id','order'=>($sort=='id' && $order=='ASC'?'DESC':'ASC')]))?>">ID <?=($sort=='id')?($order=='ASC'?'↑':'↓'):''?></a></th>
            <th>Клиент</th><th>Помещение</th><th>Дата</th><th>Статус</th><th>Действие</th></tr>
        </thead>
        <tbody><?php while($row=mysqli_fetch_assoc($result)): ?>
        <tr><td><?=$row['id']?></td><td><?=htmlspecialchars($row['fullname'])?><br><small><?=$row['login']?></small></td>
        <td><?=$row['room_type']?></td><td><?=date('d.m.Y H:i',strtotime($row['start_datetime']))?></td>
        <td><span class="badge <?=($row['status']=='Новая'?'badge-new':($row['status']=='Мероприятие назначено'?'badge-scheduled':'badge-completed'))?>"><?=$row['status']?></span></td>
        <td><button class="btn" onclick="showEditForm(<?=$row['id']?>, '<?=$row['status']?>', '<?=addslashes($row['admin_comment'])?>')">✏️ Редактировать</button></td></tr>
        <?php endwhile; ?></tbody>
    </table>
    </div>
    <!-- Пагинация -->
    <div class="pagination"><?php for($i=1;$i<=$totalPages;$i++): ?><a href="?<?=http_build_query(array_merge($_GET,['page'=>$i]))?>" class="<?=($i==$page)?'active':''?>"><?=$i?></a><?php endfor; ?></div>
</div></main>

<!-- Модальное окно редактирования -->
<div id="editModal" style="display:none; position:fixed; top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;"><div class="card" style="max-width:400px;margin:auto;"><h3>Редактирование заявки</h3><form method="POST" id="editForm"><input type="hidden" name="booking_id" id="editId"><div class="form-group"><label>Статус</label><select name="status" id="editStatus"><option>Новая</option><option>Мероприятие назначено</option><option>Мероприятие завершено</option></select></div><div class="form-group"><label>Комментарий</label><textarea name="admin_comment" id="editComment" rows="3"></textarea></div><button type="submit" class="btn btn-primary">Сохранить</button><button type="button" class="btn btn-outline" onclick="closeModal()">Отмена</button></form></div></div>

<script>
function showEditForm(id, status, comment){
    document.getElementById('editId').value=id;
    document.getElementById('editStatus').value=status;
    document.getElementById('editComment').value=comment;
    document.getElementById('editModal').style.display='flex';
}
function closeModal(){ document.getElementById('editModal').style.display='none'; }
window.onload=function(){
    if(sessionStorage.getItem('toast')){ showToast(sessionStorage.getItem('toast')); sessionStorage.removeItem('toast'); }
}
</script>
</body>
</html>