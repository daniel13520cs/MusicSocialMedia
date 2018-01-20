<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="list_table.css">
    <link rel="stylesheet" href="image.css">
    <link rel="stylesheet" href="pagination.css">
    <title>Albums</title>
</head>
<body>


<?php
session_start();
$where = "";
$join = "";
$url_add = "";
include('navigation_bar.php');
    echo "<h1>Albums</h1>";
    ?>

    <table id="albums">
        <tr>
            <!--<th></th>-->
            <th>Album</th>
            <th>Released</th>
        </tr>
        <?php

        //$conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
        include('connect_db.php');
        $conn = connect();
        $sql = "select * from Album limit 10 offset " . (10 * ((!isset($_GET["page"]) ? 1 : $_GET["page"]) - 1));


    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $album_id = $row["alid"];
                $album = $row["altitle"];
                $aldate = $row["aldate"];
//                $json = file_get_contents("https://api.spotify.com/v1/albums/".$album_id);
//                $obj = json_decode($json);
//                echo $obj->{'album_type'};
                echo "
                    <tr>
                        <!--<td><a href=\"songs . php ? album = $album_id\">image here</a></td>-->
                        <td><a href=\"songs.php?album=$album_id\">$album</a></td>
                        <td>$aldate</td>
                    </tr>
                  ";
            }
        } else {
            echo "0 results<br>";
        }
    }
    ?>
</table>

<?php
$sql = "select count(*) as c from Album";
include('pagination.php');
?>

</body>
</html>