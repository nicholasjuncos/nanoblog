<?php
require_once 'header.php';
if (!$loggedin)
    die();
if (isset($_POST['title'])) {
    $title = sanitizeString($_POST['title']);
    $subtitle = sanitizeString($_POST['subtitle']);
    $heading_1 = sanitizeString($_POST['heading_1']);
    $text_1 = sanitizeString($_POST['text_1']);
    $text_1 = preg_replace('/\s\s+/', ' ', $text_1);
    $heading_2 = sanitizeString($_POST['heading_2']);
    $text_2 = sanitizeString($_POST['text_2']);
    $text_2 = preg_replace('/\s\s+/', ' ', $text_2);
    $quote = sanitizeString($_POST['quote']);
    $quote = preg_replace('/\s\s+/', ' ', $quote);
    $quoter = sanitizeString($_POST['quoter']);
    $publication_datetime = sanitizeString($_POST['publication_datetime']);
    
    
    $publication_datetime = date_create($publication_datetime);
    $publication_datetime = date_format($publication_datetime, 'Y-m-d H:i:s');
    $published = 0;
    if ($_POST['published']) {
        $published = 1;
    }
    $error = '';
    if (isset($_POST['update'])) {
        $view = sanitizeString($_GET['view']);
        $result = queryMysql("SELECT * FROM posts WHERE id = '$view'");
        if ($result->num_rows) {
            queryMysql("UPDATE posts SET title='$title', subtitle='$subtitle', heading_1='$heading_1', text_1='$text_1', heading_2='$heading_2', text_2='$text_2', quote='$quote', quoter='$quoter', publication_datetime='$publication_datetime', published='$published' WHERE id='$view' AND user='$user'");
        }
    } elseif (isset($_POST['create'])) {
        queryMysql("INSERT INTO posts VALUES(NULL, '$user', '$title', '$subtitle', '$heading_1', '$text_1', '$heading_2', '$text_2', '$quote', '$quoter', '$publication_datetime', '$published')");
        header("Location: profile.php");
    }
}
if (isset($_GET['erase'])) {
    $erase = sanitizeString($_GET['erase']);
    queryMysql("DELETE FROM posts WHERE id=$erase AND user='$user'");
    header("Location: profile.php");
}
if (isset($_GET['view'])) {
    $view = sanitizeString($_GET['view']);
    $result = queryMysql("SELECT * FROM posts WHERE id = '$view'");
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $publisher = $row['user'];
        $published = $row['published'];
        if ($publisher == $user) {
            $is_publisher = true;
        } else {
            $is_publisher = false;
        }
        if (!$published && !$is_publisher) {
            http_response_code(404);
            die();
        } else {
            echo ("
 <div class='page-header header-filter' style='height: 100vh; background-image: url(static/assets/img/bg3.jpg)'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-8 ml-auto mr-auto'>
        <div class='brand text-center'>
          <h1>" .
        $row['title'] . "</h1>" .
          '<h3 class="title text-center">' .
              $row['subtitle'] . '
');
echo ('
</h3>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="main main-raised"><div class="container"><div class="section pt-3"><div class="row"><div class="col-12 mx-auto">

           ');
            echo "<div>";
            if ($is_publisher) {
                echo "[<a href='posts.php?view=$view" .
                "&erase=" . $row['id'] . "'>erase</a>]";
            }
            echo "<div><h6>By " . $row['user'] . " on " . $row['publication_datetime'] . "</h6></div>";
            echo "<div>";
            echo "<h3 class='title'>" . $row['heading_1'] . "</h3>";
            $text_1 = stripslashes($row['text_1']);
            echo "<p class='blog-text'>$text_1</p>";
            $quote = stripslashes($row['quote']);
            echo "<div class='blockquote undefined'>";
            echo '<p class="blog-text" style="font-size: 1.5rem;">' . $quote . '</p>';
            echo "<small>- " . $row['quoter'] . "</small>";
            echo "</div>";
            echo "</div>";
            echo "<div>";
            echo "<h3 class='title'>" . $row['heading_2'] . "</h3>";
            $text_2 = stripslashes($row['text_2']);
            
            echo "<p class='blog-text'>$text_2</p>";
            echo "</div>";
            echo "<div><a href='blog.php?view=" . $row['user'] . "'>See ". $row['user'] . "'s posts</a></div>";

            if ($is_publisher) {
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $heading_1 = $row['heading_1'];
                $text_1 = stripslashes(preg_replace('/\s\s+/', ' ', $text_1));
                $heading_2 = $row['heading_2'];
                $text_2 = stripslashes(preg_replace('/\s\s+/', ' ', $text_2));
                $quote = stripslashes(preg_replace('/\s\s+/', ' ', $quote));
                $quoter = $row['quoter'];
                $publication_datetime = date_create($row['publication_datetime']);
                $publication_datetime = date_format($publication_datetime, 'm/d/Y g:i A');
                $published = $row['published'];
                echo <<<_END
                <div id="accordion" role="tablist" class="card-collapse">
                <div class="card card-plain">
    <div class="card-header" role="tab" id="headingOne">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          Edit Post

            <i class="material-icons">keyboard_arrow_down</i>
        </a>
    </div>

    <div id="collapseOne" class="collapse hiddens" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-body">
      
    <form method='post' action='posts.php?view=$view' enctype='multipart/form-data'>
    <h3>Update details of post</h3>
    $error
    <div class='form-group'>
    <label for='title'>Title</label>
    <input type='text' class='form-control' required='required' name='title' value='$title'/>
    </div>
    <div class='form-group'>
    <label for='subtitle'>Subtitle</label>
    <input type='text' class='form-control' name='subtitle' value='$subtitle'/>
    </div>
    <div class='form-group'>
    <label for='heading_1'>Heading 1</label>
    <input type='text' class='form-control' name='heading_1' value='$heading_1'/>
    </div>
    <div class='form-group'>
    <label for='text_1'>Text area 1</label>
    <textarea name='text_1' class='form-control' required='required' cols='50' rows='3'>$text_1</textarea>
    </div>
    <div class='form-group'>
    <label for='heading_2'>Heading 2</label>
    <input type='text' class='form-control' name='heading_2' value='$heading_2'/>
    </div>
    <div class='form-group'>
    <label for='text_2'>Text area 2</label>
    <textarea name='text_2' class='form-control' cols='50' rows='3'>$text_2</textarea>
    </div>
    <div class='form-group'>
    <label for='quote'>Quote</label>
    <textarea name='quote' class='form-control' cols='50' rows='3'>$quote</textarea>
    </div>
    <div class='form-group'>
    <label for='quoter'>Quoter</label>
    <input type='text' class='form-control' name='quoter' value='$quoter'/>
    </div>
    <div class='form-group'>
    <label for='publication_datetime'>Publication date/time</label>
    <input id='datetimepicker' type="text" name='publication_datetime' class='form-control datetimepicker' value='$publication_datetime'/>
    </div>
    <div class='form-group'>
_END;
                if ($published == 1) {
                    echo "<input style='margin-top: 1rem;' type='checkbox' name='published' checked='true'> Published<br>";
                } else {
                    echo "<input style='margin-top: 1rem;' type='checkbox' name='published'> Published<br>";
                }
                echo "</div><input type='hidden' name='update' value='true'/><input type='submit' value='Update Post'/> </form></div>
    </div>
  </div></div></div></div></div>";
            }
        }
    } else {
        echo '<div class="main main-raised" style="margin-top: 100px;"><h3 class="card-title text-center p-3">No Post found.</h3></div></div></div></div></div>';
    }
} else {
    echo <<<_END
    <div class='main main-raised' style='min-height: 87vh; margin-top: 100px;'>
    <form method='post' action='posts.php' enctype='multipart/form-data'>
    <h3>Enter details for post</h3>
    $error
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='title'>Title</label>
    <input type='text' required='required' name='title'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='subtitle'>Subtitle</label>
    <input type='text' name='subtitle'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='heading_1'>Heading 1</label>
    <input type='text' name='heading_1'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='text_1'>Text area 1</label>
    <textarea name='text_1' required='required' cols='50' rows='3'></textarea>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='heading_2'>Heading 2</label>
    <input type='text' name='heading_2'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='text_2'>Text area 2</label>
    <textarea name='text_2' cols='50' rows='3'></textarea>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='quote'>Quote</label>
    <textarea name='quote' cols='50' rows='3'></textarea>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='quoter'>Quoter</label>
    <input type='text' name='quoter'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <label for='publication_datetime'>Publication date/time</label>
    <input type="text" name='publication_datetime' class='datetimepicker'/>
    </div>
    <div style='margin-top: 1rem; margin-bottom: 1rem;'>
    <input style='margin-top: 1rem;' type="checkbox" name="published"> Published<br>
    </div>
    <input type='hidden' name='create' value='true'/>
    <input type='submit' value='Create Post'/>        
    </form>
            </div>
_END;
}
?>
</div>
</div>
</div>
<?php require_once 'footer.php';?>
</body>
<script type='text/javascript'>
    $(function () {
        $('.datetimepicker').datetimepicker();
    });
</script>
</html>

