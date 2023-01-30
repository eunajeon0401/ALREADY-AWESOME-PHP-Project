<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?" >
  <link rel="stylesheet" href="../css/imgboard_form.css?after" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php";
      if($_SESSION['id'] !== "admin"){
        echo "
        <script>
          alert('수정 권한이 없습니다');
          history.go(-1)
        </script>
        ";
        exit();
      }
?>    
  </header>
  <section>
    <div id="board_content">
      <div id = "title">
        <h3>UPDATE</h3>
      </div>
<?php
    include  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";
    $num = $_GET["num"];  

    $sql_select = "select * from imgboard where num = $num";
    $result_set = mysqli_query($con,$sql_select);
    $row = mysqli_fetch_array($result_set);

    $type = $row['type'];
    $title = $row['name'];
    $price = $row['price'];
    $content = $row['content'];
    $file_name = $row['file_name'];
    $file_copied = $row["file_copied"];
    
    $sql_subselect = "select * from imgboard_info where num =$num";
    $subresult_set = mysqli_query($con, $sql_subselect);
    $row = mysqli_fetch_array($subresult_set);
    
    $file_name2 = $row['file_name2'];
    $file_copied2 = $row["file_copied2"];
   
?>
      <form form action="http://<?= $_SERVER['HTTP_HOST']; ?>/ALREADY_AWESOME/board/imgboard_server.php" name ="imgboard_form" method = "post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value = "modify">
      <input type="hidden" name="num" value =<?=$num?>>
      <input type="hidden" name="file_copied" value =<?=$file_copied?>>
      <input type="hidden" name="file_copied2" value =<?=$file_copied2?>>

      <ul class = "board_input">
        <li>
          <span>제목 :</span>
          <span><input type="text" name = "title" value="<?=$title?>"></span>
        </li>
        <li>
          <span>금액 :</span>
          <span><input type="text" name="price" value="<?=$price?>" ></span>
        </li>
      </ul>
      <ul>
        <li>
          <span>
            TYPE :
            <select name="type_check" >
              <option value="outer">outer</option>
              <option value="top">top</option>
              <option value="bottom">bottom</option>
            </select>
          </span>
        </li>
        <li>
          <span id = "checkbox">
          <input type ="checkbox" name="delivery">당일배송
          <input type ="checkbox" name="best">BEST
          <input type ="checkbox" name="new">NEW           
          </span>
        </li>
      </ul>
      <ul class = "board_input">
        <li>
          <span>내용 :</span><br>
          <span><textarea name="content"  cols="130" rows="30"><?= $content?></textarea></span>
        </li>   
        <li>
          <span class="col1"> 메인 파일 : <?=$file_name?></span>
          <span class="col2"><input type="file" name="mainfile_update"></span>
        </li>
        <li>
          <span class="col1"> 상세 파일 : <?=$file_name2?></span>
          <span class="col2"><input type="file" name="subfile_update"></span>
        </li>
      </ul>
      <ul class="buttons">
        <li><button type="submit" >저장</button></li>
        <li><button type="button" onclick="location.href='imgboard_list.php'">목록</button></li>
      </ul>
      </form>
    </div>
  </section>
  <footer>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php" ?> 
  </footer>
</body>
</html>