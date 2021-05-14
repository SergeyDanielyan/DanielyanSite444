<!DOCTYPE html5>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinema</title>
        <link rel="icon" type="image" href="logo.jpg">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <?php
            if (!isset($_COOKIE['id'])) {
                echo "<table width='100%' height='100%' align='center' cellspacing='0'>
                        <tr class='header'>
                            <td width='25%'><p><a href='films.php' class='link'>Фильмы</a><a href='actors.php' class='link'>Актёры</a><a href='others.php' class='link'>Иные</a></p></td>
                            <td width=50%><a href='index.php' class='link'><strong class='title'>Cinema</strong></a></td>
                            <td><p><a href='auth.php' class='link'>Вход</a><a href='registration.php' class='link'>Регистрация</a></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <p class='titledescription'>Cinema. Поиск фильмов</p>
                                <p class='description'>В нашем сайте вы найдёте информацию о фильмах, актёрах и т.д.</p>
                            </td>
                            <td></td>
                        </tr>
                        <tr class='footer'>
                            <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                            <td></td>
                            <td align='center'><h4 class='footertext'>Сергей Даниелян</h4></td>
                        </tr>
                    </table>";
            }
            else {
                $id = $_COOKIE['id'];
                $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");
                if ($mysqli->connect_errno) {
                    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
                    exit();
                }
                $query = $mysqli->query("SELECT id, username FROM admins WHERE id = '$id'");
                $data = mysqli_fetch_array($query);
                $username = $data['username'];
                echo "<table width='100%' height='100%' align='center' cellspacing='0'>
                        <tr class='header'>
                            <td width='25%'><p><a href='films.php' class='link'>Фильмы</a><a href='actors.php' class='link'>Актёры</a><a href='others.php' class='link'>Иные</a></p></td>
                            <td width=50%><a href='index.php' class='link'><strong class='title'>Cinema</strong></a></td>
                            <td><p class='link'>$username<a href='logout.php' class='link'>Выйти</a></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <p class='titledescription'>Cinema. Поиск фильмов</p>
                                <p class='description'>В нашем сайте вы найдёте информацию о фильмах, актёрах и т.д.</p>
                            </td>
                            <td></td>
                        </tr>
                        <tr class='footer'>
                            <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                            <td></td>
                            <td align='center'><h4 class='footertext'>Сергей Даниелян</h4></td>
                        </tr>
                    </table>";
            }
        ?>
    </body>
</html>
