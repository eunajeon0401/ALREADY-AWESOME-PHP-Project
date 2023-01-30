<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/create_statement.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="./css/main.css?after" >
  <script src="./js/main.js"></script>
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body onload="call_js()">
  <header>
    <?php include "header.php";?>
  </header>
  <section>
    <?php include "main.php";?>
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>
</html>