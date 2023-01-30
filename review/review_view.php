<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/view.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
<header>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php";?>
</header>
<section>
  <div id="title_text">
    <h3>REVIEW</h3>
  </div>
  <div id="board_box">
<?php
    include  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";

    $num = $_GET['num'];
    $page = $_GET['page'];

    $sql_select = "select * from review where num = $num";
    $result_set = mysqli_query($con, $sql_select);
    $row = mysqli_fetch_array($result_set);
    
    $id = $row['id'];
    $title = $row['title'];
    $content = $row['content'];
    $regist_day = $row['regist_day'];

    $file_name = $row['file_name'];
    $file_type = $row['file_type'];
    $file_copied = $row['file_copied'];

    $hit = $row['hit'];
    $content = str_replace(" ", "&nbsp;", $content);
    $content = str_replace("\n", "<br>", $content);

    // set hit(view)
    if ($userid !== $id) {
        $new_hit = $hit + 1;
        $sql_update = "update review set hit = $new_hit where num = $num";
        mysqli_query($con, $sql_update);
    }

    $image_max_width = 450;
    $image_max_height = 550;

    // 이미지 정보 조회 > width, height, type
    if (!empty($file_name)) {
        $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/review_data/" . $file_copied);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info[2];

        if ($image_width > $image_max_width)
            $image_width = $image_max_width;

        if ($image_height > $image_max_height)
            $image_height = $image_max_height;
    }
?>
    <ul id = "view_content">
    <li>
<?php
      if (strpos($file_type, "image") !== false) {
        echo "<img src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/review_data/$file_copied' width='$image_width'><br>";
      }
?>        
      </li>
      <li id = "item_content">
        <span><h4 ><?=$title?></h4></span>
        <span><h4 >DATE : <?=$regist_day?></h4></span>
        <span><h4>ID : <?=$id?> 님</h4></span>
        <span><p><?=$content?></p></span>
      </li>
    </ul>
  </div>
  <div id="reply">
    <div id ="reply2">
      <h4>댓글</h4>
    </div>
    <div id="reply3">
<?php
    $sql_select = "select * from `review_repple` where parent = '$num'";
    $reply_result = mysqli_query($con, $sql_select);

    while($reply_row = mysqli_fetch_array($reply_result)){
      $reply_num = $reply_row['num'];
      $reply_id = $reply_row['id'];
      $reply_date = $reply_row['regist_day'];
      $reply_content = $reply_row['content'];
      
      $reply_content = str_replace("\n", "<br>", $reply_content);
      $reply_content = str_replace(" ", "&nbsp;", $reply_content);
?>
      <div id="reply_title">
        <ul>
          <li>
            <?= $reply_id . "&nbsp;&nbsp;"?></li>
            <li id ="mdi_del">
          
<?php
            if($_SESSION['id'] == "admin" || $_SESSION['id'] ==  $reply_id){
              echo "
                <form style = 'display:inline' 
                action='review_server.php' method='post'>
                <input type ='hidden' name='page' value = '".$page."'>
                <input type ='hidden' name='hit' value = '".$hit."'>
                <input type ='hidden' name='mode' value = 'delete_ripple'>
                <input type ='hidden' name='num' value = '".$reply_num."'>
                <input type ='hidden' name='parent' value = '".$num."'>
                <span>" . $reply_content . "</span>
                <span>" . $reply_date . "</span>
                <input type ='submit' value = '삭제'>
                </form>
              ";
            }else{
              echo "
              <form style='display:inline' method='post'>
              <span>" . $reply_content . "</span>
              </form>
              ";
            }

?>
          </li>
        </ul>
      </div>
<?php
          }
          mysqli_close($con);
?>
      <form action="http://<?= $_SERVER['HTTP_HOST']; ?>/ALREADY_AWESOME/review/review_server.php" method = "post" name ="repple_form">
        <input type="hidden" name = "mode" value = "insert_repple">
        <input type="hidden" name = "parent" value = "<?=$num?>">
        <input type="hidden" name = "hit" value = "<?=$hit?>">
        <input type="hidden" name = "page" value = "<?=$page?>">
        <div id="repple_insert">
          <div id="repple_textarea">
            <textarea name="ripple_content" cols="130" rows="3"></textarea>
          </div>
          <div id = "repple_button">
            <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/ALREADY_AWESOME/review/review_list.php"><button type="button"class="buttons">LIST</button></a>
            <button class="buttons">SAVE</button>
<?php
        if($_SESSION['id'] === $id && $_SESSION['id'] === "admin"){
?>
            <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/ALREADY_AWESOME/review/review_server.php?num=<?=$num?>&mode=delete&page=<?=$page?>"><button type="button" class="buttons">DELETE</button></a>
<?php
        }
?>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<footer>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php";?>
</footer>
</body>
</html>