<?php
  require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='height: 100vh; background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
        ");
  
  echo <<<_END
    <script>
      function checkUser(user)
      {
        if (user.value == '')
        {
          O('info').innerHTML = ''
          return
        }
  
        params = "user=" + user.value
        request = new ajaxRequest()
        request.open("POST", "checkuser.php", true)
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        request.setRequestHeader("Content-length", params.length)
        request.setRequestHeader("Connection", "close")
  
        request.onreadystatechange = function()
        {
          if (this.readyState == 4)
            if (this.status == 200)
              if (this.responseText != null)
                O('info').innerHTML = this.responseText
        }
        request.send(params)
      }
  
      function ajaxRequest()
      {
        try { var request = new XMLHttpRequest() }
        catch(e1) {
          try { request = new ActiveXObject("Msxml2.XMLHTTP") }
          catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") }
            catch(e3) {
              request = false
            } 
          }
        }
        return request
      }
    </script>
    <div class='card'><h3 class='card-title text-center'>Please enter your details to sign up</h3>
_END;
  
  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) destroySession();
  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br><br>";
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");
      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      else
      {
        queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die("<h4 class='text-center'>Account created</h4><h5 class='text-center'>Please Log in.</h5>");
      }
    }
  }
  
  echo <<<_END
    <form class='card-body' method='post' action='signup.php'>$error
    <span class='fieldname'>Username</span>
    <input type='text' class='form-control' maxlength='16' name='user' value='$user'
      onBlur='checkUser(this)'><span id='info'></span><br>
    <span class='fieldname'>Password</span>
    <input type='text' maxlength='16' name='pass' class='form-control'
      value='$pass'><br>
_END;
?>
    <span class='fieldname'>&nbsp;</span>
    <input type='submit' class="btn btn-primary" value='Sign up'>
    </form></div>
    </div>
    </div>
  </div>
    </div>
    <?php require_once 'footer.php'?>
    </body>
</html>
