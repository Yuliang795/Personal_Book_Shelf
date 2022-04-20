<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<!--    css-->
    <link rel="stylesheet" type="text/css" href="./css/bookdisplay.css">
<!--    boot strap-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src=bootstrap/js/bootstrap.js></script>
</head>
<body>
<section id="bookdisplay">


    <div class="book-container">

        <div class="row row-cols-1 row-cols-sm-4 row-cols-md-6 g-3">
<!--            php starts here-->
            <?php
            // connect to database
            include 'connectdb.php';
            // general search -display all result
            $GeneralQuery = 'SELECT * FROM book;';

            $AllBooksSearch = $connection -> query($GeneralQuery);
            //$AllBookRes = $AllBooksSearch ->fetch();

            while ($book = $AllBooksSearch -> fetch()){
                // book cover dir
                $CoverDir= str_replace(".pdf", ".jpg", $book['cover'].$book['BookName']);
                echo
                '<div class="col">
                    <a href="'.$book['dir'].$book['BookName'].'">
                    <div class="card bg-dark text-white bookcard h-100">
                        <img src="'.$CoverDir.'" class="card-img" alt="...">
                        <div class="card-img-overlay">
                            <p class="card-title">'.$book['BookName'].'</p>
                        </div>
                    </div>
                    </a>
                </div>';


            }
            $connection = NULL;

            ?>

        </div>
    </div>
</section>
</body>
</html>
