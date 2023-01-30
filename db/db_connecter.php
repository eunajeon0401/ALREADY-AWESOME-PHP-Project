<?php
$con = mysqli_connect("localhost", "root", "123456");
if(!$con){
  die("database connect fail".mysqli_connect_error());
}

//sample 이라는 데이타 베이스가 이미 만들어졌는지를 확인
$database_flag = false;
$sql = "show databases";
$result = mysqli_query($con, $sql) or die("데이타 베이스 보여주기 실패".mysqli_error($con));

while($row = mysqli_fetch_array($result)){
  if($row["0"] == "aadb"){
    $database_flag = true;
    break;
  }
}

// 데이타베이스가 없다면
if($database_flag == false){
  $sql = "create database aadb";
  $result = mysqli_query($con, $sql) or die("데이타 베이스 생성 실패".mysqli_error($con));
  if($result == true){
    echo "<script>alert('aadb 데이타배이스가 생성')</script>";
  }
}

// 데이타베이스를 선택
$dbcon = mysqli_select_db($con, "aadb") or die("데이타 베이스 선택 실패".mysqli_error($con));
if($dbcon == false){
  echo "<script>alert('aadb 데이타배이스가 선택되었습니다')</script>";
}


// function get_paging_opt($write_pages, $current_page, $total_page, $url){
//   $pattern = "'/&page=[0-9]*/'";
//   $url = preg_rplace($pattern, '', $url) . 'page=';

//   $str = '';

//   ($current_page > 1) ? ($str .='<a href="' . $url . '1"> <<< </a>'.PHP_EOL) : '';

//   $start_page = (((int) (($current_page - 1) / $write_pages)) * $write_pages) + 1;
//   $end_page = $start_page + $write_pages - 1;

// }



?>

