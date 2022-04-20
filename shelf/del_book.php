<?php
$data = json_decode(file_get_contents('php://input'), true);
require_once 'connectdb.php';
// Iterate the post data of book names to form a query to get the
// storage path of the file. Delete the file and its cover in the
// target directory and then delete the data in the sql database.

$del_status_list = [];
$file_del_status_list = [];
$cover_del_status_list=[];
foreach ($data['selected_book'] as $book){
    //    del data from physical location
    // get the target paths of book and it's cover from the database
    // and then delete them by using unlink. Then the deletion result
    // will be stored in the file deletion list and send back.
    $FilePathQuery = 'SELECT dir, cover FROM book WHERE BookName="'.$book.'"';
    $FilePathQueryRes = $connection -> query($FilePathQuery);
    $File = $FilePathQueryRes->fetch();
    // path of the pdf file and it's cover
    $pdfPath = $File['dir'].$book;
    $coverPath = $File['cover'].substr_replace($book,".jpg",strrpos( $book, '.pdf'),4);
    // delete the pdf file and store result
    if (unlink($pdfPath)){
        $file_del_status_list[]=1;
    }else{$file_del_status_list[]=0;}
    //delete the corresponding cover and store result
    if (unlink($coverPath)){
        $cover_del_status_list[]=1;
    }else{$cover_del_status_list[]=0;}
    //  delete the corresponding data from database
    $DelQuery = 'DELETE FROM book WHERE book.BookName="'.$book.'"';
    $result = $connection -> exec($DelQuery);
    $del_status_list[]=$result;
}
// form the result data
$result_json = json_encode(array(
    "result" => $del_status_list
));
echo $result_json;
