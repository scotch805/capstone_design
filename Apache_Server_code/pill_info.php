<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>결과 보기 예시</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .container {
            font-size: 17px;
            display: flex;
            flex-direction: column;
            align-items: flex-center;
        }

        .form-check {
            /* 수정된 부분: form-check를 가로로 나열하도록 변경 */
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* 체크박스 간 간격 */
            width: 100%;
        }

        .form-check label {
            width: calc(12.5% - 20px);
            /* 8개씩 나열하기 위한 너비 설정 */
        }

        #resultBox {
            width: 99%;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 12px;
            /* 원하는 글자 크기로 조절 */
            height: auto;
            /* 자동으로 크기 조절 */
            overflow: hidden;
            /* 스크롤바 숨김 */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .btn-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn-container button {
            margin-left: 10px;
        }

        #resultTable {
            width: 100%;
            border-collapse: collapse;
        }

        #resultTable th,
        #resultTable td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        #noResultsMessage {
            font-size: 60px;
            /* 원하는 글자 크기로 조절 */
        }

        .resultGrid {
            display: flex;
            justify-content: center;
            align-items: center;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 10px;
            border: 1px solid #ccc;
            /* 테두리 추가 */
            padding: 10px;
            background-color: #f5f5f5;
            /* 배경색 추가 */
        }

        .resultGrid>div {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #resultBox.innerHTML {
            font-size: 80px;
            /* 원하는 글자 크기로 조절 */
        }

        /* 홈 화면 등 */
        .info_box{
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        .info_box .title{
            margin-left: 0%;
            display: inline-block;
        }
        .info_box .login {
            display: inline-block;
            position: relative;
            left: 40%;
        }
        .title_name{
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="info_box">
        <div class="title" onclick=window.open("main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>

        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </div>

    <div class="container">

        <div class="form-check">
            <label>
                <input type="checkbox" class="checkbox" value="1"> 화이투벤큐노즈
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="2"> 엑쎈코
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="3"> 이지엔6프로
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="4"> 세노바퀵
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="5"> 속시나제
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="6"> 노텍정
            </label>
            <!-- <label>
                <input type="checkbox" class="checkbox" value="7"> 맥쎈
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="8"> 콜대원코드
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="9"> 콜대원노즈
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="10"> 노보민
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="11"> 소보민
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="12"> 후시딘
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="13"> 마데카솔
            </label> -->
            <!-- 다른 체크박스 항목들도 동일하게 추가 -->
        </div>

        <div id="resultBox">
            <!-- 선택한 조건에 따른 결과가 여기에 표시될 것입니다. -->
            <!-- 서버로부터 받아온 데이터를 여기에 출력 -->
            <div id="searchResults">
                <div id="noResultsMessage">선택된 약이 없습니다.</div>
            </div>
        </div>


        <div class="btn-container">
            <button id="showResults">결과 보기</button>
            <button id="clearSelection">Clear Selection</button>
        </div>

        <div>
            <h2>검색결과</h2>
        </div>

        <div id=":resultArea">

        </div>

        <!-- <div id="resultGrid" class="container text-center">
            <div class="row row-cols-3">
                <div class="resultGrid">병용금기</div>
                <div class="resultGrid">연령금기</div>
                <div class="resultGrid">임부금기</div>
                <div class="resultGrid">동일성분중복</div>
                <div class="resultGrid">효능군중복</div>
                <div class="resultGrid">투여기간주의</div>
            </div>
        </div> -->



        <!-- 결과를 표시할 영역 -->
        <div id="resultArea">


        </div>


        <script>
            const checkboxes = document.querySelectorAll('.checkbox');
            const showResultsButton = document.getElementById('showResults');
            const clearSelectionButton = document.getElementById('clearSelection');
            const resultBox = document.getElementById('resultBox');
            const noResultsMessage = document.getElementById('noResultsMessage'); // 추가

            // 결과 박스의 높이를 150px로 설정
            resultBox.style.height = '200px';

            // 결과 박스의 컨텐츠가 결과 박스의 높이를 초과하면, 결과 박스의 높이를 자동으로 늘린다.
            resultBox.addEventListener('scroll', function () {
                if (resultBox.scrollHeight > resultBox.clientHeight) {
                    resultBox.style.height = resultBox.scrollHeight + 'px';
                }
            });


            const results = {
                '1': { name: '화이투벤큐노즈', manu: '알피바이오', cate: '일반의약품', dosa: '만 15세 이상 : 1회 2정, 1일 3회, 만 7세 이상 만 15세 미만 : 1일 3회, 1회 1캡슐', effi: '콧물, 코막힘, 재채기, 인후(목구멍)통, 기침, 가래, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통', admi: '식후 경구 투여' },
                '2': { name: '엑쎈코', manu: '알피바이오', cate: '일반의약품', dosa: '만 15세 이상 및 성인 : 1회 2캡슐, 1일 3회', effi: '콧물, 코막힘, 재채기, 인후(목구멍)통, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통', admi: '식후 경구 투여' },
                '3': { name: '이지엔6프로', manu: '대웅제약', cate: '일반의약품', dosa: '성인: 1회 300 mg을 1일 2～4회 경구투여', effi: '관절염, 류마티스관절염, 염증', admi: '경구 투여' },
                '4': { name: '세노바퀵', manu: '일동제약', cate: '일반의약품', dosa: '성인 및 6세 이상의 소아 : 1일 1회 10mg 취침 전에 경구투여', effi: '알레르기성 비염(코염), 알레르기성 결막염, 만성 특발성(원인불명의) 두드러기', admi: '경구 투여' },
                '5': { name: '속시나제삼중정', manu: '일동제약', cate: '일반의약품', dosa: '성인 1회 2정 1일 3회', effi: '위산과다, 속쓰림, 위부불쾌감, 위부팽만감, 식체(위체), 구역, 구토, 위통, 신트림, 소화불량', admi: '매식간 복용' },
                '6': { name: '노텍정', manu: '미래바이오제약', cate: '일반의약품', dosa: '성인 및 6세 이상의 소아 : 1일 1회 10mg 취침 전에 경구 투여한다.', effi: '알레르기성 비염(코염), 알레르기성 결막염, 만성 특발성(원인불명의) 두드러기, 습진, 피부염', admi: '경구 투여' },
            //     '7': { name: '미노씬캡슐50mg', manu: '에스케이케미카', cate: '일반의약품', dosa: '성인 : 초회 200mg을 투여 후 12시간마다 100 mg 투여<br>12세 이상의 소아 : 초회 체중 Kg당 4mg 투여 후 12시간마다 체중 Kg당 2mg 투여', effi: '유효균종 : 리케차, 폐렴미코플라스마, 육아종피막성구균, 트라코마 클라미디아, 연성하감균, 콜레라균, 페스트균<br> 적응증 : 발진티푸스, 발진열, 양충병(쯔쯔가무시병), 큐열, 진드기열, 미코플라스마폐렴, 앵무병', admi: '경구 투여' },
            //     '8': { name: '나제론오디정0.1mg', manu: '보령', cate: '일반의약품', dosa: '성인 : 항암제(시스플라틴 등) 투여 전 1시간 이내에 1일 1회 0.1 mg을 투여', effi: '항암제(시스플라틴 등) 투여로 인한 구역 및 구토의 방지', admi: '경구 투여' }
            };

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    let selectedInfo = [];

                    checkboxes.forEach(cb => {
                        if (cb.checked && results[cb.value]) {
                            selectedInfo.push(results[cb.value]);
                        }
                    });

                    // 선택한 약 정보를 표 형식으로 표시
                    if (selectedInfo.length > 0) {
                        let table = '<table id="resultTable">';
                        table += '<tr><th>약 이름</th><th>제조사</th><th>분류</th><th>용량</th><th>효능</th><th>용법</th></tr>';
                        selectedInfo.forEach(info => {
                            table += '<tr><td>' + info.name + '</td><td>' + info.manu + '</td><td>' + info.cate + '</td><td>' + info.dosa + '</td><td>' + info.effi + '</td><td>' + info.admi + '</td></tr>';
                        });
                        table += '</table>';
                        resultBox.innerHTML = table;
                        resultBox.style.height = 'auto'; // 내용에 맞게 크기 조절
                    } else {
                        resultBox.innerHTML = '';
                        resultBox.style.height = '200px'; // 초기 크기로 되돌림
                    }
                });
            });

            clearSelectionButton.addEventListener('click', function () {
                checkboxes.forEach(cb => {
                    cb.checked = false;
                });
                clearResults(); // Clear the results
                noResultsMessage.style.display = 'block'; // Show the "No selected items" message
                resultBox.innerHTML = noResultsMessage.outerHTML; // noResultsMessage 표시
            });

            function clearResults() {
                resultArea.innerHTML = '';
            }

            showResultsButton.addEventListener('click', function () {
                let selectedValues = [];
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        selectedValues.push(cb.value);
                    }
                });

                let resultMessages = [];

                if ((selectedValues.includes('5') && selectedValues.includes('6')) ||
                    (selectedValues.includes('5') && selectedValues.includes('7')) ||
                    (selectedValues.includes('5') && selectedValues.includes('6') && selectedValues.includes('7'))) {
                    resultMessages.push('병용금지');
                }

                if (selectedValues.includes('6') || selectedValues.includes('7')) {
                    resultMessages.push('연령금기');
                }

                if (selectedValues.includes('1') || selectedValues.includes('4') || selectedValues.includes('5') || selectedValues.includes('6') || selectedValues.includes('7')) {
                    resultMessages.push('임부금기');
                }

                if (selectedValues.includes('1') && selectedValues.includes('4')) {
                    resultMessages.push('효능군중복');
                }

                if (selectedValues.includes('2') || selectedValues.includes('4')) {
                    resultMessages.push('용량주의');
                }

                if (selectedValues.includes('1')) {
                    resultMessages.push('투여기간주의');
                }

                if (resultMessages.length === 0) {
                    resultMessages.push('선택된 약 정보가 없습니다.');
                }

                resultArea.innerHTML = '<div>' + resultMessages.join('</div><div>') + '</div>';
            });

        </script>


    </div>

</body>

</html>