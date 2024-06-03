<head>
  <link rel="stylesheet" href="calendar_design.css">
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
  
  <?php   //변수 설정
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');     // GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');    // GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
    $today = isset($_GET['day']) ? $_GET['day'] : date('j');  if($today < 10) $today = isset($_GET['day']) ? $_GET['day'] : date('d');  //한자리 수 날짜의 형식은 01 형식으로 해야 mysql과 형식이 맞음 

    if ($month == 1)
    {
      $prev_month = 12;
      $prev_year = $year - 1;
    }
    else
    {
      $prev_month = $month - 1;
      $prev_year = $year;
    }
  
    if ($month == 12)
    {
      $next_month = 1;
      $next_year = $year + 1;
    }
    else
    {
      $next_month = $month + 1;
      $next_year = $year;
    }
    
    $date = "$year-$month-$today"; // 현재 날짜
    $time = strtotime("$year-$month-01"); // 달력의 첫 날 타임스탬프
    $start_week = date('w', $time); // 1. 시작 요일
    $total_day = date('t', $time); // 2. 현재 달의 총 날짜
    $total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
  ?>

  <?php   //prev, next btn
    function prev_btn(){
      global $month, $year, $today, $time, $start_week, $total_day, $total_week;
      $month = $month - 1;

      if($month == 1){
        $year = $year - 1;
        $month = 12;
      }
        
      $date = "$year-$month-$today"; // 현재 날짜
      $time = strtotime("$year-$month-01"); // 달력의 첫 날 타임스탬프
      $start_week = date('w', $time); // 1. 시작 요일
      $total_day = date('t', $time); // 2. 현재 달의 총 날짜
      $total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
    }

    function next_btn(){
      global $month, $year, $today, $time, $start_week, $total_day, $total_week;
      $month = $month + 1;

      if($month == 12){
        $year = $year + 1;
        $month = 1;
      }
        
      $date = "$year-$month-$today"; // 현재 날짜
      $time = strtotime("$year-$month-01"); // 달력의 첫 날 타임스탬프
      $start_week = date('w', $time); // 1. 시작 요일
      $total_day = date('t', $time); // 2. 현재 달의 총 날짜
      $total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
    }
  ?>

  <script>   //left, right btn
    function left_btn(){}
    function right_btn(){}
  </script>

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

  <?php   //달력의 날짜 클릭시 작동하는 함수, 클릭한 날짜를 반환
      function testfun()  
      {
        global $year, $month, $today;   // 위 생성한 전역변수 사용

        if(array_key_exists('test',$_POST))
          $today = $_POST['test'];    // input의 name = 'test'인 것의 value를 받아온 값
        
        $date = "$year-$month-0$today";  // sql에서 가져올 날짜 형식
        if($date >= 10)  $date = "$year-$month-$today";
        //$date = $year.'년 '.$month.'월 '.$value.'일';
        
        return $date;   //함수 작동시 $date 값 덮어쓰기 (함수 작동할 때마다 새로운 $date 반환)
      }
  ?>

  <script>    // jquery 새로고침 함수, 달력 날짜(id=test), todo(id = reload_todo)를 사용
    $(document).ready(function() {   // 이 라인 없어도 사용가능
      $('#test').click(function(){    // click 함수
        $('#reload_todo').load(location.href + " #reload_todo");  //새로고침 함수
      });
    });
  </script>

  <script>    // todo에 데이터를 추가하는 textbox 구현하는 함수
    function addTextbox() {
        var container = document.getElementById('textboxContainer');

        // 이미 텍스트박스가 존재하는지 확인
        if (container.children.length === 0) {
            // 새로운 div 요소 생성 (텍스트박스와 삭제 버튼을 담을 컨테이너)
            var textboxContainer = document.createElement('form');
            textboxContainer.className = 'textbox-container';
            textboxContainer.method = 'post';
            textboxContainer.id ='after_submit';

            // 새로운 input 요소 생성
            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'textbox';
            input.name ='textbox';
            input.id ='textbox';

            // 새로운 삭제 버튼 생성
            var removeButton = document.createElement('button');
            removeButton.textContent = '추가';
            removeButton.className = 'button';
            removeButton.type ='submit';
            removeButton.id ='click_submit';
            removeButton.onclick = function() {
              //container.removeChild(textboxContainer);    // removeButton이 함수 작동 없이 제출 후 사라지는 이유는? 
            };  // submit 타입은 버튼 클릭을 하면 폼을 제출하고 새로고침이 되서, location.reload() 등 불필요
            
            //날짜를 저장할 input
            var hidden_date = document.createElement('input');
            hidden_date.type = 'hidden';
            hidden_date.name ='hidden_date';
            hidden_date.id ='hidden_date';
            hidden_date.value='<?php $date = testfun(); echo $date; ?>';
            
            // 텍스트박스와 삭제 버튼을 div에 추가
            textboxContainer.appendChild(input);
            textboxContainer.appendChild(hidden_date);
            textboxContainer.appendChild(removeButton);
            
            // 텍스트박스 컨테이너를 메인 컨테이너에 추가
            container.appendChild(textboxContainer);
        }
    }
  </script>

  <script>    //추가할 값 textbox가 제출 되면 작동하는 함수, id=after_submit 이용, db에 data 추가
     $(document).on('submit', '#after_submit', function(event) {  //on()을 이용한 jqurey
      //$("#after_submit").submit(function(){   //.submit()을 이용한 jqurey, 둘 다 사용 가능
        <?php    
          $add_todo_value = $_POST['textbox'];
          $hidden_date = $_POST['hidden_date'];

          if($add_todo_value != ""){
            $filtered = array(
              'now_date'=>mysqli_real_escape_string($db, $hidden_date),
              'todo'=>mysqli_real_escape_string($db, $add_todo_value), 
              'done'=>mysqli_real_escape_string($db, 0)
            );
        
            $Add_sql ="
              INSERT INTO Todo
                (now_date, todo, done)
                VALUES (
                  '{$filtered['now_date']}',
                  '{$filtered['todo']}',
                  '{$filtered['done']}'
                  )
            ";
        
            $Add_result = mysqli_query($db, $Add_sql);
            if($Add_result === false){
          
              echo '저장하는 과정에서 문제가 생겼습니다.';
            }
          }
          $add_todo_value = "";   // 제출된 값으로 위 if문을 계속 통과하므로, 값을 초기화 시켜줌

          $sql = "SELECT * FROM Todo";      // sql을 재실행 해서 submit으로 인한 새로고침이 될 때 변경 값을 적용
          $result = mysqli_query($db, $sql);
        ?>
      });
  </script>

  <script>    //삭제 버튼 동작
     $(document).on('submit', '#delBtn', function(event) {  //on()을 이용한 jqurey
      //$("#after_submit").submit(function(){   //.submit()을 이용한 jqurey, 둘 다 사용 가능
        <?php    
          $delete_todo_value = $_POST['delete_data_todo'];
          $delete_date_value = $_POST['delete_data_date'];

          if($delete_todo_value != ""){
            $filtered = array(
              'now_date'=>mysqli_real_escape_string($db, $delete_date_value),
              'todo'=>mysqli_real_escape_string($db, $delete_todo_value)
            );
        
            $Delete_sql ="
              DELETE FROM Todo
              WHERE now_date = '{$filtered['now_date']}' AND todo = '{$filtered['todo']}';
              ";
        
            $Delete_result = mysqli_query($db, $Delete_sql);
            if($Delete_result === false){
          
              echo '저장하는 과정에서 문제가 생겼습니다.';
            }
          }
          //$delete_todo_value = "";   // 제출된 값으로 위 if문을 계속 통과하므로, 값을 초기화 시켜줌

          $sql = "SELECT * FROM Todo";      // sql을 재실행 해서 submit으로 인한 새로고침이 될 때 변경 값을 적용
          $result = mysqli_query($db, $sql);
        ?>
      });
  </script>

</head>

<body>    <!--php if를 이용해서 월 넘기기, wrapper(달력)도 새로고침 수행? -->
  <div class ="location1">
    <div class="wrapper" id="calendar">
        <header>
          <div class="nav">
            <a href="?year=<?= $prev_year ?>&month=0<?= $prev_month ?>"><button id="prev">&lt;</button></a>
            <!--<p class="current-date">2024년 4월 </p>-->
            <p calss="current-date">
              <span><?= $year ?>년 <?= $month ?>월</span>
            </p>
            <a href="?year=<?= $next_year ?>&month=0<?= $next_month ?>"><button id="next">&gt;</button></a>
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
                  
                  <?php if($n == $today): ?> <!-- 오늘 날짜면 active 설정 넣기 -->
                    <li class = "active">
                      <form method="post">
                        <input type="submit" name="test" id="test" value= <?php if($n < 10)echo '0'.$n++; else echo $n++; ?> />
                      </form>
                    </li>
                  <?php endif ?>
                  <li>
                    <form method="post"> <!-- input 형식으로 날짜 넣기 -->
                      <input type="submit" name="test" id="test"  value= <?php if($n < 10)echo '0'.$n++; else echo $n++; ?> /> <!-- value 이게 되네? -->
                    </form> 
                  </li>
              
            
                <?php endif ?>
              <?php endfor; ?> 
            <?php endfor; ?>
          </ul>
        </div>
    </div>
  </div>

  <div class="lacation2"> <!--다이어리 만들 위치-->
    
    <form method="post"> <!-- *****얘 아래서 함수실행******* 삭제 예정 -->
        <!--<input type="submit" name="test" id="test" value="RUN" /><br/>-->
    </form>

    <?php   //PHP function으로 날짜 값 덮어쓰는 중, head로 이동 예정
      if(array_key_exists('test',$_POST)){    // name="test"인 input을 누르면 함수가 작동 
          $date = testfun();    // $date 값 덮어쓰기 (날짜 클릭시 값 변경)
          $value = $_POST['test'];
          echo '날짜 : '. $date;
          echo '<br>';
          echo '날짜 : '. $year.'년 '. $month. '월 '. $value.'일';
          //$val = $_POST['textbox'];
          echo '<br>'. $today. '<br>';
        }
        //echo $crud_date;
    ?>
 
    <!-- 여기서부터 Todo -->
      <div class="todo-wrapper">    <!--CRUD 작성하기 -->
        <div class="todo-title">Todos</div>
        <div class="todo-box">
              <div class="todo-top">
                <div class="left-items">3 items left</div>
                <div class="button-group">    <!--button 클릭시 mysql과 연동 되도록 -->
                    <!--<button class="show-all-btn selected" data-type="all">All</button>-->
                    <button class="show-active-btn" data-type="active"><?php echo $year.'년 '. $month. '월 '. $today.'일'; $crud_date = "$year-$month-$today"; ?><!--Active--></button>
                    <!--<button class="show-completed-btn" data-type="completed">Completed</button>-->
                </div>
                <!--<button class="clear-completed-btn" onclick="add_textbox()">Add Todo</button> --><!-- 이 부분을 추가(수정)으로 바꾸기, 팝업 이벤트로?-->
                <button class="clear-completed-btn" onclick="addTextbox()">Add Todo</button>
              </div>
              
              <div class ="todo" id="textboxContainer" style="flex: 1; margin-left: auto;"></div>
                                        
              
              <ul class="todo-list" id="reload_todo">    <!--mysql과 연동 완료, 날짜 클릭시 변경된 날짜의 데이터를 가져오기 완료 -->
                <?php while($row = mysqli_fetch_array($result)): ?>
                    <?php if($row['done'] == 1 and $row['now_date'] == $date): ?>
                        <li class="todo-item checked">
                            <div class="checkbox">✔</div>
                            <div class="todo"><?php echo $row['todo']. "<br>"; ?></div>
                            <form method="post" id="delBtn">
                              <input type="hidden" id="delete" name="delete" value="<?php echo $row['todo'] ?>"/>
                              <input type="hidden" id="delete_data_date" name="delete_data_date" value="<?php echo $row['now_date'] ?>"/>
                              <button class="delBtn" value=<?php echo $row['todo']; ?>>x</button>   <!-- form으로 작성, jquery .submit()을 이용 & -->
                            </form>
                        </li>
                    <?php elseif($row['done'] == 0 and $row['now_date'] == $date): ?>
                        <li class="todo-item" id="todo_row">
                            <div class="checkbox"></div>
                            <div class="todo"><?php echo $row['todo']. "<br>"; ?></div>
                            <form method="post" id="delBtn">
                              <input type="hidden" id="delete_data_todo" name="delete_data_todo" value="<?php echo $row['todo'] ?>"/>
                              <input type="hidden" id="delete_data_date" name="delete_data_date" value="<?php echo $row['now_date'] ?>"/>
                              <button class="delBtn" value=<?php echo $row['todo']; ?>>x</button>   <!-- form으로 작성, jquery .submit()을 이용 & -->
                            </form>
                        </li>
                    <? endif ?>
                <?php endwhile; ?>
              </ul>
        </div>          
      </div>
  </div>
<body>

