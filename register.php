<?php session_start(); include 'db.php';
$error = $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);

    if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $login)) $error = 'Логин: лат. буквы/цифры, мин 6';
    elseif (strlen($password) < 8) $error = 'Пароль не менее 8 символов';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Неверный email';
    else {
        $check = mysqli_query($con, "SELECT id FROM users WHERE login='$login' OR email='$email'");
        if (mysqli_num_rows($check)) $error = 'Логин или email уже занят';
        else {
            mysqli_query($con, "INSERT INTO users (fullname,email,login,password,phone) VALUES ('$fullname','$email','$login','$password','$phone')");
            $success = 'Регистрация успешна! Теперь войдите.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"><title>Регистрация</title><link rel="stylesheet" href="styles/style.css"><script src="js/script.js" defer></script></head>
<body>
<header class="main-header"><div class="container header-inner"><div class="logo"><img src="images/1282150.png" class="logo-img"><h1>Конференции.РФ</h1></div><nav><a href="index.php" class="btn">Главная</a><a href="login.php" class="btn">Вход</a></nav></div></header>
<main class="container"><div class="card"><h2>Регистрация</h2>
<?php if($error) echo "<div class='alert'>$error</div>"; if($success) echo "<div class='alert' style='background:#d4edda;color:#155724'>$success</div>"; ?>
<form method="POST" onsubmit="return validateRegisterForm()">
    <div class="form-group"><label>ФИО</label><input type="text" name="fullname" required></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Логин (лат+цифры, >=6)</label><input type="text" name="login" id="login" required><div id="loginError" class="error-hint"></div></div>
    <div class="form-group"><label>Пароль (>=8 символов)</label><input type="password" name="password" id="password" required><div id="passwordError" class="error-hint"></div></div>
    <div class="form-group"><label>Телефон</label><input type="text" name="phone"></div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
<p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
</div></main>
</body>
</html>