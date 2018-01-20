<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="list_table.css">
    <link rel="stylesheet" href="image.css">
    <link rel="stylesheet" href="pagination.css">
    <link rel="stylesheet" href="header.css">
    <title>Artist</title>
</head>
<body>

<?php
require "mysql.php";
require "connect_db.php";
session_start();
include('logged_in_status.php');
$conn = connect();
if (logged_in()) {
    if (isset($_GET["likes"])) {
        $user_email = get_member_email();
        $user_id = getUserIdByEmail($conn, $user_email);
        $like = $_GET["likes"];
        $artist_id = $_GET["artist"];
        //sql update database
        //user like or dislike artist
        //1 for like 0 for dislike
        //var_dump($user_id);
        //var_dump($artist_id);

        if($like){
            insertLikes($conn, $user_id, $artist_id);
        } else {
            deleteLike($conn, $user_id, $artist_id);
        }
    }
}
$where = "";
$join = "";
$url_add = "";
include('navigation_bar.php');
if (isset($_GET["user"])) {
    $user = $_GET["user"];
    $uname = get_member_name();
    echo "
            <h1><span>$uname</span> liking</h1>
        ";
    $sql = "select * from User where uemail = \"$user\"";
    $conn->query($sql);
    $uid = $conn->query($sql)->fetch_assoc()["uid"];
    $join = " right join Likes on Likes.aid = Artist.aid ";
    $where = " where Likes.uid = $uid ";
} else {
    echo "<h1>Artists</h1>";
}
?>

<table id="artists">
    <tr>
        <!--<th></th>-->
        <th>Artist</th>
        <?php if (logged_in()) {
            echo "<th>Like</th>";
        } ?>
    </tr>
    <?php
    //$conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
    //include('connect_db.php');
    $conn = connect();
    $sql = "select Artist.aid, aname from Artist $join $where limit 10 offset " . (10 * ((!isset($_GET["page"]) ? 1 : $_GET["page"]) - 1));

    //echo $sql;

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $artist_id = $row["aid"];
                $artist = $row["aname"];
                //sql assign

                $like = likesStatus($conn, get_member_email(), $artist_id);
                //var_dump($like);
                echo "
                    <tr>
                        <!--<td><a href=\"songs.php?artist=$artist_id\">Image here</a></td>-->
                        <td><a href=\"songs.php?artist=$artist_id\">$artist</a></td>";
                if (logged_in()) {
                    echo "<td><a href=\"artists.php?likes=";
                    echo $like == 1 ? 0 : 1;
                    echo "&artist=$artist_id";
                    echo "\" style=\"color:";
                    echo $like == 1 ? "red" : "black";
                    echo "\">&hearts;</a></td>";
                }
                echo "</tr>";
            }
        }
    }
    ?>
</table>

<?php
$sql = "select count(*) as c from Artist $join $where ";
include('pagination.php');
?>

</body>
</html>