<?php
    $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        if ($mysqli->connect_errno) {
            printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
            exit();
        }

        $query = $mysqli->query("SELECT id, pass FROM admins WHERE username='$username'");
        $data = mysqli_fetch_array($query);
        if ($data['pass'] == md5(md5($pass))) {
            setcookie("admin", $data['id'], time()+60*60*24);
            header("Location: index.php");
            exit();
        } 
    }
?>

<!DOCTYPE html5>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinema, вход</title>
        <link rel="icon" type="image" href="logo.jpg">
        <link rel="stylesheet" href="authstyle.css" type="text/css">
    </head>
    <body>
        <form class="form" method="POST">
            <h1 class="form_title">Вход</h1>
            <div class="form_grup">
                <label class="form_label">Логин</label>
                <input class="form_input" name="username" autocomplete="off" placeholder=" ">
            </div>
            <div class="form_grup">
                <label class="form_label">Пароль</label>
                <input class="form_input" type="password" name="password">
            </div>
            <input class="form_button" type="submit" name="submit" value="Войти" placeholder=" ">
            <?php
                if (isset($_POST['submit']) && $data['pass'] != md5(md5($pass))) {
                    echo "<br><p>Вы ввели неправильный логин/пароль</p>";
                }
            ?>
        </form>
    </body>
</html>