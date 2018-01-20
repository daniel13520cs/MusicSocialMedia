<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="list_table.css">
    <link rel="stylesheet" href="pagination.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="header.css">
    <title>Songs</title>
    <style>
        .checked {
            color: orange;
        }
    </style>
</head>
<body>

<?php

session_start();

include('navigation_bar.php');
include('logged_in_status.php');

//$conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
include('connect_db.php');
$conn = connect();
if (logged_in()) {
    if (isset($_GET["rating"])) {
        $rating = $_GET["rating"];
        $track_id = $_GET["song"];
        //sql update database
        //rating change
    }
}

$where = "";
$join = "";
$member_join = "";
$member_where = "";
$member_select = "";
$url_add = "";
$is_member = false;

if (isset($_GET["artist"])) {
    $aid = $_GET["artist"];
    $sql = "select * from Artist where aid = \"$aid\"";
    $aname = $conn->query($sql)->fetch_assoc()["aname"];
    $where = " where aid=\"$aid\" ";
    $url_add = "&artist=$aid";
    echo "<h1><span>$aname</span>'s Music</h1>";

} elseif (isset($_GET["album"])) {
    $alid = $_GET["album"];
    $sql = "select * from Album where alid = \"$alid\"";
    $altitle = $conn->query($sql)->fetch_assoc()["altitle"];
    $aldate = $conn->query($sql)->fetch_assoc()["aldate"];
    $where = " where Track.alid=\"$alid\" ";
    $url_add = "&album=$alid";
    echo "<h1>Songs in <span>$altitle</span></h1><p>Release on $aldate</p>";
} elseif (isset($_GET["list"])) {
    $list_id = $_GET["list"];
    $sql = "select * from Playlist where pid = \"$list_id\"";
    $ptitle = $conn->query($sql)->fetch_assoc()["ptitle"];
    $pdate = $conn->query($sql)->fetch_assoc()["pdate"];
    $join = " left join PlaylistTrack on PlaylistTrack.tid = Track.tid ";
    $where = " where pid=\"$list_id\" ";
    $url_add = "&list=$list_id";

    echo "<h1>Songs in <span>$ptitle</span></h1><p>Created on $pdate</p>";
} elseif (isset($_GET["search"])) {
    $keyword = $_GET["search"];
    $type = $_GET["searchType"];
    //too slow..
    if ($type == "song") {
        $where = " where Track.ttitle like \"%$keyword%\"";
    } elseif ($type == "genre") {
        $where = " where Artist.adesc like \"%$keyword%\"";
    } elseif ($type == "artist") {
        $where = " where Artist.aname like \"%$keyword%\"";
    } elseif ($type == "album") {
        $where = " where Album.altitle like \"%$keyword%\"";
    }

    echo "<h1>Search: <span>$keyword</span></h1>";
} else {
    echo " <h1>Songs </h1> ";
}


if (logged_in()) {
    $email = get_member_email();
    $sql = "select * from User where uemail = \"$email\"";
    $people = $conn->query($sql)->fetch_assoc()["uid"];
    $member_join = "  left join Rate on Rate.tid = Track.tid";
    $member_where = empty($where) ? " where Rate.uid=$people or Rate.uid is null" : " and (Rate.uid=$people or Rate.uid is null)";
    $member_select = ", rating";
    $is_member = true;
}

if (isset($_GET["delete"])) {
    $track_id = $_GET["song"];
    $list_id = $_GET["list"];
    $sql = "delete from PlaylistTrack where pid = \"$list_id\" && tid = \"$track_id\"";
    $conn->query($sql);
    //sql delete where id
} elseif (isset($_GET["rating"])) {
    $email = get_member_email();
    $sql = "select * from User where uemail = \"$email\"";
    $member = $conn->query($sql)->fetch_assoc()["uid"];
    $date = date('Y-m-d H:i:s');
    $rating = $_GET["rating"];
    $song = $_GET["song"];
    $sql = "replace into `Rate` values(\"$member\", \"$song\", \"$rating\", \"$date\")";
    $conn->query($sql);
}
?>

<table id="songs">
    <tr>
        <th>Song</th>
        <th>Artist</th>
        <th>Album</th>
        <?php if (logged_in()) {
            echo "<th>Rating</th><th>Add to playlist</th>";
        } ?>
        <?php if (isset($_GET["member"])) {
            echo "<th></th>";
        } ?>
    </tr>
    <?php
    $sql = "select Track.tid as tid, Track.ttitle, Track.aname, altitle, aid, Track.alid" . $member_select . "
                from Track left join Artist on Track.aname = Artist.aname 
                left join Album on Track.alid = Album.alid" . $join . $member_join . $where . $member_where . "
                limit 10 offset " . (10 * ((!isset($_GET["page"]) ? 1 : $_GET["page"]) - 1));

    //echo $sql;

    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $track_id = $row["tid"];
                $artist = $row["aname"];
                $album = $row["altitle"];
                $artist_id = $row["aid"];
                $album_id = $row["alid"];
                $track_duration;


                echo " <tr>
                    <td>
                     <iframe src=\"https://open.spotify.com/embed?uri=spotify:track:$track_id\" width=\"500\" height=\"100\" frameborder=\"0\" allowtransparency=\"true\"></iframe>
                    </td>
                    <td><a href=\"songs.php?artist=$artist_id\">$artist</a></td>
                    <td><a href=\"songs.php?album=$album_id\">$album</a></td>";

                if (logged_in()) {
                    echo "<td>";
                    $rating = $row["rating"];
                    for ($j = 1; $j <= $rating; $j++) {
                        echo "<a href=\"songs.php?rating=$j&song=$track_id$url_add\"><span class=\"fa fa-star checked\"></span></a>";
                    }
                    for ($j = $rating + 1; $j <= 5; $j++) {
                        echo "<a href=\"songs.php?rating=$j&song=$track_id$url_add\"><span class=\"fa fa-star\"></span></a>";
                    }

                    echo "</td>";

                    echo "<td><a href=\"playlists.php?add=0&song=$track_id\">+</a></td>";
                }

                if (isset($_GET["member"])) {
                    $member = get_member_email();
                    echo "<td><a href=\"songs.php?member=$member&delete=1&song=$track_id&list=$list_id\"><i class=\"fa fa-trash\"></a></td>";
                }

                echo "</tr>";
            }
        }
    }
    ?>
</table>

<?php
$sql = "select count(*) as c from Track left join Artist on Track.aname = Artist.aname 
                left join Album on Track.alid = Album.alid".$join.$where;
//echo $sql;
include('pagination.php');
?>

</body>
</html>