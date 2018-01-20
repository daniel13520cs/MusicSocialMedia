<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="list_table.css">
    <link rel="stylesheet" href="pagination.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="button.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="navigation_bar.css">
    <title>Playlist</title>
</head>
<body>

<?php

session_start();
include('navigation_bar.php');
include('logged_in_status.php');
include('connect_db.php');
$conn = connect();

$where_status = " status = \"public\" ";
$where_email = "";
$join = "";
$url_add = "";
$add_url = "";
$is_admin = false;

if (isset($_GET["people"])) {
    $email = $_GET["people"];
    $sql = "select * from User where uemail = \"$email\"";
    $people = $conn->query($sql)->fetch_assoc()["username"];
    $dbemail =  $conn->query($sql)->fetch_assoc()["uemail"];

    $is_admin = $dbemail == get_member_email();

    echo "<h1><span>$people</span>'s playlists</h1>";
    if($is_admin){
        $where_status = "";
        echo "<a href=\"new_playlist.php\" class=\"button\">New</a><br>";
    }

    $join = " natrual join user ";
    $where_email = empty($where_status) ? " uemail = \"$email\"" : " and uemail = \"$email\"";
    $url_add = "&followee=$email";



}else {
    echo "<h1>Playlists</h1>";
}


if (isset($_GET["delete"])) {
    $list_id = $_GET["list"];
    $people = $_GET["people"];
    $email = get_member_email();
    $sql = "delete from PlaylistTrack where pid = $list_id";
    $conn->query($sql);
    $sql = "delete from Playlist where pid = $list_id";
    $conn->query($sql);

    //header("Location: playlists.php?people=$email");
}elseif(isset($_GET["add"])){
    if($_GET["add"] == 0){
        $song = $_GET["song"];
        $add_url = "playlists.php?&song=$song&add=1";
    }else{
        $song = $_GET["song"];
        $list_id = $_GET["list"];
        $sql = "insert into PlaylistTrack values(\"$list_id\", \"$song\", \"0\")";
        //insert fail
        $conn->query($sql);
        //header("Location: songs.php?list=$list_id");
    }
}


?>

<table id="playlist">

    <tr>
        <th>Name</th>
        <?php if ($is_admin) {
            echo "<th></th>";
            echo "<th>Status</th>";
        } ?>
        <th>Created</th>
    </tr>
    <?php

    $sql = "select * from Playlist $join where $where_status $where_email  limit 10 offset ".(10 * ((!isset($_GET["page"]) ? 1 : $_GET["page"]) - 1));

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $list_id = $row["pid"];
                $list = $row["ptitle"];
                $pdate = $row["pdate"];
                $status = $row["status"] == "public" ? "Public" :  "Private";

                if(empty($add_url)){
                    echo "<tr><td><a href=\"songs.php?list=$list_id";
                }else{
                    echo "<tr><td><a href=\"$add_url&list=$list_id";
                }


                if ($is_admin) {
                    $email = get_member_email();
                    echo "&member=$email";
                }

                echo "\">$list</a></td>";

                if ($is_admin) {
                    echo "<td><a href=\"playlists.php?people=$dbemail&delete=1&list=$list_id\"><i class=\"fa fa-trash\"></a></td>";
                    echo "<td>$status</td>";
                }

                echo "<td>$pdate</td></tr>";
            }
        }
    }
    ?>
</table>

<?php
$sql = "select count(*) as c from Playlist $join where $where_status  $where_email  ";
include('pagination.php');
?>

</body>
</html>