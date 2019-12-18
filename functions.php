<?php

$dbhost = 'localhost';
$dbname = 'nanoblog';
$dbuser = 'nanobloguser';
$dbpass = 'nanobloguserpwd';
$appname = "Nanosite Blog";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error)
    die($connection->connect_error);

function createTable($name, $query) {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result)
        die($connection->error);
    return $result;
}

function destroySession() {
    $_SESSION = array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time() - 2592000, '/');

    session_destroy();
}

function sanitizeString($var) {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user) {
    echo ("
        <div class='card card-profile ml-auto mr-auto' style='max-width: 360px'>
  <div class='card-header card-header-image'>
        <a href='#pablo'>
        ");
    
    if (file_exists("media/$user.jpg"))
        echo "<img src='media/$user.jpg' class='img' style='max-height: 215px;'>";
    else echo "<img src='static/assets/img/placeholder.jpg' class='img' style='max-height: 215px;'>";
    
    echo ("
        </a>
    </div>

    <div class='card-body'>
    ");
    
    echo ("
        <h4 class='card-title'>$user</h4>
    </div>
    <div class='card-footer justify-content-center'>
    ");
    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']);
    }
    
    echo ("
    </div>
</div>
");

    
}

function showPosts($user, $published=false) {
    if ($published == true) {
        $result = queryMysql("SELECT id, title, user, published, publication_datetime FROM posts WHERE user='$user' AND published=1 ORDER BY publication_datetime");
    } else {
        $result = queryMysql("SELECT id, title, user, published, publication_datetime FROM posts WHERE user='$user' ORDER BY publication_datetime");
    }
    $num = $result->num_rows;
    echo "<div class='col-11 mx-auto border border-dark py-3' style='border-radius: 1rem;'><h4 class='text-center card-title'>$user posts</h4>";
    if ($result->num_rows) {
        echo "<div class='table-responsive'><table class='table'><thead><th>Title</th><th>Publication Date</th>";
        if ($published == false) {
            echo "<th>Published</th>";
        }
        echo "</thead><tbody>";
        for ($j = 0; $j < $num; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row['published'] == 1) {
                $is_published = 'NO';
            } else {
                $is_published = 'YES';
            }
            echo "<tr><td><a href='posts.php?view=" .
            $row['id'] . "'>" . $row['title'] . "</td> <td>" . $row['publication_datetime'] . "</td>";
            if ($published == false) {
                echo "<td>" . $is_published . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div class='col-10 mx-auto'><h6 class='card-title text-center'>No Posts yet.</h6></div>";
    }
    echo '</div>';
}

function showAllPosts() {

    $result = queryMysql("SELECT id, title, user, published, publication_datetime FROM posts WHERE published=true ORDER BY publication_datetime");
    $num = $result->num_rows;
    echo "<div class='col-11 mx-auto border border-dark py-3' style='border-radius: 1rem;'>";
    if ($result->num_rows) {
        echo "<div class='table-responsive'><table class='table'><thead><th>Title</th><th>Publication Date</th></thead><tbody>";
        for ($j = 0; $j < $num; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo "<tr><td><a href='posts.php?view=" .
            $row['id'] . "'>" . $row['title'] . "</td> <td>" . $row['publication_datetime'] . "</td></tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div class='col-10 mx-auto'><h6 class='card-title text-center'>No Posts yet.</h6></div>";
    }
    echo "</div>";
}

?>