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
    </style>
</head>

<body>
    <div class="container">

        <div class="form-check">
            <label>
                <input type="checkbox" class="checkbox" value="1"> 펠로엔정
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="2"> 타이레놀정
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="3"> 아진팜정
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="4"> 애스펜정
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="5"> 네오티가손
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="6"> 테라싸이클린캡슐
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="7"> 미노씬캡슐
            </label>
            <label>
                <input type="checkbox" class="checkbox" value="8"> 나제론오디정
            </label>
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
                '1': { name: '펠로엔정', manu: '휴온스', cate: '전문의약품', dosa: '성인 : 1회 1정, 1일 3회', effi: '골관절염, 류마티스관절염, 요통', admi: '식후 경구 투여' },
                '2': { name: '타이레놀정500mg', manu: '한국존슨앤드존슨', cate: '일반의약품', dosa: '만 12세 이상 소아 및 성인: 1회 1~2정씩 1일 3-4회 (4-6시간 마다)', effi: '두통, 신경통, 근육통, 월경통, 염좌통', admi: '필요시 경구 투여' },
                '3': { name: '아진팜정', manu: '일양약품', cate: '일반의약품', dosa: '15세 이상의 성인 1회 1정, 1일 3회', effi: '소화불량, 식욕감퇴(식욕부진), 과식, 체함, 소화불량으로 인한 위부팽만감', admi: '경구 투여' },
                '4': { name: '애스펜정', manu: '휴온스', cate: '전문의약품', dosa: '성인 : 덱시부프로펜으로서 1회 300 mg을 1일 2～4회', effi: '류마티스관절염, 관절증,강직척추염, 외상 및 수술 후 통증성 부종 또는 염증', admi: '경구 투여' },
                '5': { name: '네오티가손10mg', manu: '휴온스', cate: '전문의약품', dosa: '1일 25 ～ 30 mg을 약 2 ～ 4주간', effi: '국소 또는 전신화된 농포성 건선, 심상성 건선', admi: '경구 투여' },
                '6': { name: '테라싸이클린캡슐250mg', manu: '종근당', cate: '전문의약품', dosa: '성인 : 1일 1 g을 4회 분할 투여 <br>12세 이상의 소아 : 1일 체중 kg당 25 ～ 50 mg을 4회 분할 투여', effi: '유효균종 : 테트라사이클린염산염에 감수성인 리케차, 폐렴미코플라스마, 육아종피막성구균, 트라코마 클라미디아 <br>적응증 : 발진티푸스, 발진열, 양충병(쯔쯔가무시병), 미코플라스마폐렴, 비둘기병, 앵무병, 서혜육아종', admi: '경구 투여' },
                '7': { name: '미노씬캡슐50mg', manu: '에스케이케미카', cate: '전문의약품', dosa: '성인 : 초회 200mg을 투여 후 12시간마다 100 mg 투여<br>12세 이상의 소아 : 초회 체중 Kg당 4mg 투여 후 12시간마다 체중 Kg당 2mg 투여', effi: '유효균종 : 리케차, 폐렴미코플라스마, 육아종피막성구균, 트라코마 클라미디아, 연성하감균, 콜레라균, 페스트균<br> 적응증 : 발진티푸스, 발진열, 양충병(쯔쯔가무시병), 큐열, 진드기열, 미코플라스마폐렴, 앵무병', admi: '경구 투여' },
                '8': { name: '나제론오디정0.1mg', manu: '보령', cate: '전문의약품', dosa: '성인 : 항암제(시스플라틴 등) 투여 전 1시간 이내에 1일 1회 0.1 mg을 투여', effi: '항암제(시스플라틴 등) 투여로 인한 구역 및 구토의 방지', admi: '경구 투여' }
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