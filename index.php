<?php
  $pageTitle = 'Homepage';
  $pageDesc = 'This week we will be using PHP to upload images';
  include './inc/header.php';
  require "database.php";
  if(isset($_POST['submit'])) {
    // Count total files
    $countfiles = count($_FILES['files']['name']);
    // Prepared statement
    $query = "INSERT INTO imagestest (name,image) VALUES(?,?)";
    $statement = $conn->prepare($query);
    // Loop all files
    for($i = 0; $i < $countfiles; $i++) {
      // File name
      $filename = $_FILES['files']['name'][$i];
      // Location
      $target_file = './uploads/'.$filename;
      // file extension
      $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
      $file_extension = strtolower($file_extension);
      // Valid image extension
      $valid_extension = array("png","jpeg","jpg");
      if(in_array($file_extension, $valid_extension)) {
        // Upload file
        if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)){
          // Execute query
          $statement->execute(
          array($filename,$target_file));
        }
      }
    }
  }
?>
  <section class="masthead">
    <div>
      <h1>Uploading Images</h1>
    </div>
  </section>
  <section class="form-row">
    <form method='post' action='' enctype='multipart/form-data'>
      <p><input type='file' name='files[]' multiple /></p>
      <p><input class="btn btn-dark" type='submit' value='Submit' name='submit'/></p>
    </form>
    <?php echo "<p>File upload successfully</p>"; ?>
    <a href="view.php" class="btn btn-primary">View Uploads</a>
  </section>
<?php require './inc/footer.php'; ?>

