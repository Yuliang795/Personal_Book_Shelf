<?php
//header('Content-Type: text/html; charset=utf-8');
// Define allowd uploading types/extensions in the array. And get the file
// extension name of the uploading files.
$allowedExts = array("png","jpeg", "pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

// Check if the uploading files follow the rulse. If passed, the file
// will firstly be recorded in database and then move to target storage
// path
if ((($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "application/pdf"))
    && ($_FILES["file"]["size"] < 50000000)  // file size smaller than 50mb
    && in_array($extension, $allowedExts))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "\nError：: " . $_FILES["file"]["error"] . "<br>";
        }
        else {

            //check if the uploading file already exists in target directory.
            // If the file already exists, display the error.
            include './connectdb.php';
            $CheckUniqueQuery =
                'SELECT EXISTS 
                    (SELECT * FROM book 
                    WHERE BookName="'.$_FILES["file"]["name"].'") as res';
//
            $CheckUnique = $connection -> query($CheckUniqueQuery);
            $result = $CheckUnique->fetch();
            // if the result is greater than 0, then the file is already
            // existing in the database.
            if ($result['res']>0)
            {
                echo $_FILES["file"]["name"] . ": this file already in database";
                header('Error: File already exists', true, 500);
            }
            else
            {
                // record the file details in database and store the file in
                // the target path
                $cur_path = $_FILES["file"]["tmp_name"];
                $tar_path="./books/general/";
//                include the upload function
                include './get_cover_sql.php';
                echo $cur_path."\n".$_FILES["file"]["name"]."\n";
                cover_n_sql($cur_path,$tar_path,$_FILES);
            }
        }

    }else{
    // For file that dose not pass the criteria, report error.
    echo " \n incorrect file ";
    header('Error: incorrect file', true, 500);

}

?>