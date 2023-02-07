<?php


if(isset($_FILES["fileToUpload"]) ) {
    $newFileName = $book->getBookID() . ".pdf";
    $upload_msg = "";
    $target_dir =  "../..//book_files/";
    $target_file = $target_dir . $newFileName;
    $filepath = $app_root . "book_files/" . $newFileName;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  $upload_msg .=  "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($fileType != "pdf") {
  $upload_msg .=  "Sorry, only PDF's are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $upload_msg .=  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $upload_msg .=  "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    $upload_msg .= "Sorry, there was an error uploading your file.";
  }
}
} else
    $uploadOk = 0; //set flag to 0

?>