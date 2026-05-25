<?php session_start(); include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['password']);
    $res = mysqli_query($con, "SELECT * FROM users WHERE login='$login'");
    if ($user = mysqli_fetch_assoc($res)) {
        if ($pass === $user['password']) {
            $_SESSION['client_id'] = $user['id']; $_SESSION['login'] = $user['login'];
            header('Location: '.($user['login']=='Admin26'?'admin.php':'profile.php')); exit;
        } else $error = 'Неверный пароль';
    } else $error = 'Неверный логин';
}
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Вход</title><link rel="stylesheet" href="styles/style.css"></head>
<body>
<header class="main-header"><div class="container header-inner"><div class="logo"><img src="images/1282150.png" class="logo-img"><h1>Конференции.РФ</h1></div><nav><a href="index.php" class="btn">Главная</a><a href="register.php" class="btn">Регистрация</a></nav></div></header>
<main class="container"><div class="card"><h2>Авторизация</h2>
<?php if($error) echo "<div class='alert'>$error</div>"; ?>
<form method="POST">
    <div class="form-group"><label>Логин</label><input type="text" name="login" required></div>
    <div class="form-group"><label>Пароль</label><input type="password" name="password" required></div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>
<p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
</div></main>
</body>
</html>