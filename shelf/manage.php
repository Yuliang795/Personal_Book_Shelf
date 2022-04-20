<!DOCTYPE html>


<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="./manage/manage_style.css">

<!--    icon font-->
    <link rel="stylesheet" type="text/css" href="http://at.alicdn.com/t/font_2760672_yqp8n5nvedm.css">

    <!-- bootstrap v5 -->
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <script src=./bootstrap/js/bootstrap.js></script>
    <title>Manage</title>
</head>
<body>

<section class="navbar">
    <nav id="navbar-example2" class="navbar fixed-top navbar-light bg-light px-3">
        <a class="navbar-brand" href="./shelf.php#top_header">
            <span class="clusters_icon"></span>
            Book Shelf
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="./manage.php">Manage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./upload/index.html">Upload</a>
            </li>
            <li class="nav-item">
                <form action=# method="post" enctype="multipart/form-data">
                    <input class="nav-link" type="submit" name="submitbtn" value="Scan">
                </form>
            </li>
        </ul>
    </nav>
</section>

<!--Retrieve all the books from database and display in table-->
<section class="book-manage">
    <?php
    $book_list = $_POST['selected_book'];

    if ($book_list){
        foreach ($book_list as $book){
            echo "book: ".$book;
        }
    }
    ?>

    <div class="book-list">
        <form id="book_select_form" method="post">
        <div class="operation">
            <button type="submit"  id="book_del_btn" name="del_selected"
                    class="btn btn-danger">Delete</button>
            <!-- Button trigger modal -->
<!--            <button type="button" id="t1" class="btn btn-primary" >-->
<!--                Launch demo modal-->
<!--            </button>-->
        </div>
        <table class="table align-middle table-hover" >
            <thead>
            <tr>
                <th scope="col"  >#</th>
                <th  scope="col" >Book Cover</th>
                <th  scope="col" >Book Name</th>
                <th scope="col" >Upload Date</th>
                <th scope="col" >Uploader</th>
                <th scope="col" >Select</th>
            </tr>
            </thead>
            <tbody>
            <!--            php-->
            <?php

            require_once 'connectdb.php';

            $BookQuery = 'SELECT * FROM book;';
            $AllBooksSearch = $connection -> query($BookQuery);
            //$AllBookRes = $AllBooksSearch ->fetch();

            $row_num = 1;
            while ($book = $AllBooksSearch -> fetch()){
//    echo "\n".$book['dir'].$book['BookName']."</br>";
                $CoverDir= str_replace(".pdf", ".jpg", $book['cover'].$book['BookName']);

                echo '<tr onclick="set_check_box(this)">
                <!-- row number -->
                <th scope="row">'.$row_num.'</th>
                <!-- book cover -->
                <td class="col-2 book-cover">
                    <img class="book-img" src="'.$CoverDir.'">
                </td>
                <!-- book name -->
                <td class="col-3 book-name"> '.$book['BookName'].'</td>
                <!-- upload date -->
                <td class="col-3 upload-date">'.$book['UploadDate'].'</td>
                <!-- uploader -->
                <td class="col-2 uploader">'.$book['Uploader'].'</td>
                <!-- select checkbox -->
                <td class="col-2 checkbox">
                    <input class="form-check-input" type="checkbox" disabled="disabled"
                            name="selected_book" value="'.$book['BookName'].'" aria-label="...">
                </td>
            </tr>';
                ++$row_num;
            }
            ?>
            </tbody>
        </table>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="del_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="del_modal_title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="book-del-modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" id="del_modal_btn_cancel" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="del_modal_btn_ok" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!--template for spinners-->
<template id="tem-spinners" class="">
    <div class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</template>

</body>
<script src="./manage/manage_script.js"></script>
</html>


