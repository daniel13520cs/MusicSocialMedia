<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="form.css">
    <title>Log in</title>
</head>
<body>

<?php

session_start();
include('logged_in_status.php');

if(logged_in()){
    header("Location: index.php");
    exit;
}

include('navigation_bar.php');

$email = empty($_POST["email"]) ? "" : $_POST["email"];
$password = "";
$emailErr = $passwordErr = "";
$pass = true;

include('connect_db.php');
$conn = connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!check_username($_POST["email"], $conn)){
        $emailErr = "Email not registered";
        $pass = false;
    }
    else if(!check_password($_POST["email"],  $_POST["password"], $conn)){
        $passwordErr = "Wrong password";
        $pass = false;
    }

    if($pass){
        // sql assign username, email
        $_SESSION['member_email'] = $email;
        $sql = "select * from User where uemail = \"$email\"";
        $_SESSION['member_name'] = $conn->query($sql)->fetch_assoc()["username"];
        header("Location: index.php");
        exit;
    }

}

function check_username($email, $conn){
    $sql = "select * from User where uemail = \"$email\"";
    if ($conn->query($sql)->num_rows == 1) {
        return true;
    }
    return false;
}

function check_password($email, $password, $conn){
    $sql = "select * from User where uemail = \"$email\"";
    $upwd = $conn->query($sql)->fetch_assoc()["upwd"];
    return password_verify($password, $upwd);
}

function adjust($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<form method="post" class="userinfo" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <br><label><b>Email</b></label>
    <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error"><?php echo $emailErr;?></span><br>
    <br><label><b>Password</b></label>
    <input type="password" name="password" value="<?php echo $password;?>">
    <span class="error"><?php echo $passwordErr;?></span><br>
    <br><br>
    <input type="submit" value="Log in">
</form>

</body>
</html>