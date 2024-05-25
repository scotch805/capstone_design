<head>
<link rel="stylesheet" href="calendar_design.css">

<?php   //변수 설정
	$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
  // GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
	$month = isset($_GET['month']) ? $_GET['month'] : date('m');
  // GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
  $today = isset($_GET['day']) ? $_GET['day'] : date('d');

	$date = "$year-$month-$today"; // 현재 날짜
	$time = strtotime($date); // 현재 날짜의 타임스탬프
	$start_week = date('w', $time); // 1. 시작 요일
	$total_day = date('t', $time); // 2. 현재 달의 총 날짜
	$total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
?>

<?php   //db연결
  $host = "localhost";
  $username = "root";
  $password = "1234";
  $database_name = "calendar_todos";

  $db = mysqli_connect($host, $username, $password, $database_name);

  if (!$db) {
    // die() 함수는 인수로 전달받은 메시지를 출력하고, 현재 실행 중인 PHP 스크립트를 종료시키는 함수입니다.
    die("서버와의 연결 실패! : ".mysqli_connect_error());
  }

  echo "서버와의 연결 성공!";
?>

<?php // php function
    
    function testfun()    //mysql의 데이터를 Todo에 표시하기 -> head에 옮겨서 function을 작성?
    {
      global $year, $month, $today;   // 위 생성한 전역변수 사용
      global $host, $username, $password, $database_name, $db;

      $value = $_POST['test'];    // input의 name = 'test'인 것의 value를 받아온 값
      $date = "$year-$month-$value";  // sql에서 가져올 날짜 형식

      $sql = "SELECT * FROM Todo";

      $result = mysqli_query($db, $sql);

      //echo "Your test function on button click is working <br/>";
      //print("날짜: " .$date . "<br/>");
      echo "날짜: " . $date;   // 두가지 형식으로 출력 가능

      return $date;
    }
?>

<?php 
  //$value = $_POST['test'];    // input의 name = 'test'인 것의 value를 받아온 값
  //$date = "$year-$month-$value";  // sql에서 가져올 날짜 형식

  $sql = "SELECT * FROM Todo";

  $result = mysqli_query($db, $sql);

  //echo $value;
?>

</head>

<body>    <!--html code start -->
<div class ="location1">
  <div class="wrapper">
    <header>
        <div class="nav">
          <button class="material-icons"> < </button>
          <!--<p class="current-date">2024년 4월 </p>-->
          <p calss="current-date">
            <?php
                echo "$year 년 $month 월"     
            ?>
          </p>
          <button class="material-icons"> > </button>
        </div>
      </header>

      <div class="calendar">
        
        <ul class="weeks">
          <li>일</li>
          <li>월</li>
          <li>화</li>
          <li>수</li>
          <li>목</li>
          <li>금</li>
          <li>토</li>
        </ul>
        <!--------------함수를 작동시키기 위해서 날짜를 변수로? NO, $value = $_POST['test']; 으로 변수에 값 할당 가능( 참조 https://dev4u.tistory.com/256 )------------->
        <ul class="days">
          <?php for($blank =0; $blank < $start_week; $blank++): ?> <!-- start-week(숫자)를 이용해서 -->
            <li> </li>  <!-- 빈 요일은 공백으로 채우기 -->
          <?php endfor; ?> 

          <?php for ($n = 1, $i = 0; $i < $total_week; $i++): ?> <!-- 주 만큼 반복 -->
            <?php for ($k = 0; $k < 7; $k++): ?>  <!--1~7일까지 반복 -->
              <?php if ( ($n > 1 || $k >= $start_week) && ($total_day >= $n) ): ?>  <!-- 시작 요일부터 마지막 날짜까지만 날짜를 보여주도록 -->
                
                <li>
                  <form method="post"> <!-- input 형식으로 날짜 넣기 -->
                    <input type="submit" name="test" id="test"  value= <?php echo $n++ ?> /> <!-- value 이게 되네? -->
                  </form> 
                </li>
            
                <?php if($n == $today): ?> <!-- 오늘 날짜면 active 설정 넣기 -->
                  <li class = "active">
                    <form method="post">
                      <input type="submit" name="test" id="test" value= <?php echo $n++ ?> />
                    </form>
                  </li>
                <?php endif ?>
					
              <?php endif ?>
				    <?php endfor; ?> 
			    <?php endfor; ?>
        </ul>
      </div>
  </div>
</div>

<div class="lacation2"> <!--다이어리 만들 위치-->
  
  <form method="post"> <!--test-->
      <input type="submit" name="test" id="test" value="RUN" /><br/>
  </form>

<?php   //*****얘가 있는 위치에서 함수실행*******
  if(array_key_exists('test',$_POST)){    // name="test"인 input을 누르면 함수가 작동 
      testfun();
    }
?>

  <!-- 여기서부터 Todo -->
    <div class="todo-wrapper">
      <div class="todo-title">Todos</div>
      <div class="todo-box">
            <div class="todo-top">
              <div class="left-items">3 items left</div>
              <div class="button-group">    <!--button 클릭시 mysql과 연동 되도록 -->
                  <button class="show-all-btn selected" data-type="all">All</button>
                  <button class="show-active-btn" data-type="active">Active</button>
                  <button class="show-completed-btn" data-type="completed">Completed</button>
              </div>
              <button class="clear-completed-btn">Add & Modify</button> <!-- 이 부분을 추가(수정)으로 바꾸기, 팝업 이벤트로?-->
            </div>

            

            <ul class="todo-list">    <!--mysql과 연동 완료, 날짜 클릭시 변경된 날짜의 데이터를 가져오기 (새로고침?) -->
              <?php while($row = mysqli_fetch_array($result)): ?>
                  <?php if($row['done'] == 1 and $row['now_date'] == $date): ?>
                      <li class="todo-item checked">
                          <div class="checkbox">✔</div>
                          <div class="todo"><?php echo $row['todo']. "<br>"; ?></div>
                          <button class="delBtn">x</button>
                      </li>
                  <?php elseif($row['done'] == 0 and $row['now_date'] == $date): ?>
                      <li class="todo-item">
                          <div class="checkbox"></div>
                          <div class="todo"><?php echo $row['todo']. "<br>"; ?></div>
                          <button class="delBtn">x</button>
                      </li>
                  <? endif ?>
              <?php endwhile; ?>
            </ul>
      </div>          
      <!--<p class='info'>더블클릭 시 수정</p>-->
    </div>
</div>
<body>

