<?php
    function logged_in(){
        return !empty($_SESSION['member_email']);
    }

    function get_member_email(){
        return empty($_SESSION['member_email']) ? "" : $_SESSION['member_email'];
    }

    function get_member_name(){
        return empty($_SESSION['member_name']) ? "" : $_SESSION['member_name'];
    }
?>