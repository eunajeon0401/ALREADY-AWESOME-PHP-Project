<?php
function create_table($con, $table_name){
  // table check
  $flag = false;
  $sql = "show tables from aadb";
  $result = mysqli_query($con, $sql) or die('table 보여주기 실패'. myslqi_error($con));
  while($row = mysqli_fetch_array($result)){
    if($row[0] == "$table_name"){
      $flag = true;
      break;
    }
  }

  // 원하는 테이블이 없다면
  if($flag == false){
    switch($table_name){
      case 'members' : 
        $sql = "create table if not exists members(
          num int not null auto_increment,
          id char(15) not null,
          pass varchar(255) not null,
          name char(10) not null,
          email char(80),
          regist_day char(20),
          level int,
          point int,
          primary key(num)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        break;
      case 'qnaboard' : 
        $sql = "create table if not exists qnaboard (
          num int not null auto_increment,
          id char(15) not null,
          title char(200) not null,
          content text not null,        
          regist_day char(20) not null,
          hit int not null,
          primary key(num)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
         break;
      case 'qnaboard_ripple':  
          $sql = "CREATE TABLE `qnaboard_ripple` (
          `num` int(11) NOT NULL AUTO_INCREMENT,
          `parent` int(11) NOT NULL,
          `id` char(15) NOT NULL,
          `name` char(10) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) DEFAULT NULL,
          PRIMARY KEY (`num`),
          KEY `regist_day` (`regist_day`)
        ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;";
        break;
      // case 'board_ripple': break;
      case 'imgboard': 
        $sql = "CREATE TABLE if not exists`imgboard` (
          `num` int NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `price` char(15) NOT NULL,
          `type` char(15) NOT NULL,
          `new` varchar(15) ,
          `best` varchar(15) ,
          `delivery` varchar(15) ,
          `name` char(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) NOT NULL,
          `hit` int NOT NULL, 
          `file_name` char(40) NOT NULL,
          `file_type` char(40) NOT NULL,
          `file_copied` varchar(255) NOT NULL,
          PRIMARY KEY (`num`),
          KEY `id` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
        break;
      case 'imgboard_info': 
          $sql = "CREATE TABLE if not exists`imgboard_info` (
            `num` int NOT NULL AUTO_INCREMENT,
            `id` char(15) NOT NULL,
            `file_name2` char(40) NOT NULL,
            `file_type2` char(40) NOT NULL,
            `file_copied2`  varchar(255) NOT NULL,
            PRIMARY KEY (`num`),
            KEY `id` (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
          break;
      case 'review': 
        $sql = "CREATE TABLE if not exists`review` (
          `num` int NOT NULL AUTO_INCREMENT,
          `id` char(15) NOT NULL,
          `name` char(100) NOT NULL,
          `title` char(100) NOT NULL,
          `content` text NOT NULL,
          `regist_day` char(20) NOT NULL,
          `hit` int NOT NULL, 
          `file_name` char(40) ,
          `file_type` char(40) ,
          `file_copied` varchar(255) ,
          PRIMARY KEY (`num`),
          KEY `id` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
        break;
      case 'review_repple':
        $sql = "
          CREATE TABLE IF NOT EXISTS `review_repple` (
              `num` int(11) NOT NULL AUTO_INCREMENT,
              `parent` int(11) NOT NULL,
              `id` char(15) NOT NULL,
              `name` char(10) NOT NULL,
              `content` text NOT NULL,
              `regist_day` char(20) DEFAULT NULL,
              PRIMARY KEY (`num`),
              KEY `regist_day` (`regist_day`)
            ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
            ";
        break;
        case 'cart': 
          $sql = "CREATE TABLE if not exists`cart` (
            `num` int NOT NULL,
            `id` char(15) NOT NULL,
            `cart_num` int NOT NULL AUTO_INCREMENT,
            PRIMARY KEY (`cart_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
          break;
          case 'buy': 
            $sql = "CREATE TABLE if not exists`buy` (
              `num` int NOT NULL,
              `id` char(15) NOT NULL,
              `name` char(15) ,
              `address` char(100), 
              `phone` char(100) ,
              `buy_num` int NOT NULL AUTO_INCREMENT,
              PRIMARY KEY (`buy_num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
            break;
      default : 
      echo "<script>
          alert('해당테이블을 찾을 수가 없습니다')
      </script>"; 
      break;
    }

    $result = mysqli_query($con, $sql) or die("table 생성 실패".mysqli_error($con));
    if($result == true){
      echo "<script> alert('{$table_name} table create')</script>";
    }else{
      echo "<script> alert('{$table_name} table failed ')</script>";
    }
  }
}

?>