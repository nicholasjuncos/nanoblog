<?php
require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='height: 100vh; background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
        <div class='brand text-center'>
          <h1>" .
        "Welcome to $appname</h1>" .
          '<h3 class="title text-center">
');
if ($loggedin)
    echo " $user, you are logged in.";
else
    echo ' please sign up and/or log in to join in.';
echo ('
</h3>
        </div>
      </div>
    </div>
  </div>
</div>

           ');
?>
<?php require_once 'footer.php' ?>
</body>
</html>
