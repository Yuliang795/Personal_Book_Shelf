<?php
$data = json_decode(file_get_contents('php://input'), true);
//var_dump($data['selected_book']);

$select_book_list = "(";
foreach ($data['selected_book'] as $book){
//    echo "\n {$book} --- ".gettype($book);
    $select_book_list =$select_book_list. '"'.$book.'",';
}

$select_book_list=substr_replace($select_book_list, ")",-1 );


require_once 'connectdb.php';

$DelQuery = "DELETE FROM book WHERE book.BookName in ".$select_book_list;




//second method
$del_status_list = [];
$file_del_status_list = [];
$cover_del_status_list=[];
foreach ($data['selected_book'] as $book){
    //    del data from hard drive
    $FilePathQuery = 'SELECT dir, cover FROM book WHERE BookName="'.$book.'"';

    $FilePathQueryRes = $connection -> query($FilePathQuery);
    $File = $FilePathQueryRes->fetch();

    $pdfPath = $File['dir'].$book;
    $coverPath = $File['cover'].substr_replace($book,".jpg",strrpos( $book, '.pdf'),4);
    if (unlink($pdfPath)){
        $file_del_status_list[]=1;
    }else{$file_del_status_list[]=0;}
//    del cover
    if (unlink($coverPath)){
        $cover_del_status_list[]=1;
    }else{$cover_del_status_list[]=0;}



//    ######  del data from database
    $DelQuery = 'DELETE FROM book WHERE book.BookName="'.$book.'"';
//    echo "\n".$DelQuery;
    $result = $connection -> exec($DelQuery);
    $del_status_list[]=$result;


}

$result_json = json_encode(array(
    "result" => $del_status_list
));

echo $result_json;
//var_dump($result_json);

//problem to solve.
//The path in the sql database is the relative path to the ground directory
//at shelf. To move the del book php to its own manage folder, option(1) add
//a prefix to the directory string in the for loop/unlink, option(2) change
//all the record in the database