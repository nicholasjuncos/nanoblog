<?php
require_once 'header.php';
if (!$loggedin)
    die();
echo "<div class='main main-raised' style='min-height: 87vh; margin-top: 100px;'>";
if (isset($_GET['view'])) {
    $view = sanitizeString($_GET['view']);
    if ($view == $user) {
        $name = "Your";
        $published = false;
    } else {
        $name = "$view's";
        $published = true;
    }
    echo "<h3 class='card-title text-center pt-3'>$name Blog</h3>";
    showProfile($view);
    showPosts($view, $published);
//    echo "<a class='button' href='messages.php?view=$view'>" .
//    "View $name messages</a><br><br>";
    echo "</div>";
    require_once 'footer.php';
    die("</body></html>");
}
if (isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);
    queryMysql("INSERT INTO posts VALUES ('$add', '$title', '$subtitle', '$heading_1', '$text_1', '$heading2', '$text2', '$quote', '$quoter', '$publication_datetime')");
} elseif (isset($_GET['remove'])) {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM posts WHERE user='$remove' AND id='$id'");
}
$result = queryMysql("SELECT user FROM members ORDER BY user");
//$result = queryMysql("SELECT title, publication_datetime FROM posts ORDER BY publication_datetime");
$num = $result->num_rows;
echo "<h3 class='card-title text-center pt-3'>All Posts</h3>";
showAllPosts();
?>
</div>
<?php require_once 'footer.php'?>
</body>
</html>