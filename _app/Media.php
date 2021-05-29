<?php

class Media 
{

  public $file_path;

  public function __construct()
  {
    $this->file_path = SiteInfo::getDataDir() . '/files/';
  }

  public function upload()
  {
    
    // Make directory if its not set.
    $path = $this->file_path;
    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    }

    // Upload file. 
    $file_name = strtolower(basename($_FILES['uploaded_file']['name']));
    $file_name = str_replace(' ', '-', $file_name); // Replace spaces with dashes.
    $path = $path . $file_name;

    $acceptable = array(
      'image/jpeg',
      'image/jpg',
      'image/gif',
      'image/png'
    );

    if(in_array($_FILES['uploaded_file']['type'], $acceptable)) {

      if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {

        $file_msg = 'The file '. $path . ' has been uploaded';
        
         // Not ideal but good for now
        
        // Refresh parent on upload.
        echo "<script>window.parent.location.reload(true);</script>";

      } else {

        $file_msg = 'There was a problem with the upload.';
      }
    }
    else  {

      $file_msg = 'Bad file uploaded.';
    }
    return $file_msg;
  }

  // Browsing the file directory and 
  public function browse_files()
  {
    // Scan file directory, render the images.
    if (is_dir($this->file_path)) {
      $files = preg_grep('/^([^.])/', scandir($this->file_path));
      return $files;
    }
  
  }

}


?>