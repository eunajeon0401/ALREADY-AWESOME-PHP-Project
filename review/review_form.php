<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?" >
  <link rel="stylesheet" href="../css/form.css?after" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php"; 
        if(empty($_SESSION['id'])){
          echo "
          <script>
            alert('로그인 후 이용가능합니다');
            history.go(-1)
          </script>
          ";
          exit();
        }
  ?>    
  </header>
  <section>
    <div id="board_content">
      <div id="title">
        <h3>
          리뷰 작성하기
        </h3>
      </div>
      <form form action="./review_server.php" name ="review_form" method = "post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value = "insert">
      <ul class = "board_input">
        <li>
          <span>제목 :</span>
          <span><input type="text" name = "title" id ="input_title" ></span>
        </li>
      </ul>
      <ul class = "board_input">
        <li>
          <span>내용 :</span><br>
          <span><textarea name="content" cols="150" rows="30"></textarea></span>
        </li>
        <li>
          <span class="col1"> 첨부 파일 :</span>
          <span class="col2"><input type="file" name="upfile"></span>
        </li>
      </ul>
      <ul class="buttons">
        <li><button type="submit" >저장</button></li>
        <li><button type="button" onclick="location.href='review_list.php'">목록</button></li>
      </ul>
      </form>
    </div>
  </section>
  <footer>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php" ?> 
  </footer>
</body>
</html>