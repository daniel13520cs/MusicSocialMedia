<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="form.css">
    <title>New Playlist</title>
</head>
<body>

<?php
    $conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
    session_start();
    include('logged_in_status.php');


    $pname = $status = "";
    $pnameErr = $statusErr = "";

    include('navigation_bar.php');

    $pass = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $pnameErr = "Playlist name is required";
            $pass = false;
        }
        else {
            $pname = adjust($_POST["name"]);
            if (!preg_match("/^[a-zA-Z0-9]*$/",$pname)) {
                $pnameErr = "Only letters and numbers allowed";
                $pass = false;
            }
        }

        if (empty($_POST["type"])) {
            $statusErr = "Type is required";
            $pass = false;
        }
        else {
            $status = adjust($_POST["type"]);
        }


        if($pass){
            $date = date('Y-m-d H:i:s');
            $email = get_member_email();
            $sql = "select * from User where uemail = \"$email\"";
            $uid = $conn->query($sql)->fetch_assoc()["uid"];
            $sql = "insert into `Playlist`(`ptitle`, `pdate`,`uid`,`status`) values(\"$pname\", \"$date\", \"$uid\", \"$status\")";
            $conn->query($sql);
            header("Location: playlists.php?people=$email");
            exit;
        }


    }

    function adjust($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<form method="post" class="userinfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <br><label><b>Playlist Name</b></label><span class="error">* </span>
    <input type="text" name="name" value="<?php echo $pname;?>">
    <span class="error"><?php echo $pnameErr;?></span><br>

    <br><label><b>Type:</b></label><span class="error">* </span>
        <input type="radio" name="type"
            <?php if (isset($status) && $status == "public") echo "checked"; ?>
               value="public">Public
        <input type="radio" name="type"
            <?php if (isset($status) && $status == "private") echo "checked"; ?>
               value="private">Private
        <span class="error"><?php echo $statusErr; ?></span><br>
        <br>

    <input type="submit" value="Go">
</form>

</body>
</html>