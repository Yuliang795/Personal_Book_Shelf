<?php


try {
    $connection = new PDO('mysql:host=localhost;dbname=bookdb', "root", "lyp82lfhm?@!");
//    echo "database connected";
} catch (PDOException $e) {
    print "Error!: ". $e->getMessage(). "<br/>";
    die();
}
?>

