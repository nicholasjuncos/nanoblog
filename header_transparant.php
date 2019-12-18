<?php

session_start();

echo "<!DOCTYPE html>\n<html><head>";

require_once 'functions.php';

$userstr = ' (Guest)';

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = " ($user)";
} else
    $loggedin = FALSE;

echo 
    "<title>$appname$userstr</title><meta charset='utf-8'>" .
    "<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />" .
    "<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />" .
    "<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons' />" .
    "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css'>" .
    "<link href='static/assets/css/material-kit.css' rel='stylesheet' /> " .
        "<script src='static/javascript.js' type='text/javascript'></script>" .    
  "</head>" .
  "<body><nav class='navbar navbar-color-on-scroll navbar-transparent fixed-top navbar-expand-lg bg-primary' color-on-scroll='0'>" .
  "<div class='container'>" .
      "<div class='navbar-translate'>" .
        "<a class='navbar-brand' href='index.php'>" .
        " Nano Blog </a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='sr-only'>Toggle navigation</span>
            <span class='navbar-toggler-icon'></span>
            <span class='navbar-toggler-icon'></span>
            <span class='navbar-toggler-icon'></span>
        </button>
      </div>

      <div class='collapse navbar-collapse'>
          <ul class='navbar-nav ml-auto'>
          ";

if ($loggedin)
    echo
    "<li class='nav-item'><a class='nav-link' href='members.php?view=$user'>Home</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='members.php'>Members</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='friends.php'>Friends</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='blog.php'>Blog</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='messages.php'>Messages</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='profile.php'>Profile</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='logout.php'>Log out</a></li></ul></div>";
else
    echo (
    "<li class='nav-item'><a class='nav-link' href='index.php'>Home</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign up</a></li>" .
    "<li class='nav-item'><a class='nav-link' href='login.php'>Log in</a></li></ul></div>"
    );

echo ('</div>
</nav>');
?>
