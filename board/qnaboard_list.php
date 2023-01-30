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
        Q&A
      </h3>
    </div>
    <table id="list">
    <tr>
        <th>NUM</th>
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

      $sql_select = "select count(*) from qnaboard order by num desc";
      $result_set = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result_set);
      $total_record = intval($row[0]);

      $scale = 10;
      $total_page = ceil($total_record / $scale);

      $start = ($page - 1) * $scale;
      $numeber = $total_record - $start;

      $sql_select2 = "select * from qnaboard order by num desc limit $start, $scale";
      $result_set2 = mysqli_query($con, $sql_select2);

      while($row = mysqli_fetch_array($result_set2)){
        $num = $row['num'];
        $title = $row['title'];
        $id = $row['id'];
        $hit = $row['hit'];
        $date = substr($row['regist_day'], 0 ,10);
?>

      <tr id = "content">
        <th> <?=$num?></th>
        <td id ="text_title"><a href="qnaboard_view.php?num=<?=$num?>&page=<?=$page?>" id = "text" ><?=$title?></a></td>
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
        $url = "http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/board/qnaboard_list.php?page=".$page;
        echo get_paging($scale, $page, $total_page, $url);
?>
      </tr>
    </table>
    <button onclick="location.href='qnaboard_form.php'">글쓰기</button>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php"; ?>
  </footer>
</body>
</html>