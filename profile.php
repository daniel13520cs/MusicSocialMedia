<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="form.css">
    <title>Profile</title>
</head>
<body>

<?php

//$conn = new mysqli("localhost", "root", "qwewq", "MusicPlayer");
include('connect_db.php');
$conn = connect();
session_start();
include('logged_in_status.php');

//not logged in
if (!logged_in()) {
    $username = $email = $password = $city = $real_name = "";
} // logged in
else {
    $email = get_member_email();
    $sql = "select * from User where uemail = \"$email\"";
    $conn->query($sql);
    $password = "";
    $username = $conn->query($sql)->fetch_assoc()["username"];
    $city = $conn->query($sql)->fetch_assoc()["ucity"];
    $real_name = $conn->query($sql)->fetch_assoc()["realname"];;;
}

include('navigation_bar.php');

//sql here for name??

$usernameErr = $emailErr = $passwordErr = $cityErr = $real_nameErr = "";
$pass = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $usernameErr = "Username is required";
        $pass = false;
    } else {
        $username = adjust($_POST["name"]);
        if (strlen($username) < 5) {
            $usernameErr = "At less 5 letters.";
            $pass = false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers allowed";
            $pass = false;
        }
    }

    if(!isset($_GET["change"])){
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $pass = false;
        } else {
            $email = adjust($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $pass = false;
            }else{
                $sql = "select * from User where uemail = \"$email\"";
                if ($conn->query($sql)->num_rows == 1) {
                    $emailErr = "Email used";
                    $pass = false;
                }
            }
        }
    }



    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $pass = false;
    } else {
        $password = adjust($_POST["password"]);
        if (strlen($password) < 8) {
            $passwordErr = "At less 8 letters or numbers.";
            $pass = false;
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
            $passwordErr = "Password must be combinations of letters and numbers.";
            $pass = false;
        }
    }


    if ($pass) {

        $real_name = $city = "";

        if (!empty($_POST["real_name"])) {
            //sql check re
            if (false) {
                $real_nameErr = "Real_name must be combinations of letters and numbers.";
                $pass = false;
            } else {
                $real_name = $_POST["real_name"];
            }
        }

        if (!empty($_POST["city"])) {
            //sql check city
            if (false) {
                $cityErr = "Real_name must be combinations of letters and numbers.";
                $pass = false;
            } else {
                $city = $_POST["city"];
            }
        }

        $pwd = password_hash($password, PASSWORD_BCRYPT);
        if(!isset($_GET["change"])) {
            $sql = "insert into `User`(`username`, `upwd`,`uemail`, `ucity`, `realname`) 
                    values(\"$username\", \"$pwd\", \"$email\", \"$city\", \"$real_name\")";
            echo $sql;
        }else {
            $conn->query($sql);
            $email = get_member_email();
            $sql = "select * from User where uemail = \"$email\"";
            $member = $conn->query($sql)->fetch_assoc()["uid"];
            $sql = "update `User`
                    set username= \"$username\", upwd = \"$pwd\", ucity = \"$city\", realname = \"$real_name\"
                    where uid = \"$member\"";
            echo $sql;
        }
        $conn->query($sql);
        $_SESSION['member_email'] = $email;
        $_SESSION['member_name'] = $username;

        header("Location: index.php");
        exit;
    }

}

function adjust($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<form method="post" class="userinfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); if(logged_in()){echo "?change=1";}?>">
    <br><label><b>Username</b></label><span class="error">* </span>
    <input type="text" name="name" value="<?php echo $username; ?>">
    <span class="error"><?php echo $usernameErr; ?></span><br>

    <?php if(!logged_in()){
        echo "
        <br><label><b>Email</b></label><span class=\"error\">* </span>
        <input type=\"text\" name=\"email\" value=\"$email\">
        <span class=\"error\">$emailErr</span><br>
        ";
    } ?>

    <br><label><b>Password</b></label><span class="error">* </span>
    <input type="password" name="password" value="<?php echo $password; ?>">
    <span class="error"><?php echo $passwordErr; ?></span><br>
    <br><label><b>City you live</b></label>
    <input type="text" name="city" value="<?php echo $city; ?>">
    <br><br><label><b>Your name</b></label>
    <input type="text" name="real_name" value="<?php echo $real_name; ?>">
    <br><br>
    <input type="submit" value="Go">
</form>

</body>
</html>