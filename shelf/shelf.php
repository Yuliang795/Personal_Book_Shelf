<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!--    css-->
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/bookdisplay.css">

    <!--    boot strap-->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src=bootstrap/js/bootstrap.js></script>
<title>Book Shelf</title>
</head>
<body>

<section class="navbar">
    <nav id="navbar-example2" class="navbar fixed-top navbar-light bg-light px-3">
        <a class="navbar-brand" href="#top_header">
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

<section class="bookdisplaysec">
<?php
include 'displaybooksec.php';
?>
</section>

</body>
</html>

