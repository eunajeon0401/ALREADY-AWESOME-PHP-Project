<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/imgboard_list.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php" ;
     include  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

     if(isset($_GET['page'])){
       $page = $_GET['page'];
     }else{
       $page = 1;
     }

     if(isset($_GET['mode'])){
       $type = $_GET['mode'];
     }else{
       exit();
     }
?>
  </header>
  <section>
    <div id="board_box">
      <div id = "board_title">
      <h3>
        <?=$type?>
      </h3>
      </div>
      <div id="board_content">
      <ul>
<?php
        $sql_select = "select count(*) from imgboard where type = '$type' order by num desc";
        $result_set = mysqli_query($con, $sql_select);
        $row = mysqli_fetch_array($result_set);
        $total_record = intval($row[0]); //전체글수

        $scale = 9;
        $total_page = ceil($total_record / $scale);

        // 표시할 페이지에 따라 start 계산
        $start = ($page - 1) * $scale ; 
        $number = $total_record - $start;

        // 현재 페이지 레코드 결과 값을 저장하기 위해 배열선언
        $list = array();

        $sql_select = "select * from imgboard where type = '$type' order by num desc limit $start, $scale";
        $result_set = mysqli_query($con, $sql_select);

        $i = 0;
        while($row = mysqli_fetch_array($result_set)){
          $list[$i] = $row;
          $list_num = $total_record - ($page - 1) * $scale;
          $list[$i]['no'] = $list_num - $i;
          $i++;
        }

        $image_max_width = 350;
        $image_max_height = 350;

        for($i = 0; $i <count($list); $i++){
          $file_image = (!empty($list[$i]['file_name'])) ? "<img src=http://{$_SERVER['HTTP_HOST']}/source_202301/img/file.gif'>" : " ";
          $date = substr($list[$i]['regist_day'], 0 , 10);

          if(!empty($list[$i]['file_name'])){
            $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" .$list[$i]['file_copied']);
            $image_width = $image_info[0];
            $image_height = $image_info[1];
            $image_type = $image_info[2];

            if($image_width > $image_max_width){
              $image_width = $image_max_width;
            }
            if($image_height > $image_max_height){
              $image_height = $image_max_height;
            }
            $file_copied = $list[$i]['file_copied'];
          }
?>
          <li id = "board_item">
            <table>
              <tr>
              <a href="imgboard_view.php?num=<?= $list[$i]['num'] ?>&page=<?= $page ?>">
<?php
                if(strpos($list[$i]['file_type'], "image") !== false){
                  echo "<img id = 'board_img'src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_copied' width='$image_width' height='$image_height'><br>";
                }else{
                  echo "<img id = 'board_img' src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/img/user.jpg'' width='$image_max_width' height='$image_max_height'><br>";
                }
?>         
              </a>
              </tr>
              <tr>
                <td><?=$list[$i]['name']?></td>
              </tr>
              <tr>
                <td><?= $list[$i]['price'] ?></td>
              </tr>
              <tr>
<?php
              $best = $list[$i]['best'] == "1" ? "BEST" : "";
              $new = $list[$i]['new'] == "1" ? "NEW" : "";
              $delivery = $list[$i]['delivery'] == "1" ? "당일배송" : "";
?>
              <td >
                <span id="type_best"><?=$best?></span>
                <span id="type_new"n><?=$new?></span>
                <span id="type_delivery"><?=$delivery?></span>
              </td>
            </table>
          </li>
<?php
          // mysqli_close($con);
        }
?>      
      </ul>
      <ul id = "page_num">
<?php
    include  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/function.php";
    $url = "http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/board/imgboard_list.php?mode=$type&page=".$page;
    echo get_paging($scale, $page, $total_page, $url);
?>
      </ul>
      </div>   
    </div>
<?php
    if($userid == "admin"){
?>
      <a href="./imgboard_form.php"><button>사진올리기</button></a>
<?php
    }
?>    
  </section>
  <footer>
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php" ?>
  </footer>
</body>
</html>