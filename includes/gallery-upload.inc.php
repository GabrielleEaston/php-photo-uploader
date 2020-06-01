<?php

if (isset($_POST['submit'])) {

  $newFileName = $_POST['filename'];

  $imageTitle = $_POST['filetitle'];
  $imageDesc = $_POST['filedesc'];

  $file = $_FILES['file'];

  $fileName = $file["name"];
  $fileType = $file["type"];
  $fileTempName = $file["tmp_name"];
  $fileSize = $file["size"];
 
  $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
  $fileDestination = "../img/gallery/" . $imageFullName;

  include_once "dbh.inc.php";
  $sql = "SELECT * FROM gallery;";
  $stmt = mysqli_stmt_init($conn);
   if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed!";
          } else {
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            $setImageOrder = $rowCount + 1;

            $sql = "INSERT INTO gallery (titleGallery, descGallery, imgFullNameGallery, orderGallery) VALUES (?, ?, ?, ?);";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "SQL statement failed!";
            } else {
              mysqli_stmt_bind_param($stmt, "ssss", $imageTitle, $imageDesc, $imageFullName, $setImageOrder);
              mysqli_stmt_execute($stmt);

              move_uploaded_file($fileTempName, $fileDestination);

              header("Location: ../index.php?upload=success");
            }
          }
    
   
    


}
