<?php
require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
      ");
if (!$loggedin)
    die();

if (isset($_GET['view'])) {
    $view = sanitizeString($_GET['view']);
    if ($view == $user) {
        $name = "Your";
        $published = false; 
    }
    else {
        $name = "$view's";
        $published = true;
    }
    echo "<div class='brand text-center'><h1>$name Profile</h3></div></div></div></div></div></div>";
    echo "<div class='main main-raised pb-3'>";
    showProfile($view);
    showPosts($view, $published);
    echo "<div class='card-body text-center'><a class='button' href='messages.php?view=$view'>" .
    "View $name messages</a></div>";
    echo ("</div></div></div></div></div></div>");
    require_once 'footer.php';
    die("</body></html>");
}
if (isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);
    $result = queryMysql("SELECT * FROM friends WHERE user='$add'
AND friend='$user'");
    if (!$result->num_rows)
        queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
} elseif (isset($_GET['remove'])) {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}
$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;
echo "<div class='main main-raised pb-3'>";
echo "<div class='card'><h3 class='card-title text-center'>Other Members</h3><div class='card-body'>";
for ($j = 0; $j < $num; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user)
        continue;
    echo "<div class='col-12'><a href='members.php?view=" .
    $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";
    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result1->num_rows;
    
    if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif ($t1) echo " &larr; you are following";
    elseif ($t2) {
        echo " &rarr; is following you";
        $follow = "recip";
    }
    if (!$t1) {
        echo " [<a href='members.php?add=" .
                $row['user'] . "'>$follow</a>]";
    } else {
        echo " [<a href='members.php?remove=" .
                $row['user'] . "'>drop</a>]";
    }
    echo "</div>";
}
?>
</div></div></div></div></div></div></div></div>
<style>.page-header.header-filter {height: 100vh;}</style>
<?php require_once 'footer.php' ?>
</body>
</html>