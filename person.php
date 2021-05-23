<?php
    $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");
    $id = $_COOKIE['id'];
    $person_query = $mysqli->query("SELECT * FROM cin_persons WHERE id = ".$id);
    $person = mysqli_fetch_array($person_query);
    $country_query = $mysqli->query("SELECT * FROM countries WHERE id = ".$person['citizenship_country_id']);
    $country = mysqli_fetch_array($country_query);
    $films_query = $mysqli->query("SELECT year, films.name AS film, professions.name AS profession, role_name
        FROM film_person 
        INNER JOIN films ON film_id = films.id 
        INNER JOIN professions ON profession_id = professions.id
        WHERE person_id = '$id'
        ORDER BY year");
    $years = "";
    if (isset($person['year_of_birth'])) {
        $years = "<p>Годы жизни: ".$person['year_of_birth']." - ";
        if (isset($person['year_of_death'])) {
            $years .= $person['year_of_death'];
        }
        else {
            $years .= "наст. время";
        }
        $years .= "</p>";
    }
    $filmography = "";
    while ($film = mysqli_fetch_array($films_query)) {
        $filmography .= 
        "<tr>
            <td>".$film['year']."</td>
            <td>".$film['film']."</td>
            <td>".$film['profession']."</td>
            <td>".$film['role_name']."</td>
        </tr>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <?php
            echo "<title>".$person['surname'].", ".$person['name']." - Cinema</title>";
        ?>
        <link rel="icon" type="image" href="logo.jpg">
        <link rel="stylesheet" href="object.css" type="text/css">
    </head>
    <body>
    <table width='100%' height='100%' align='center' cellspacing='0'>
            <tr class='header'>
                <td width='25%'><p><a href='films.php' class='link'>Фильмы</a> <a href='persons.php' class='link'>Люди</a></p></td>
                <td width=50%><a href='index.php' class='link'><strong class='title'>Cinema</strong></a></td>
                <?php
                    if (isset($_COOKIE['admin'])) {
                        $id = $_COOKIE['admin'];
                        $qqquery = $mysqli->query("SELECT id, username FROM admins WHERE id = '$id'");
                        $data = mysqli_fetch_array($qqquery);
                        $username = $data['username'];
                        echo "<td><p class='link'>".$username." <a href='logout.php' class='link'>Выйти</a></p></td>";
                    }
                    else {
                        echo "<td><p><a href='auth.php' class='link'>Вход</a> <a href='registration.php' class='link'>Регистрация</a></p></td>";
                    }
                ?>
            </tr>
            <tr>
                <td colspan='3'>
                    <?php
                        echo "<h1 title align=center class='ttitle'>".$person['surname'].", ".$person['name']."</h1>
                        <div class='image'>
                            <img src=".$person['photo_link'].">"
                            .$years.
                            "<p>Страна: ".$country['name']."</p>
                        </div>
                        <div class='text'>
                            <p>".$person['description']."</p>
                            <h3 align=center>Фильмография: </h3>
                            <table border='1' width='100%' cellpadding='5'>
                                <tr>
                                    <th>Год</th>
                                    <th>Фильм</th>
                                    <th>Профессия</th>
                                    <th>Роль</th>
                                </tr>".$filmography
                                
                            ."</table>
                        </div>
                        ";
                    ?>
                </td>
            </tr>
            <tr>
                <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                <td></td>
                <td align='center'><h4 class='footertext'>Сергей Даниелян</h4></td>
            </tr>
        </table>
    </body>
</html>