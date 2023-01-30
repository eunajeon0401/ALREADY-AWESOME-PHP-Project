<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  session_start();
  $userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : "";
  $username = (isset($_SESSION['name'])) ? $_SESSION['name'] : "";
  $userlevel = (isset($_SESSION['userlevel'])) ? $_SESSION['userlevel'] : "";

  if(isset($_POST['mode']) && $_POST['mode'] == "insert"){
    $price = $_POST['price'];
    $type = $_POST['type_check'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $title = htmlspecialchars($title, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);

    date_default_timezone_set('Asia/Seoul');
    $regist_day = date("Y-m-d (H:i)");
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/";

    $mainfile_name = $_FILES['mainfile']['name'];
    $mainfile_tmp_name = $_FILES['mainfile']['tmp_name'];
    $mainfile_type = $_FILES['mainfile']['type'];
    $mainfile_size = $_FILES['mainfile']['size'];
    $mainfile_error = $_FILES['mainfile']['error'];

    $subfile_name = $_FILES['subfile']['name'];
    $subfile_tmp_name = $_FILES['subfile']['tmp_name'];
    $subfile_type = $_FILES['subfile']['type'];
    $subfile_size = $_FILES['subfile']['size'];
    $subfile_error = $_FILES['subfile']['error'];

    if($mainfile_name && !$mainfile_error && $subfile_name && !$subfile_error){
      $mainfile = explode(".", $mainfile_name);
      $subfile = explode(".", $subfile_name);
      $mainfile_name = $mainfile[0];
      $mainfile_ext = $mainfile[1];
      $subfile_name = $subfile[0];
      $subfile_ext = $subfile[1];

      $new_mainfile_name = date("Y_m_d_H_i_s");
      $new_subfile_name = date("Y_m_d_H_i_s");
      $new_mainfile_name = $new_mainfile_name . "_" . $mainfile_name;
      $new_subfile_name = $new_subfile_name . "_" . $subfile_name;

      $copied_mainfile_name = $new_mainfile_name . "." . $mainfile_ext;
      $copied_subfile_name = $new_subfile_name . "." . $subfile_ext;
      $uploaded_mainfile = $upload_dir . $copied_mainfile_name;
      $uploaded_subfile = $upload_dir . $copied_subfile_name;
      
      if($mainfile_size > 1000000){
        echo "
        <script>
          alert('업로드 파일크기가 지정된 용량(1MB)을 초과합니다 파일 크기를 체크부탁드립니다');
        </script>
        ";
      }

      if(!move_uploaded_file($mainfile_tmp_name, $uploaded_mainfile )){
        echo "
        <script>
          alert('파일을 지정한 디렉토리에 복하는데 실패했습니다');
        </script>
        ";
      }
      if(!move_uploaded_file($subfile_tmp_name ,$uploaded_subfile)){
        echo "
        <script>
          alert('파일을 지정한 디렉토리에 복하는데 실패했습니다');
        </script>
        ";
      }
    }else{
      $mainfile_name = "";
      $mainfile_type = "";
      $copied_mainfile_name = "";
      
      $subfile_name = "";
      $subfile_type = "";
      $copied_mainfile_name = "";
    }
    
    $delivery =  (isset($_POST['delivery'])) ? "1" : "0"; 
    $new =  (isset($_POST['new'])) ? "1" : "0"; 
    $best =  (isset($_POST['best'])) ? "1" : "0"; 

    $sql_maininsert = "insert into imgboard (id, price, type, delivery, new, best, name, content, regist_day, hit,  file_name, file_type, file_copied) ";
    $sql_maininsert .= "values ('$userid','$price','$type','$delivery', '$new', '$best','$title','$content', '$regist_day', 0, '$mainfile_name','$mainfile_type','$copied_mainfile_name')";
    mysqli_query($con, $sql_maininsert);

    $sql_subinsert = "insert into imgboard_info (id, file_name2, file_type2, file_copied2) values ('$userid', '$subfile_name', '$subfile_type', '$copied_subfile_name') ";
    mysqli_query($con, $sql_subinsert);

    mysqli_close($con);
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/board/imgboard_list.php?mode=$type");
    exit();
  }else if(isset($_POST['mode']) && $_POST['mode'] == "modify"){
    $num = $_POST['num'];
    $title = $_POST['title'];
    $type = $_POST['type_check'];
    $price = $_POST['price'];
    $content = $_POST['content'];
    
    $delivery =  (isset($_POST['delivery'])) ? "1" : "0"; 
    $new =  (isset($_POST['new'])) ? "1" : "0"; 
    $best =  (isset($_POST['best'])) ? "1" : "0"; 

    $title = htmlspecialchars($title, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);

    if(!$_FILES["mainfile"]["name"] && !$_FILES["subfile"]["name"]){
      $sql_update = "update imgboard set price = '$price', type = '$type', new = '$new', best = '$best', delivery = '$delivery', name ='$title', content = '$content' ";
      $sql_update .= "where num = $num";

      mysqli_query($con, $sql_update);

    }else if($_FILES["mainfile"]["name"] && $_FILES["subfile"]["name"]){
    
      $file_path =  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" . $_POST['file_copied'];
      $file_path2 =  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" . $_POST['file_copied'];
      unlink($file_path);
      unlink($file_path2);

      $upload_dir = './data/';

      $mainfile_name = $_FILES["mainfile"]["name"]; 
      $mainfile_tmp_name = $_FILES["mainfile"]["tmp_name"]; 
      $mainfile_type = $_FILES["mainfile"]["type"]; 
      $mainfile_size = $_FILES["mainfile"]["size"]; 
      $mainfile_error = $_FILES["mainfile"]["error"]; 

      $subfile_name = $_FILES["subfile"]["name"];
      $subfile_tmp_name = $_FILES["subfile"]["tmp_name"];
      $subfile_type = $_FILES["subfile"]["type"];
      $subfile_size = $_FILES["subfile"]["size"];
      $subfile_error = $_FILES["subfile"]["error"];

      if($mainfile_name && !$mainfile_error && $subfile_name && !$subfile_error){
        $mainfile = explode(".", $mainfile_name);
        $subfile = explode(".", $subfile_name);
        $mainfile_name = $mainfile[0];
        $mainfile_ext = $mainfile[1];
        $subfile_name = $subfile[0];
        $subfile_ext = $subfile[1];
  
        $new_file_name = date("Y_m_d_H_i_s");
        $new_mainfile_name = $new_file_name . "_" . $mainfile_name;
        $new_subfile_name = $new_file_name . "_" . $subfile_name;
  
        $copied_mainfile_name = $new_mainfile_name . "." . $mainfile_ext;
        $copied_subfile_name = $new_subfile_name . "." . $subfile_ext;
        $uploaded_mainfile = $upload_dir . $copied_mainfile_name;
        $uploaded_subfile = $upload_dir . $copied_subfile_name;
        
        if($mainfile_size > 1000000){
          echo "
          <script>
            alert('업로드 파일크기가 지정된 용량(1MB)을 초과합니다 파일 크기를 체크부탁드립니다');
          </script>
          ";
          exit();
        }
  
        if(!move_uploaded_file($mainfile_tmp_name, $uploaded_mainfile )){
          echo "
          <script>
            alert('파일을 지정한 디렉토리에 복하는데 실패했습니다');
          </script>
          ";
          exit();
        }
        if(!move_uploaded_file($subfile_tmp_name ,$uploaded_subfile)){
          echo "
          <script>
            alert('파일을 지정한 디렉토리에 복하는데 실패했습니다');
          </script>
          ";
          exit();
        }
      }
      $sql_mainupdate = "update imgboard set price = '$price', type = '$type', new = '$new', best = '$best', delivery = '$delivery', name ='$title', content = '$content', file_name = '$mainfile_name' ,file_type ='$mainfile_type', file_copied ='$copied_mainfile_name'";
      $sql_mainupdate .= "where num = $num";

      mysqli_query($con, $sql_mainupdate);

      $sql_subupdate = "update imgboard set price = '$price', type = '$type', new = '$new', best = '$best', delivery = '$delivery', name ='$title', content = '$content', file_name = '$mainfile_name' ,file_type ='$mainfile_type', file_copied ='$copied_mainfile_name'";
      $sql_subupdate .= "where num = $num";

      mysqli_query($con, $sql_subupdate);

    }
    mysqli_close($con);
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/board/imgboard_view.php?num=$num&mode=$type");
    exit();
  }

?>