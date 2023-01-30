<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/imgboard_view.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
  <script src ="../js/main.js"></script>
</head>
<body>
<header>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php";?>
</header>
<section>
  <div id="board_box">
<?php
    include  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";

    $num = $_GET['num'];

    $sql_mainselect = "select * from imgboard where num = $num";
    $mainresult_set = mysqli_query($con, $sql_mainselect);
    $mainrow = mysqli_fetch_array($mainresult_set);
    
    $id = $mainrow['id'];
    $name = $mainrow['name'];
    $type = $mainrow['type'];
    $price = $mainrow['price'];
    $content = $mainrow['content'];
    $best = $mainrow['best'] == "1" ? "BEST" : "";
    $new = $mainrow['new'] == "1" ? "NEW" : "";
    $delivery = $mainrow['delivery'] == "1" ? "당일배송" : "";

    $file_name = $mainrow['file_name'];
    $file_type = $mainrow['file_type'];
    $file_copied = $mainrow['file_copied'];

    $hit = $mainrow['hit'];
    $content = str_replace(" ", "&nbsp;", $content);
    $content = str_replace("\n", "<br>", $content);

    $sql_subselect = "select * from imgboard_info where num = $num";
    $subresult_set = mysqli_query($con, $sql_subselect);
    $subrow = mysqli_fetch_array($subresult_set);

    $file_subname = $subrow['file_name2'];
    $file_subtype = $subrow['file_type2'];
    $file_subcopied = $subrow['file_copied2'];

    // set hit(view)
    if ($userid !== $id) {
        $new_hit = $hit + 1;
        $sql_update = "update imgboard set hit = $new_hit where num = $num";
        mysqli_query($con, $sql_update);
    }

    $image_max_width = 550;
    $image_max_height = 550;

    // 이미지 정보 조회 > width, height, type
    if (!empty($file_name)) {
        $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" . $file_copied);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info[2];

        if ($image_width > $image_max_width){
          $image_width = $image_max_width;
        }

        if ($image_height > $image_max_height){
          $image_height = $image_max_height;
        }
    }
?>
    <ul id = "view_content">
    <li>
<?php
      if (strpos($file_type, "image") !== false) {
        echo "<img src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_copied' width='$image_width'><br>";
      } else{
        echo "
        <script>
          alert('이미지를 찾을 수 가없습니다');
        </script>";
      }
?>        
      </li>
      <li id = "item_content">
        <span><h3><?=$name?></h3></span>
        <span><h4>판매가 : <?=$price?></h4></span>
        <ul>
          <li>
            <span id = "type_best"><?=$best?></span>
            <span id = "type_delivery"><?=$delivery?></span>
            <span id = "type_new"><?=$new?></span><br>
          </li>
        </ul>
        <span><p>배송 방법 : 택배</p></span>
        <span><p><?=$content?></p></span>
        <span><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/cart/cart_server.php?num=<?=$num?>&mode=insert">
        <button type ="button" name = "cart" id="buttons1">CART</button></a></span>
        <span><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/buy/buy_server.php?num=<?=$num?>&mode=insert1">
        <button type ="button" name = "cart" id="buttons2">BUY NOW</button></a></span>
      </li>
    </ul> 
  <div id = "imginfo">
    <h2>ALREADY AWESOME</h2>
<?php
      if (strpos($file_subtype, "image") !== false) {
        echo "<img src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_subcopied'><br>";
      } else {
        echo "
        <script>
          alert('이미지를 찾을 수 가없습니다');
        </script>";
      }
?>        
  </div>
  </div>
</section>
<footer>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php";?>
</footer>
</body>
</html>