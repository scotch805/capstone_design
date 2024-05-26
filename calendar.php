<head>
  <link rel="stylesheet" href="calendar_design.css">
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

  <?php   //변수 설정
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');     // GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');    // GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
    $today = isset($_GET['day']) ? $_GET['day'] : date('d');

    $date = "$year-$month-$today"; // 현재 날짜
    $time = strtotime($date); // 현재 날짜의 타임스탬프
    $start_week = date('w', $time); // 1. 시작 요일
    $total_day = date('t', $time); // 2. 현재 달의 총 날짜
    $total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
  ?>

  <?php   //db연결 및 쿼리(Todo 값을 모두 가져옴)
    $host = "localhost";
    $username = "root";
    $password = "1234";
    $database_name = "calendar_todos";

    $db = mysqli_connect($host, $username, $password, $database_name);

    if (!$db) {
      die("서버와의 연결 실패! : ".mysqli_connect_error());   // die() 함수는 인수로 전달받은 메시지를 출력하고, 현재 실행 중인 PHP 스크립트를 종료
    }

    $sql = "SELECT * FROM Todo";
    $result = mysqli_query($db, $sql);
    
  ?>

  <?php //달력의 날짜 클릭시 작동하는 함수, 클릭한 날짜를 반환
      function testfun()  
      {
        global $year, $month, $today;   // 위 생성한 전역변수 사용

        $value = $_POST['test'];    // input의 name = 'test'인 것의 value를 받아온 값
        $date = "$year-$month-$value";  // sql에서 가져올 날짜 형식
        
        return $date;   //함수 작동시 $date 값 덮어쓰기 (함수 작동할 때마다 새로운 $date 반환)
      }
  ?>

  <script>    // jquery, 달력 날짜(id=test), todo(id = reload_todo)를 사용
    $(document).ready(function() {   // 이 라인 없어도 사용가능
      $('#test').click(function(){    // click 함수
        $('#reload_todo').load(location.href + " #reload_todo");  //새로고침 함수
      });
    });
  </script>

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
        $date = testfun();    // $date 값 덮어쓰기 (날짜 클릭시 값 변경)
        echo '날짜 : '. $date;
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

              

              <ul class="todo-list" id="reload_todo">    <!--mysql과 연동 완료, 날짜 클릭시 변경된 날짜의 데이터를 가져오기 완료 -->
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

