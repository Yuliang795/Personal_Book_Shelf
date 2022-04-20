<?php
$dir = "./books/general/";
$handler = opendir($dir);
while (($filename = readdir($handler)) !== false)
{
    // 务必使用!==，防止目录下出现类似文件名“0”等情况
    if ($filename !== "." && $filename !== "..")
    {
        $files[] = $filename ;
    }
}
closedir($handler);
// 打印所有文件名 upload to mysql

// get cover function
//$path = './books/linux/Linux Command Line and Shell Scripting Bible.pdf';
function StoreCover($BookPath, $BookName, $StorePath){

    $im = new imagick($BookPath.$BookName.'[0]');
    $im->setImageFormat('jpg');
    // delet the ".pdf"
    $BookName=str_replace('.pdf', "", $BookName);
    file_put_contents($StorePath.$BookName.'.jpg', $im);
}
// connect to database
include 'connectdb.php';

date_default_timezone_set('America/Toronto');
echo date_default_timezone_get();
//echo "The time is " . date("Y-m-d h:i:s");
$UploadTime = date("Y-m-d h:m:s");
$Uploader = "doc";
$BookPath="./books/general/";
$CoverPath ="./books/general.info/";
foreach ($files as  $value) {
//    echo $value.'<br>';
//    $value = str_replace('.pdf', "", $value);
    echo $value.'<br>';

    // store data in database
    $AddBookQuery =
        'INSERT INTO book VALUES ("'.$value.'",
            "'.$BookPath.'",
            "'.$CoverPath.'",
            "'.$UploadTime.'",
            "'.$Uploader.'")';
//    echo $AddBookQuery;
    $result = $connection->exec($AddBookQuery);

    // store cover to info folder
    StoreCover($BookPath,$value,$CoverPath);

}
// disconnect from query
$connection = NULL;
