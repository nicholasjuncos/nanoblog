<?php
require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='height: 100vh; background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
      ");
  echo "<div class='card'><div class='card-body'><h3 class='card-title text-center'>";
if (isset($_SESSION['user'])) {
    destroySession();
    echo "You have been logged out. Please " .
    "<a href='index.php'>click here</a> to refresh the screen.";
} else
    echo "" .
    "You cannot log out because you are not logged in";
?>
</h3>
</div>
</div>
</div>
</div>
</div>
</div>
<?php require_once 'footer.php'?>
</body>
</html>

