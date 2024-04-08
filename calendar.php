<link rel="stylesheet" href="calendar_design.css">

<?php 
	// GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
	$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
	// GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
	$month = isset($_GET['month']) ? $_GET['month'] : date('m');
  $today = isset($_GET['day']) ? $_GET['day'] : date('d');

	$date = "$year-$month-01"; // 현재 날짜
	$time = strtotime($date); // 현재 날짜의 타임스탬프
	$start_week = date('w', $time); // 1. 시작 요일
	$total_day = date('t', $time); // 2. 현재 달의 총 날짜
	$total_week = ceil(($total_day + $start_week) / 7);  // 3. 현재 달의 총 주차
?>

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
                      <input type="submit" name="test" id="test" value= <?php echo $n++ ?> /> <!-- 나머지는  -->
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

<?php // php function

  function testfun()
  {
    echo "Your test function on button click is working";
  }

  if(array_key_exists('test',$_POST)){    // name의 test를 이용
    testfun();
  }

  ?>

</div>

