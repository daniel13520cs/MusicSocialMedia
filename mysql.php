<?php
/**
 * Created by PhpStorm.
 * User: chihchienhsiao
 * Date: 12/7/17
 * Time: 6:45 PM
 */


require "db.inc";
function SearchKeyword($keyword)
{
    $query = "select * from Artist natural join Track
                  where (aname LIKE \"%$keyword%\" or adesc LIKE \"%$keyword%\")
                  or ttile LIKE \"%$keyword%\");";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    dbResult($result);
}

function insertPlayRecord($uid, $pid, $ptime)
{
    $query = "INSERT INTO `Play` (`uid`, `pid`, `utime`)
                  VALUES
		          (\"$uid\", \"$pid\", \"$ptime\")";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    dbResult($result);
}


function getUserIdByEmail($conn, $userEmail)
{
    $result = $conn->query("select uid from User where uemail = \"$userEmail\"");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $userId = $row["uid"];
    return $userId;
}

function getUserIdByUsername($conn, $username)
{
    $result = $conn->query("select uid from User where username = \"$username\"");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $userId = $row["uid"];
    return $userId;
}


function insertFollow($conn, $followerEmail, $followeeEmail)
{
    //follower
    $followerUid = getUserIdByEmail($conn, $followerEmail);
    //followee
    $followedUid = getUserIdByEmail($conn, $followeeEmail);

    //echo "followerUid =";
    //echo $followerUid;
    $query = "INSERT INTO `Follow` (`follower`, `followee`, `ftime`)
                  VALUES
		          ($followerUid, $followedUid, CURRENT_TIMESTAMP())";
    //echo $query;
    return $conn->query($query);
}

function deleteFollow($conn, $followerEmail, $followeeEmail)
{
    //follower
    $followerUid = getUserIdByEmail($conn, $followerEmail);
    //followee
    $followedUid = getUserIdByEmail($conn, $followeeEmail);

    $query = "DELETE FROM Follow where follower = \"$followerUid\" and followee = \"$followedUid\"";
    return $conn->query($query);
}

function followStatus($conn, $followerEmail, $followeeEmail)
{
    $followerId = getUserIdByEmail($conn, $followerEmail);
    $followeeId = getUserIdByEmail($conn, $followeeEmail);
    //echo $followerId;
    //echo $followeeId;
    $result = $conn->query("select followee from Follow where follower = \"$followerId\" and followee = \"$followeeId\"");
    //var_dump($result);
    return ($result->num_rows == 1);
}

function insertLikes($conn, $user_id, $artist_id)
{
    $query = "INSERT INTO `LIKES` (`uid`, `aid`, `ltime`)
                    VALUES
                   ($user_id, \"$artist_id\", CURRENT_TIMESTAMP())";
    return $conn->query($query);
}

function deleteLike($conn, $user_id, $artist_id)
{
    $query = "DELETE FROM Likes where uid = $user_id and aid = \"$artist_id\"";
    return $conn->query($query);
}


function likesStatus($conn, $email, $artist_Id)
{
    $user_Id = getUserIdByEmail($conn, $email);
    //$artist_Id = getUserIdByUsername($conn, $followeeUsername);
    //echo $followerId;
    //echo $followeeId;
    $result = $conn->query("select * from Likes where uid = \"$user_Id\"and aid = \"$artist_Id\"");
    //var_dump("select * from Likes where uid = \"$user_Id\"and aid = \"$artist_Id\"");
    return ($result->num_rows == 1);
}


?>
