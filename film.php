<?php
    $mysqli = new mysqli("localhost", "SergeyDanielyan", "rfQrBSHLCQHKFwbt", "cinema");
    $id = $_COOKIE['id'];
    $film_query = $mysqli->query("SELECT * 
        FROM films 
        WHERE id = '$id'");
    $film = mysqli_fetch_array($film_query);
    $genre_id = $film['genre_id'];
    $genre_query = $mysqli->query("SELECT * FROM genres WHERE id = '$genre_id'");
    $genre = mysqli_fetch_array($genre_query);
    $country_id = $film['country_id'];
    $country_query = $mysqli->query("SELECT * FROM countries WHERE id = '$country_id'");
    $country = mysqli_fetch_array($country_query);
    $dir_id = $film['director_id'];
    $director_query = $mysqli->query("SELECT * 
        FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
        WHERE profession_id = 1 AND film_id = '$id'");
    $row = mysqli_fetch_array($director_query);
    $directors = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($director_query)) {
        $directors = $directors.", ".$row['name']." ".$row['surname'];
    }
    $screenwriter_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 2 AND film_id = '$id'");
    $row = mysqli_fetch_array($screenwriter_query);
    $screenwriters = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($screenwriter_query)) {
        $screenwriters = $screenwriters.", ".$row['name']." ".$row['surname'];
    }
    $producer_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 3 AND film_id = '$id'");
    $row = mysqli_fetch_array($producer_query);
    $producers = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($producer_query)) {
        $producers = $producers.", ".$row['name']." ".$row['surname'];
    }
    $operator_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 4 AND film_id = '$id'");
    $row = mysqli_fetch_array($operator_query);
    $operators = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($operator_query)) {
        $operators = $operators.", ".$row['name']." ".$row['surname'];
    }
    $composer_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 5 AND film_id = '$id'");
    $row = mysqli_fetch_array($composer_query);
    $composers = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($composer_query)) {
        $composers = $composers.", ".$row['name']." ".$row['surname'];
    }
    $actor_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 6 AND film_id = '$id'");
    $actors = "";
    while ($row = mysqli_fetch_array($actor_query)) {
        $actors .= "<tr><td>".$row['name']." ".$row['surname']."</td><td>".$row['role_name']."</td></tr>";
    }
    $artdirector_query = $mysqli->query("SELECT * 
    FROM cin_persons INNER JOIN film_person ON person_id = cin_persons.id 
    WHERE profession_id = 7 AND film_id = '$id'");
    $row = mysqli_fetch_array($artdirector_query);
    $artdirectors = $row['name']." ".$row['surname'];
    while ($row = mysqli_fetch_array($artdirector_query)) {
        $artdirectors = $artdirectors.", ".$row['name']." ".$row['surname'];
    }
    $runnning_time = $film['running_time'];
    if ($film['running_time'] % 10 >= 2 && $film['running_time'] % 10 <= 4) {
        $runnning_time .= " ????????????";
    }
    else if ($film['running_time'] % 10 == 1) {
        $runnning_time .= " ????????????";
    }
    else {
        $runnning_time .= " ??????????";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <?php
            echo "<title>".$film['name']." - Cinema</title>";
        ?>
        <link rel="icon" type="image" href="logo.jpg">
        <link rel="stylesheet" href="object.css" type="text/css">
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
                <td colspan='3'>
                    <?php
                        echo "<h1 title align=center class='ttitle'>".$film['name']."</h1>
                        <div class='image'>
                            <img src=".$film['photo_link'].">
                            <p>???????????????????????? ????????????????: ".$film['original_name']."</p>
                            <p>????????: ".$genre['name']."</p>
                            <p>????????????????: ".$directors."</p>
                            <p>????????????????: ".$producers."</p>
                            <p>??????????????????: ".$screenwriters."</p>
                            <p>????????????????: ".$operators."</p>
                            <p>????????????????????: ".$composers."</p>
                            <p>????????????????-??????????????????????: ".$artdirectors."</p>
                            <p>????????????????????????: ".$runnning_time."</p>
                            <p>????????????: $".$film['budget']."</p>
                            <p>??????????: $".$film['box_office']."</p>
                            <p>????????????: ".$country['name']."</p>
                            <p>????????: ".$film['main_language']."</p>
                            <p>??????: ".$film['year']."</p>
                            <p>?????????????? IMDb: ".$film['rating_imdb']."</p>
                            <p><a href=".$film['film_link'].">???????????? ???? ??????????</a></p>
                        </div>
                        <div class='text'>
                            <p>".$film['description']."</p>
                            <h3 align=center>?? ??????????: </h3>
                            <table border='1' width='100%' cellpadding='5'>
                                <tr>
                                    <th>??????????</th>
                                    <th>????????</th>
                                </tr>".
                                $actors
                            ."</table>
                        </div>";
                    ?>
                </td>
            </tr>
            <tr>
                <td align='center'><h3 class='footertext'>Cinema, 2021</h3></td>
                <td></td>
                <td align='center'><h4 class='footertext'>???????????? ????????????????</h4></td>
            </tr>
        </table>
    </body>
</html>