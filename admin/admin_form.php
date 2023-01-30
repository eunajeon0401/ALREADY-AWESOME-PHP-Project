<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/admin.css?after" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
<?php 
  include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php"; 
  
  if(empty($_SESSION['id']) && $_SESSION['id'] =="admin"){
    echo "
    <script>
      alert('사용 권환이 없습니다');
      history.go(-1)
    </script>
    ";
    exit();
  }
?>
  </header>
  <section>
    <div id="admin_box">
      <div id="main_title">
        <h3 id="title">
          ADMIN
        </h3>
      </div>
      <ul class ="list_title">
        <li class = "list_title2" >
          <span >NO</span>
          <span>ID</span>
          <span>NAME</span>
          <span>LEVEL</span>
          <span>POINT</span>
          <span>REGIST DAY</span>
          <span>UPDATE</span>
          <span>DELETE</span>
        </li>
<?php
         include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";
         $sql = "select * from members order by num desc";
         $result = mysqli_query($con, $sql);
         $total_record = mysqli_num_rows($result);

         $number = $total_record;

         while($row = mysqli_fetch_array($result)){
          $num = $row["num"];
          $id = $row["id"];
          $name = $row["name"];
          $level = $row["level"];
          $point = $row["point"];
          $regist_day = $row["regist_day"];
          $email = $row["email"];
?>
        <li id="input">
          <form action="admin_server.php?mode=update" method = "post">
            <input type="hidden" name="num" value ="<?=$num?>">
            <span id = "input1"><?=$number?></span>
            <span id="input2"><?=$id?></span>
            <span id="input3"><?=$name?></span>
            <span id="input4"><input type="text" name="level" value = "<?=$level?>"></span>
            <span id="input5" ><input type="text" name="point" value = "<?=$point?>"></span>
            <span id="input6"><?=$regist_day?></span>
            <span id="input7"><button type="submit">수정</button></span>
            <span id="input8"><button type = "button" onclick="location.href='admin_server.php?mode=delete&num=<?=$num?>'">삭제</button></span>
         </form>
        </li>
<?php
       $number--;
     }
?>
      </ul>
      <ul id = "subtitle1">
        <h4 id = "subtitle2">
           ADMIN > REVIEW
        </h4>
      </ul>
      <ul class="list_title">
        <li class = "list_title2 ">
          <span>CHECK</span>
          <span>NO</span>
          <span>NAME</span>
          <span>TITLE</span>
          <span>REGIST DAY</span>
        </li>
       
        <form action="admin_server.php?mode=review_delete" method = "post" class = "input_form">
<?php
        $sql = "select * from review order by num desc";
        $result = mysqli_query($con, $sql);
        $total_record = mysqli_num_rows($result);

        $number = $total_record;

        while($row = mysqli_fetch_array($result)){
          $num = $row["num"];
          $name = $row["name"];
          $title = $row["title"];
          $file_name = $row["file_name"];
          $regist_day = $row["regist_day"];
          $regist_day = substr($regist_day, 0 , 10);
?>
        <li id="input">
        <span ><input type="checkbox" name="item[]" value="<?=$num?>"></span>
        <span ><?=$number?></span>
        <span ><?=$name?></span>
        <span id="revier_title"><?=$title?></span>
        <span ><?=$regist_day?></span>
        </li>
<?php
        $number--;
      }
?>
      </ul>
      <ul>
        <button type="submit">선택된 글 삭제</button> 
      </ul>
      </form>
      <ul id = "subtitle1">
        <h4 id = "subtitle2">
           ADMIN > ORDER LIST
        </h4>
      </ul>
      <ul class="list_title">
        <li class = "list_title3">
          <span>CHECK</span>
          <span>NO</span>
          <span id="image">IMAGE</span>
          <span>id</span>
          <span>TITLE</span>
          <span>PRICE</span>
        </li> 
        <form action="admin_server.php?mode=buy_delete" method = "post" class ="input_form">
<?php
        $sql = "select * from buy";
        $result_set = mysqli_query($con, $sql);
        $total_record = mysqli_num_rows($result_set);

        if($total_record  == 0){
          echo "
          <tr>
            <td colspan='9'>주문 상품이 없습니다</td>
          </tr>
          ";
        }else{
          $count = mysqli_num_rows($result_set);

          while($row1 = mysqli_fetch_array($result_set)){
            $id = $row1["id"];
            $num = $row1["num"];
            $buy_num = $row1["buy_num"];

            $sql_select = "select * from imgboard where num = $num";
            $result = mysqli_query($con, $sql_select);
            $row2 =  mysqli_fetch_array($result);
            
            $title = $row2["name"];
            $price = $row2['price'];
            $file_name = $row2["file_name"];
            $file_type = $row2["file_type"];
            $file_copied = $row2["file_copied"];
          
            $image_max_width = 70;
            $image_max_height = 120;
      
            if(!empty($file_name)){
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
        <li id="input2">
        <span><input type="checkbox" name="item[]" value="<?=$buy_num?>"></span>
        <span><?=$number*-1?></span>
       
<?php
          if(strpos($file_type, "image") !== false){
            echo "<sapn id='img'><img  src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_copied' width='$image_width'></sapn>";
          }else{
            echo "
            <script>
              alert('이미지를 찾을 수 가없습니다');
            </script>
            ";
          }
?>  
        <span id ="input_id"><?=$id?></span>
        <span id="buy_title"><?=$title?></span>
        <span ><?=$price?></span>
        </li>
<?php
        $number--;
        }
      }
     mysqli_close($con);
?>
      </ul>
      <ul>
        <button type="submit">선택된 글 삭제</button> 
      </ul>
      </form>
    </div>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php"; ?>
  </footer>
</body>
</html>