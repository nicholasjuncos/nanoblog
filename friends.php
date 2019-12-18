<?php
require_once 'header.php';
if (!$loggedin)
    die();
if (isset($_GET['view']))
    $view = sanitizeString($_GET['view']);
else
    $view = $user;
if ($view == $user) {
    $name1 = $name2 = "Your";
    $name3 = "You are";
} else {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}
echo "<div class='main main-raised pt-3' style='min-height: 87vh; margin-top: 100px;'>";
// Uncomment this line if you wish the user's profile to show here
// showProfile($view);
$followers = array();
$following = array();
$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
$num = $result->num_rows;
for ($j = 0; $j < $num; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['friend'];
}
$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
$num = $result->num_rows;
for ($j = 0; $j < $num; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $following[$j] = $row['user'];
}
$mutual = array_intersect($followers, $following);
$followers = array_diff($followers, $mutual);
$following = array_diff($following, $mutual);
$friends = FALSE;
if (sizeof($mutual)) {
    echo "<div class='col-12'><h4 class='card-title text-center'>$name2 mutual friends</h4></div><ul>";
    foreach ($mutual as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}
if (sizeof($followers)) {
    echo "<div class='col-12'><h4 class='card-title text-center'>$name2 followers</h4></div><ul>";
    foreach ($followers as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}
if (sizeof($following)) {
    echo "<div class='col-12'><h4 class='card-title text-center'>$name3 following</h4></div><ul>";
    foreach ($following as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
}
if (!$friends)
    echo "<div class='col-12'><h4 class='card-title text-center'>You don't have any friends yet.</h4></div>";
echo "<div class='col-12'><a class='btn btn-primary' href='messages.php?view=$view'>" .
 "View $name2 messages</a></div>";
?>
</div>
<?php require_once 'footer.php'?>
</body>
</html>