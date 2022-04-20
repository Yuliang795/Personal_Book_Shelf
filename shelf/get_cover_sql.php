<?php
// Get the cover of the uploaded file for display AND store the book
// details into database.
// This function takes the current path and target path of the file
// and the file object as input. The first page of the pdf file is
// obtained and stored as jpg file using imagick. The cover page
// is stored in a separate path called general.info.
function cover_n_sql($cur_path,$tar_path, $File){
    $BookName=$File["file"]["name"];
    echo "\n in function\n".$cur_path."\n".$tar_path . $BookName;
    //IF target path is given, move file to target path
   if ($tar_path != NULL){
       move_uploaded_file($cur_path, $tar_path . $BookName);
       $cur_path=$tar_path;
   }
    //get cover page and store cover page to .info
    $im = new imagick($cur_path.$BookName.'[0]');
    $im->setImageFormat('jpg');
    // if pdf has blank page on the left side, cut the image
    //and take the right part of the image.
    $d = $im->getImageGeometry();
    $w = $d['width'] ;
    $h = $d['height'] ;
    if($w > $h){
        $im-> cropImage(floor($w/2), $h, floor($w/2), 0) ;
    }
    // Store the cover to the separate path general.info.
    // Modify the book storage path to get the cover storage path
    $SingleBookName=str_replace('.pdf', "", $BookName);
    // path to store file cover page is the book storage path + .info
    // i.e. $cur_path.info
    $StorePath=substr_replace($cur_path, ".info/", -1);
    // store the book cover to the path
    file_put_contents($StorePath.$SingleBookName.'.jpg', $im);

    // store pdf file details to mysql database
    include './connectdb.php';
    date_default_timezone_set('America/Toronto');
    $UploadTime = date("Y-m-d h:m:s");
    $Uploader = "doc";
    $AddBookQuery =
        'INSERT INTO book VALUES ("'.$BookName.'",
            "'.$cur_path.'",
            "'.$StorePath.'",
            "'.$UploadTime.'",
            "'.$Uploader.'")';

    $result = $connection->exec($AddBookQuery);
    $connection = NULL;
}
