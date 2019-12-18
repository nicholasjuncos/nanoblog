<?php
  require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='height: 100vh; background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
      ");
  echo "<div class='card'><h3 class='card-title text-center'>Please enter your details to log in</h3><div class='card-body'>";
  $error = $user = $pass = "";
  
  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
        $error = "Not all fields were entered<br>";
    else
    {
        $result = queryMysql("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
        
        if ($result->num_rows == 0)
        {
            $error = "<span class='error'>Username/Password invalid</span><br><br>";
        }
        else 
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = pass;
            die("You are now logged in. Please <a href='members.php?view=$user'>" .
                    "click here</a> to continue.<br><br>");
        }
    }
  }
  
  echo <<<_END
    <form method='post' action='login.php'>$error
    <span class='fieldname'>Username</span><input type='text' class='form-control' maxlength='16' 
          name='user' value='$user'><br>
    <span class='fieldname'>Password</span><input type='password' class='form-control'
          maxlength='16' name='pass' value='$pass'>
_END;
  
?>
<br>
<span class='fieldname'>&nbsp;</span>
<input type='submit' class="btn btn-primary" value='Login'>
</form></div></div></div></div></div></div>
<?php require_once 'footer.php' ?>
</body>
</html>
