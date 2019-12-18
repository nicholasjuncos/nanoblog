<?php
require_once 'header_transparant.php';
echo ("
 <div class='page-header header-filter' style='background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
      <div class='brand text-center'>
          <h1>Your Profile</h1>
          </div></div></div></div></div>
      ");
if (!$loggedin)
    die();
echo "<div class='main main-raised pb-3'>";
$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
if (isset($_POST['text'])) {
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    if ($result->num_rows)
        queryMysql("UPDATE profiles SET text='$text' where user='$user'");
    else
        queryMysql("INSERT INTO profiles VALUES('$user', '$text')");
} else {
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $text = stripslashes($row['text']);
    } else
        $text = "";
}
$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
if (isset($_FILES['image']['name'])) {
    $saveto = "media/$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;
    switch ($_FILES['image']['type']) {
        case "image/gif":
            $src = imagecreatefromgif($saveto);
            break;
        case "image/jpeg": // Both regular and progressive jpegs
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto);
            break;
        case "image/png":
            $src = imagecreatefrompng($saveto);
            break;
        default:
            $typeok = FALSE;
            break;
    }
    if ($typeok) {
        list($w, $h) = getimagesize($saveto);
        $max = 100;
        $tw = $w;
        $th = $h;
        if ($w > $h && $max < $w) {
            $th = $max / $w * $h;
            $tw = $max;
        } elseif ($h > $w && $max < $h) {
            $tw = $max / $h * $w;
            $th = $max;
        } elseif ($max < $w) {
            $tw = $th = $max;
        }
        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(array(-1, -1, -1),
            array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}
showProfile($user);
echo <<<_END
<form class='col-10 mx-auto text-center text-dark' method='post' action='profile.php' enctype='multipart/form-data'>
<h3>Enter or edit your details and/or upload an image</h3>
<textarea class='form-control' name='text' cols='50' rows='3'>$text</textarea><br>
_END;
?>
Image: <input type='file' class="form-control" name='image' size='14'>
<input type='submit' value='Save Profile'>
</form>
<?php
showPosts($user);
echo "<div class='mt-3 text-center w-100'><a class='btn btn-primary' href='posts.php'>Create Post</a></div>";
?>
</div></div></div>
<?php require_once 'footer.php' ?>
</body>
</html>