<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/list.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php"; ?>
  </header>
  <section>
    <div id = "title_text">
      <h3>
        REVIEW
      </h3>
    </div>
    <div>
      <h4>
        Best reviewer
      </h4>
      <p>
        매달 2,4주 차 금요일 베스트 리뷰어로 선정된 3명의 고객님께 적립금 지급!
      </p>
    </div>
    <table id="list">
    <tr>
        <th>NUM</th>
        <th>IMAGE</th>
        <th>TITLE</th>
        <th>ID</th>
        <th>REGIST DAY</th>
        <th>HIT</th>
      </tr>
<?php
      include  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

      if(isset($_GET['page'])){
        $page = $_GET['page'];
      }else{
        $page = 1;
      }

      $sql_select = "select count(*) from review order by num desc";
      $result_set = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result_set);
      $total_record = intval($row[0]);

      $scale = 10;
      $total_page = ceil($total_record / $scale);

      $start = ($page - 1) * $scale;
      $numeber = $total_record - $start;

      $sql_select2 = "select * from review order by num desc limit $start, $scale";
      $result_set2 = mysqli_query($con, $sql_select2);

      while($row = mysqli_fetch_array($result_set2)){
        $num = $row['num'];
        $title = $row['title'];
        $id = $row['id'];
        $file_name = $row['file_name'];
        $file_type = $row['file_type'];
        $hit = $row['hit'];
        $file_copied = $row['file_copied'];

        $image_max_width = 100;
        $image_max_height = 100;

     
        $date = substr($row['regist_day'], 0 ,10);
  
        if(!empty($file_name)){
          $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/review_data/" . $file_copied);
          $image_width = $image_info[0];
          $image_height = $image_info[1];
          $image_type = $image_info[2];

          if($image_width > $image_max_width){
            $image_width = $image_max_width;
          }

          if($image_height > $image_max_height){
            $image_height = $image_max_height;
          }
        }
?>

      <tr id = "content">
        <th> <?=$num?></th>
        <td id ="text_img">
          
<?php
          if(empty($file_name)){
            echo "<input type = 'hidden'>";
          }else{
            if(strpos($file_type, "image") !== false){
              echo "<img src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/review_data/$file_copied' width='$image_width' height = '$image_height'>";
            }else{
              echo "";
            }
          }
?>
          
        </td>
      <td id ="text_title"><a href="review_view.php?num=<?=$num?>&page=<?=$page?>" id = "text" ><?=$title?></a></td>
      <td><?=$id?></td>
      <td><?=$date?></td>
      <td><?=$hit?></td>
      </tr>
<?php
      }
      mysqli_close($con);
?>
      <tr>
<?php
        include  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/function.php";
        $url = "http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/review/review_list.php?page=".$page;
        get_paging($scale, $page, $total_page, $url);
?>
      </tr>
    </table>
    <button onclick="location.href='review_form.php'">글쓰기</button>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php"; ?>
  </footer>
</body>
</html>