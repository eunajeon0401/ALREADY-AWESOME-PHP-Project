<?php
function input_set($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function get_paging($show_pages, $current_page, $total_page, $url) {
  // URL 변형
  // 예) 'memo_login&page=123' → 'memo_login&page='
  $url = preg_replace('/page=[0-9]*/', '', $url) . 'page=';

  // 0. 페이징 시작
  $str = '';

  // 1. 2페이지부터 '처음(<<)' 가기 표시
  ($current_page > 1) ? ($str .= '<a href="' . $url . '1" class="arrow pprev"><<</a>' . PHP_EOL) : ''; // 'PHP_EOL' = \n

  // 2. 시작 페이지와 끝 페이지를 정한다.(= 정하기만 한다.)
  $start_page = (((int)(($current_page - 1) / $show_pages)) * $show_pages) + 1;
  $end_page = $start_page + $show_pages - 1;
  if ($end_page >= $total_page) $end_page = $total_page;

  // 3. 11페이지부터 '이전(<)' 가기 표시
  if ($start_page > 1) $str .= '<a href="' . $url . ($start_page - 1) . '" class="arrow prev"><</a>' . PHP_EOL;

  // 4. (총 페이지가 2페이지 이상일 경우부터) 시작 페이지와 끝 페이지를 등록한다.(= 페이지를 만드는 구문에 직접 추가한다.)
  if ($total_page >= 1) {
      for ($k = $start_page; $k <= $end_page; $k++) {
          if ($current_page != $k)
              $str .= '<a href="' . $url . $k . '" class="">' . $k . '</a>' . PHP_EOL;
          else
              $str .= '<a href="' . $url . $k . '" class="active">' . $k . '</a>' . PHP_EOL;
      }
  }

  // 5. 총 페이지가 마지막 페이지보다 클 경우, '다음(>)' 가기 표시
  // 예) 20페이지에서 다음을 누르면 21페이지로 이동
  if ($total_page > $end_page) $str .= '<a href="' . $url . ($end_page + 1) . '" class="arrow next">></a>' . PHP_EOL;

  // 6. 현재 페이지가 총 페이지보다 작을 경우, '마지막(>>)' 가기 표시
  if ($current_page < $total_page) {
      $str .= '<a href="' . $url . $total_page . '" class="arrow nnext">>></a>' . PHP_EOL;
  }
  // 7. 페이지 등록
  if ($str)
      echo "<li class='pg_wrap'><span class='pg'>{$str}</span></li>";
  else
      echo "";
}

?>