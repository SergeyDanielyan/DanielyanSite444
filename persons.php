<?php
    $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");
    $countries_query = $mysqli->query("SELECT * FROM countries");
    $countries = array();
    while ($row = mysqli_fetch_array($countries_query)) {
        $countries[] = $row;
    }

    $persons_query = $mysqli->query("SELECT * FROM cin_persons");
    $persons = array();
    while ($row = mysqli_fetch_array($persons_query)) {
        $persons[] = $row;
    }

    if (isset($_POST['filter'])) {
        $where = "WHERE year_of_birth >= ".$_POST['mindate']." AND year_of_birth <= ".$_POST['maxdate'];
        if ($_POST['country'] != -1) {
            $where = $where." AND citizenship_country_id = ".$_POST['country'];
        }
        $persons_query = $mysqli->query("SELECT * FROM cin_persons ".$where);
        $persons = array();
        while ($row = mysqli_fetch_array($persons_query)) {
            $persons[] = $row;
        }
    }

    if (isset($_POST['search_subm'])) {
        $val = '%'.$_POST['search'].'%';
        $persons_query = $mysqli->query("SELECT * FROM cin_persons WHERE name LIKE '$val' OR surname LIKE '$val'");
        $persons = array();
        while ($row = mysqli_fetch_array($persons_query)) {
            $persons[] = $row;
        }
    }

    if (isset($_POST['person_submit'])) {
        if (isset($_POST['person'])) {
            setcookie('id', $_POST['person'], 0);
            header("Location: person.php");
            exit();
        }
    }
?>

<!DOCTYPE html5>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinema, люди</title>
        <link rel="icon" type="image" href="logo.jpg">
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
                <td></td>
                <td>
                    <form method='POST'>
                        <input type='search' name='search' placeholder='Поиск'>
                        <input type='submit' name='search_subm' value='Найти'>
                    </form>
                    <?php
                        if (isset($_POST['person_submit']) && !isset($_POST['person'])) {
                            echo "<p align='center'>Пожалуйста, выберите человека.</p>";
                        }
                        if (isset($_POST['filter'])) {
                            if (count($persons) != 0) {
                                echo "<form method='POST'>
                                    <input type='submit' name='person_submit' value='Выбрать человека'><br><br>";
                                foreach ($persons as $person) {
                                    echo "<label><input type='radio' name='person' value=".$person['id']."> ".$person['name']." ".$person['surname']."</label><br>";
                                }
                                echo "</form>";
                            }
                            else {
                                echo "<p align='center'>К сожалению, не найдено результатов.</p>";
                            }
                        }
                        else if (isset($_POST['search_subm'])) {
                            if (count($persons) != 0) {
                                echo "<form method='POST'>
                                    <input type='submit' name='person_submit' value='Выбрать человека'><br><br>";
                                foreach ($persons as $person) {
                                    echo "<label><input type='radio' name='person' value=".$person['id']."> ".$person['name']." ".$person['surname']."</label><br>";
                                }
                                echo "</form>";
                            }
                            else {
                                echo "<p align='center'>К сожалению, не найдено результатов.</p>";
                            }
                        }
                        else {
                            echo "<form method='POST'>
                                <input type='submit' name='person_submit' value='Выбрать человека'><br><br>";
                            foreach ($persons as $person) {
                                echo "<label><input type='radio' name='person' value=".$person['id']."> ".$person['name']." ".$person['surname']."</label><br>";
                            }
                        }
                    ?>
                </td>
                <td>
                    <div>
                        <form method='POST'>
                            <h2>Фильтр:</h2>
                            <p>Страна:</p>
                            <select name='country'>
                                <option value='-1'>любая</option>
                                <?php
                                    foreach ($countries as $country) {
                                        echo "<option value=".$country['id'].">".$country['name']."</option>";
                                    }
                                ?>
                            </select>
                            <p>Год рождения:</p>
                            <p>c <input type='text' name='mindate' value='1800'> до <input type='text' name='maxdate' value='2040'></p>
                            <input type='submit' name='filter' value='Найти'>
                        </form>
                    </div>
                </td>
            </tr>
            <tr class='footer'>
                <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                <td></td>
                <td align='center'><h4 class='footertext'>Сергей Даниелян</h4></td>
            </tr>
        </table>
    </body>
</html>