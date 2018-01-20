<?php
    session_start();
    include('logged_in_status.php');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="navigation_bar.css">
    <link rel="stylesheet" href="home_buttons.css">
    <link rel="stylesheet" href="button.css">
    <title>Music</title>
</head>

<body>


<?php
    // not user or just logged out
    if(!logged_in() || (isset($_GET["logout"]) && $_GET["logout"] == true)) {
        $_SESSION['member_email'] = "";
        $_SESSION['member_name'] = "";
        include('navigation_bar.php');

        echo "

            <div id = \"imgdiv\" ><img src=\"m.jpg\" id=\"mp\"></div>
            <div id = \"btndiv\" > 
                    <a href = \"profile.php\" class=\"button\" > Sign up </a > 
                    <a href = \"login.php\" class=\"button\" id = \"login\" > Log in </a > 
            </div > ";
    }
    // logged in
    else{
        include('navigation_bar.php');
        $email = get_member_email();
        echo "
            <div id = \"imgdiv\" ><img src=\"m.jpg\" id=\"mp\"></div>
            <table>
            <tr>
                <td><a href=\"playlists.php?people=$email\" class=\"button\" id='my'>My Playlist</a></td>
                <td><a href=\"artists.php?user=$email\" class=\"button\">My Artists</a></td>
            </tr>
            <tr>
                <td><a href=\"people.php?follower=$email\" class=\"button\">Following</a></td>
                <td><a href=\"people.php?followee=$email\" class=\"button\">Followers</a></td>
            </tr>
            <tr>
                <td><a href=\"profile.php\" class=\"button\" id=\"profile\">Profile</a></td>
                <td><a href= ".htmlspecialchars($_SERVER["PHP_SELF"])."?logout=true class=\"button\" id=\"logout\">Log out</a></td>
            </tr>
        </table>";
    }


?>
</body>
</html>