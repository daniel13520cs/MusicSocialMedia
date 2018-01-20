<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="list_table.css">
    <link rel="stylesheet" href="pagination.css">
    <link rel="stylesheet" href="header.css">
    <title>People</title>
</head>
<body>

<?php
require "mysql.php";
session_start();
$where = "";
$where_add = "";
$join = "";
$url_add = "";
include('logged_in_status.php');

//$conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
include('connect_db.php');
$conn = connect();

if (logged_in()) {
    if (isset($_GET["followed"])) {
        $user_id = get_member_email();
        $followed = $_GET["followed"];
        $people_id = $_GET["people"];
        //followed == 1 , follow
        // or followed == 0, unfollow
        if($followed){
            insertFollow($conn, $user_id, $people_id);
            //echo "insert";
        } else {
            deleteFollow($conn, $user_id, $people_id);
            //echo "delete";
        }

    }
}
include('navigation_bar.php');

if (isset($_GET["followee"])) {
    $email = $_GET["followee"];
    $sql = "select * from User where uemail = \"$email\"";
    $user = $conn->query($sql)->fetch_assoc()["username"];
    $user_id = $conn->query($sql)->fetch_assoc()["uid"];
    $where = " where er.followee = \"$user_id\" ";
    $url_add = "&followee=$user";
    echo "
            <h1><span>$user</span>'s Follower</h1>
        ";
} elseif (isset($_GET["follower"])) {
    $email = $_GET["follower"];
    $sql = "select * from User where uemail = \"$email\"";
    $user = $conn->query($sql)->fetch_assoc()["username"];
    $user_id = $conn->query($sql)->fetch_assoc()["uid"];
    $where = " where ee.follower = \"$user_id\" ";
    $url_add = "&follower=$user";
    echo "
            <h1><span>$user</span> Following</h1>
        ";
} else {
    echo "<h1>People</h1>";
}
?>

<table id="peoples">
    <tr>
        <th>People</th>
        <th>Follower</th>
        <th>Following</th>
        <?php if (logged_in()) {
            echo "<th></th>";
        } ?>
    </tr>
    <?php

    $sql = "select uemail, username, count(DISTINCT er.followee) as following, count(DISTINCT ee.follower) as follower
                from User as u left join Follow as er on u.uid = er.follower
                     left join Follow as ee on u.uid = ee.followee".$where."
                group by uid
                limit 10 offset ". (10 * ((!isset($_GET["page"]) ? 1 : $_GET["page"]) - 1));

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $people = $row["username"];
                $uemail = $row["uemail"];
                $follower = $row["follower"];
                $followee = $row["following"];

                //sql assign
                $followed = followStatus($conn, get_member_email(), $uemail);
                //var_dump($followed);

                echo "
                    <tr>
                        <td><a href=\"playlists.php?people=$uemail\">$people</a></td>
                        <td><a href=\"people.php?followee=$uemail\">$follower</td>
                        <td><a href=\"people.php?follower=$uemail\">$followee</td>";

                if (logged_in()) {
                    echo "<td><a href=\"people.php?followed=";
                    echo $followed == 1 ? 0 : 1;
                    echo "&people=$uemail\" style=\"color:";
                    echo $followed == 1 ? "red" : "black";
                    echo "\">&hearts;</a></td>";
                }

                echo "</tr>";
            }
        }
    }

    ?>
</table>

<?php
$sql = "select count(*) as c 
        from User as u left join Follow as er on u.uid = er.follower
        left join Follow as ee on u.uid = ee.followee ".$where;
include('pagination.php');
?>

</body>
</html>