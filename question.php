<?php include("header.php");

if (!isset($_SESSION["loggedin"])) {
  header('location: login.php');
}
$id = $_GET['id'];
if (!$id) {
  echo "<script>
    document.location='index.php';
    </script>";
}
$find_data = "SELECT * FROM question WHERE id = '$id'";
$found_data = $con->query($find_data);
$array = $found_data->fetch_assoc();
$username = $array['username'];
$duration = $array['duration'];
$category = $array['category'];
$language = $array['language'];
$date = date('m/d/Y h:i:s', time());
$con->query("INSERT INTO history ( id, username, category, language, duration, created) VALUES ('$id', '$username', '$category', '$language ','$duration', '$date')");
$con->query("UPDATE question SET views = views + '1' WHERE id = " . $id);
?>
<div class="container">
  <div class="col-lg-12 my-4">
    <?php
    $sql = "SELECT id,content,category,duration,language,username,created FROM question WHERE id = '$id'";
    $result = $con->query($sql);
    if ($result->num_rows > 0)
      while ($row = $result->fetch_assoc()) : ?>
      <div>
        <span><?php echo $row["content"]; ?></span><br>
        <p class="text-center"><span class="badge badge-light"> Asked by <?php echo $row["username"]; ?> on <?php echo $row["created"]; ?>
            </span></p>
            <p class="text-center"><span class="badge badge-light"> Tags</span>
             <span class="badge badge-info"><?php echo $row["language"]; ?> </span>
            <span class="badge badge-warning"><?php echo $row["category"]; ?></span>
            <span class="badge badge-secondary"><?php echo $row["duration"]; ?></span>
          </p>
      </div>
    <?php
      endwhile;
    ?>
    <div class="col-lg-12 text-center">
      <form name="addform" action="postans.php" method="POST">
        <input type="hidden" name="qid" value="<?php echo $id; ?>">
        <div class="justify-content-center">
        <textarea name="content" cols="100" rows="10" required>
    Make sure you answer is precise and to the point.
  </textarea>
        </div>

        <div class="container my-4">
          <div class="row">
            <div class="col-sm">
              <select name="category" class="custom-select">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
              </select>
            </div>
            <div class="col-sm">
              <select name="duration" class="custom-select">
                <option value="0-2 min">0-2 Min</option>
                <option value="2-5 Min">2-5 Min</option>
                <option value="5-10 Min">5-10 Min</option>
              </select>
            </div>
            <div class="col-sm">
              <button type="submit" name="submit" class="btn btn-success">Post Your Answer</button>
            </div>
          </div>
        </div>
    </div>
    </form>
  </div>
</div>
</div>
</div>
</div>
<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
</body>
</html>