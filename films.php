<?php
    $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");

    $genres_query = $mysqli->query("SELECT id, name FROM genres");
    $genres = array();
    while ($row = mysqli_fetch_array($genres_query)) {
        $genres[] = $row;
    }

    $countries_query = $mysqli->query("SELECT id, name FROM countries");
    $countries = array();
    while ($row = mysqli_fetch_array($countries_query)) {
        $countries[] = $row;
    }

    //$films = $mysqli->query("SELECT * FROM films");
    $sort = "";
    $films_query = $mysqli->query("SELECT * FROM films");
    $films = array();
    while ($row = mysqli_fetch_array($films_query)) {
        $films[] = $row;
    }
    if (isset($_POST['filter'])) {
        $b = is_numeric($_POST['minyear']) && is_numeric($_POST['maxyear']) && is_numeric($_POST['mintime']) && is_numeric($_POST['maxtime']);
        if ($b) {
            if ($_POST['sort'] == 1) {
                $sort = " ORDER BY rating_imdb DESC";
            }
            else if ($_POST['sort'] == 2) {
                $sort = " ORDER BY box_office DESC";
            }
            else if ($_POST['sort'] == 3) {
                $sort = " ORDER BY budget DESC";
            }
            $where = "WHERE year >= ".$_POST['minyear']." AND year <= ".$_POST['maxyear']." AND running_time >= ".$_POST['mintime']." AND running_time <= ".$_POST['maxtime'];
            if ($_POST['genre'] != -1) {
                $where = $where." AND genre_id = ".$_POST['genre'];
            }
            if ($_POST['country'] != -1) {
                $where = $where." AND country_id = ".$_POST['country'];
            }
            $films_query = $mysqli->query("SELECT * FROM films ".$where.$sort);
            $films = array();
            while ($row = mysqli_fetch_array($films_query)) {
                $films[] = $row;
            }
        }
    }

    if (isset($_POST['search_subm'])) {
        $val = '%'.$_POST['search'].'%';
        $films_query = $mysqli->query("SELECT * FROM films WHERE name LIKE '$val'");
        $films = array();
        while ($row = mysqli_fetch_array($films_query)) {
            $films[] = $row;
        }
    }

    if (isset($_POST['film_submit'])) {
        if (isset($_POST['film'])) {
            setcookie('id', $_POST['film'], 0);
            header("Location: film.php");
            exit();
        }
    }
?>

<!DOCTYPE html5>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinema, ????????????</title>
        <link rel="icon" type="image" href="logo.jpg">
        <!--<link rel="stylesheet" href="style.css" type="text/css">-->
    </head>
    <body>
        <table width='100%' height='100%' align='center' cellspacing='0'>
            <tr class='header'>
                <td width='25%'><p><a href='films.php' class='link'>????????????</a> <a href='persons.php' class='link'>????????</a></p></td>
                <td width=50%><a href='index.php' class='link'><strong class='title'>Cinema</strong></a></td>
                <?php
                    if (isset($_COOKIE['admin'])) {
                        $id = $_COOKIE['admin'];
                        $qqquery = $mysqli->query("SELECT id, username FROM admins WHERE id = '$id'");
                        $data = mysqli_fetch_array($qqquery);
                        $username = $data['username'];
                        echo "<td><p class='link'>".$username." <a href='logout.php' class='link'>??????????</a></p></td>";
                    }
                    else {
                        echo "<td><p><a href='auth.php' class='link'>????????</a> <a href='registration.php' class='link'>??????????????????????</a></p></td>";
                    }
                ?>
            </tr>
            <tr>
                <td></td>
                <td>
                    <form method='POST'>
                        <input type='search' name='search' placeholder='??????????'>
                        <input type='submit' name='search_subm' value='??????????'>
                    </form>
                    <?php
                        if (isset($_POST['film_submit']) && !isset($_POST['film'])) {
                            echo "<p align='center'>????????????????????, ???????????????? ??????????.</p>";
                        }
                        if (isset($_POST['filter'])) {
                            if ($b) {
                                if (count($films) != 0) {
                                    echo "<form method='POST'>
                                        <input type='submit' name='film_submit' value='?????????????? ??????????'><br><br>";
                                    foreach ($films as $film) {
                                        echo "<label><input type='radio' name='film' value=".$film['id']."> ".$film['name']." | ".$film['rating_imdb']." | $".$film['box_office']." | $".$film['budget']."</label><br>";
                                    }
                                    echo "</form>";
                                }
                                else {
                                    echo "<p align='center'>?? ??????????????????, ???? ?????????????? ??????????????????????.</p>";
                                }
                            }
                            else {
                                echo "<p align='center'>????????????????????, ?????????????? ??????????.</p>";
                            }
                        }
                        else if (isset($_POST['search_subm'])) {
                            if (count($films) != 0) {
                                echo "<form method='POST'>
                                    <input type='submit' name='film_submit' value='?????????????? ??????????'><br><br>";
                                foreach ($films as $film) {
                                    echo "<label><input type='radio' name='film' value=".$film['id']."> ".$film['name']." | ".$film['rating_imdb']." | $".$film['box_office']." | $".$film['budget']."</label><br>";
                                }
                                echo "</form>";
                            }
                            else {
                                echo "<p align='center'>?? ??????????????????, ???? ?????????????? ??????????????????????.</p>";
                            }
                        }
                        else {
                            echo "<form method='POST'>
                                <input type='submit' name='film_submit' value='?????????????? ??????????'><br><br>";
                            foreach ($films as $film) {
                                echo "<label><input type='radio' name='film' value=".$film['id']."> ".$film['name']." | ".$film['rating_imdb']." | $".$film['box_office']." | $".$film['budget']."</label><br>";
                            }
                            echo "</form>";
                        }
                    ?>
                </td>
                <td>
                    <div>
                        <form method='POST'>
                            <h2>????????????</h2>
                            <p>??????????????????????????:</p>
                            <select name='sort'>
                                <option value=0>-</option>
                                <option value=1>???? ????????????????</option>
                                <option value=2>???? ???????????????? ????????????</option>
                                <option value=3>???? ??????????????</option>
                            </select>
                            <!--<p><input type='checkbox' name='ch1' value='ch'>?????????????????????????? ???? ????????????????</p>-->
                            <p>????????:</p>
                            <select name='genre'>
                                <option value='-1'>??????????</option>
                                <?php
                                    foreach ($genres as $genre) {
                                        echo "<option value=".$genre['id'].">".$genre['name']."</option>";
                                    }
                                ?>
                            </select>
                            <p>????????????:</p>
                            <select name='country'>
                                <option value='-1'>??????????</option>
                                <?php
                                    foreach ($countries as $country) {
                                        echo "<option value=".$country['id'].">".$country['name']."</option>";
                                    }
                                ?>
                            </select>
                            <p>??????</p>
                            <p>?? <input type='text' name='minyear' value=1896> ???? <input type='text' name='maxyear' value=2030></p>
                            <p>????????????????????????</p>
                            <p>???? <input type='text' name='mintime' value='0'> ???? <input type='text' name='maxtime' value=43200></p>
                            <input type='submit' name='filter' value='??????????'>
                        </form>
                    </div>
                </td>
            </tr>
            <tr class='footer'>
                <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                <td></td>
                <td align='center'><h4 class='footertext'>???????????? ????????????????</h4></td>
            </tr>
        </table>
    </body>
</html>