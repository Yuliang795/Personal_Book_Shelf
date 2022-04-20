<div class="book-container">
    <div class="row row-cols-1 row-cols-sm-4 row-cols-md-6 g-3">
        <!--            php starts here-->
        <?php
        // connect to database
        include 'connectdb.php';
        // Query the database to get the information of all files
        $GeneralQuery = 'SELECT * FROM book;';
        $AllBooksSearch = $connection -> query($GeneralQuery);
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