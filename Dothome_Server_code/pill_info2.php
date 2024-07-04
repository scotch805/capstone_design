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

        #resultBox {
            width: 99%;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 12px;
            height: auto;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
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
        }

        .selected-drug {
            display: flex;
            align-items: center;
            padding: 5px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .selected-drug span {
            margin-right: 10px;
        }

        .selected-drug .remove-drug {
            cursor: pointer;
            color: red;
            font-weight: bold;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-container input {
            margin-left: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            margin-left: 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
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
        <div class="search-container">
            <button id="showDropdown">약 목록</button>
            <input type="text" id="searchInput" placeholder="검색어를 입력하세요...">
        </div>
        <select id="drugSelect" class="form-select" style="display:none;">
            <option value="" selected>약을 선택하세요</option>
            <option value="1">화이투벤큐노즈</option>
            <option value="2">엑쎈코</option>
            <option value="3">이지엔6프로</option>
            <option value="4">세노바퀵</option>
            <option value="5">속시나제</option>
            <option value="6">노텍</option>
            <option value="7">맥쎈</option>
            <option value="8">콜대원코프</option>
            <option value="9">콜대원노즈</option>
            <option value="10">노보민</option>
            <option value="11">소보민</option>
            <option value="12">후시딘</option>
            <option value="13">마데카솔</option>
            <option value="14">지르텍</option>
            <option value="15">미리코프파워</option>
            <option value="16">아진팜</option>
            <option value="17">화이투벤코프</option>
            <option value="18">파세몰</option>
            <option value="19">이부로엔</option>
            <option value="20">훼스탈</option>
            <option value="21">펜잘</option>
            <option value="22">바이스탑</option>
            <option value="23">로라딘</option>
            <option value="24">베아제</option>
            <option value="25">염산메클리진</option>
            <option value="26">그날엔코프</option>
            <option value="27">타이레놀</option>
            <option value="28">게보린</option>
            <option value="29">겔포스</option>
            <option value="30">알마겔</option>
            <option value="31">노루모</option>
            <option value="32">알벤다졸</option>
            <option value="33">위평원</option>
            <option value="34">장편환</option>
            <option value="35">케어번크림</option>
            <option value="36">로프민</option>
            <option value="37">포타겔</option>
            <option value="38">아즈렌</option>
        </select>

        <div id="resultBox">
            <div id="noResultsMessage">선택된 약이 없습니다.</div>
        </div>

        <div class="btn-container">
            <button id="showResults">결과 보기</button>
            <button id="clearSelection">Clear Selection</button>
        </div>

        <div>
            <h2>검색결과</h2>
        </div>

        <div id="resultArea"></div>

        <script>
            const drugSelect = document.getElementById('drugSelect');
            const resultBox = document.getElementById('resultBox');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const showResultsButton = document.getElementById('showResults');
            const clearSelectionButton = document.getElementById('clearSelection');
            const resultArea = document.getElementById('resultArea');
            const showDropdownButton = document.getElementById('showDropdown');
            const searchInput = document.getElementById('searchInput');

            const results = {
                '1': { name: '화이투벤큐노즈', manu: '알피바이오', dosa: '만 15세 이상 및 성인 : 1일 3회, 1회 2정, 만 7세 이상 만 15세 미만 : 1일 3회, 1회 1정', effi: '감기의 제증상(여러증상)(콧물, 코막힘, 재채기, 인후(목구멍)통, 기침, 가래, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통)의 완화', admi: '식후 30분 경구 투여' },
                '2': { name: '엑쎈코', manu: '알피바이오', dosa: '만 15세 이상 및 성인 : 1일 3회, 1회 2정', effi: '감기의 제증상(콧물, 코막힘, 재채기, 인후(목구멍)통, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통)의 완화', admi: '식후 30분 경구 투여' },
                '3': { name: '이지엔6프로', manu: '대웅제약', dosa: '성인: 1일 2～4회, 1회 300 mg을 투여', effi: '관절염, 류마티스관절염,관절증, 강직척추염, 외상 및 수술 후 통증성 부종 또는 염증, 통증 및 발열을 수반하는 감염증의 치료보조', admi: '경구 투여' },
                '4': { name: '세노바퀵', manu: '일동제약', dosa: '성인 및 6세 이상의 소아 : 세티리진염산염으로서 1일 1회 10mg(단, 이상반응에 민감한 환자의 경우 5mg씩을 아침, 저녁에 투여(정제, 경구용액제에 한함))', effi: '계절성 및 다년성 알레르기성 비염(코염), 알레르기성 결막염, 만성 특발성(원인불명의) 두드러기, 피부 소양증(가려움증)', admi: '취침 전 경구 투여' },
                '5': { name: '속시나제', manu: '일동제약', dosa: '성인 : 1일 3회, 1회 2정', effi: '소화성 궤양에 따른 다음 증상(위산과다, 속쓰림, 위부불쾌감, 위부팽만감, 식체(위체), 구역, 구토, 위통, 신트림, 소화불량)의 개선', admi: '매식간 경구 투여' },
                '6': { name: '노텍', manu: '미래바이오제약', dosa: '성인 및 6세 이상의 소아 : 세티리진염산염으로서 1일 1회 10mg(단, 이상반응에 민감한 환자의 경우 5mg씩을 아침, 저녁에 분할 투여)', effi: '계절성 및 다년성 알레르기성 비염(코염), 알레르기성 결막염, 만성 특발성(원인 불명의) 두드러기, 피부소양증(가려움증), 습진, 피부염(히드로코르티손 외용제와 병용)', admi: '취침 전 경구 투여' },
                '7': { name: '맥쎈', manu: '코스멕스파마', dosa: '류마티양 관절염, 골관절염, 강직성 척추염(성인 : 나프록센으로서 1일 2회(12시간마다), 1회 250~500mg), 급성통풍(성인 : 나프록세능로서 초회량으로 750mg투여 후 발작이 소실될 때까지 8시간 간격으로 250mg 투여), 골격근장애, 수술후 동통, 발치후 동통, 월경곤란증, 건염, 활액낭염(성인 : 나프록센으로서 초회량으로 500mg을 경구투여한 후 6~8시간 간격으로 250mg씩 투여(단 1일 총용량이 1,250mg을 초과하지 않도록 함)), 편두통(성인 : 나프록센으로서 초회량으로 750mg을 투여 후 필요시 1일 250~500mg을 더 투여 가능(단, 1일 총용량이 1,250mg을 초과하지 않도록 함))',
                    effi: '류마티양 관절염, 골관절염(퇴행성 관절질환), 강직성 척추염, 건(힘줄)염, 급성통풍, 월경곤란증, 활액낭염, 골격근장애(염좌, 좌상, 외상, 요천통), 수술후 동통, 편두통, 발치후 동통', admi: '경구 투여' },
                '8': { name: '콜대원코프', manu: '대원제약', dosa: '만 15세 이상 : 1회 1포(20ml), 만 11세 이상~만 15세 미만 : 1회 2/3포, 만 7세 이상~만 11세 미만 : 1회 1/2포, 만 3세 이상~만 7세 미만 : 1회 1/3포, 만 2세 이상~ 만 3세 미만 : 1회 1/4포', effi: '감기의 제증상(인후(목구멍)통, 기침, 가래, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통)의 완화', admi: '식후 30분 경구 투여' },
                '9': { name: '콜대원노즈', manu: '대원제약', dosa: '만 15세 이상 : 1회 20ml, 만 11세 이상~만 15세 미만 : 13ml, 만 7세 이상~만 11세 미만 : 10ml, 만 3세 이상~만 7세 미만 : 6,5ml, 만 2세 이상~ 만 3세 미만 : 5ml', effi: '감기의 제증상(콧물, 코막힘, 재채기, 인후(목구멍)통, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통)의 완화', admi: '식후 30분 경구 투여' },
                '10': { name: '노보민', manu: '삼익제약', dosa: '만 15세 이상 : 1회 1포(6ml), 만 13세 이상~만 15세 미만 : 1회 2/3포(4ml)', effi: '멀미에 의한 어지러움,구토,두통의 얘방 및 완화', admi: '경구 투여' },
                '11': { name: '소보민', manu: '삼익제약', dosa: '만 15세 이상 : 12ml, 만 11세 이상~만 15세 미만 : 9ml, 만 7세 이상~만 11세 미만 : 6ml, 만 3세 이상~만 7세 미만 : 3ml', effi: '멀미에 의한 어지러움, 구토, 두통의 예방 및 완화', admi: '경구 투여' },
                '12': { name: '후시딘', manu: '동화약품', dosa: '1일 1~2회 적당량', effi: '포도구균, 연쇄구균, 코리네박테륨, 클로스트리듐, 농피증(농가진, 감염성습진양피부염, 심상성여드름(보통여드름), 모낭염, 종기 및 종기증, 화농성한선염, 농가진성습진), 화상, 외상, 봉합창, 식피창에 의한 2차 감염', admi: '피부' },
                '13': { name: '마데카솔', manu: '동국제약', dosa: '1일 1~2회 적당량', effi: '네오마이신 감수성 세균에 의해 2차 감염된 피부질환의 초기 치료 : 작은 열상, 찰과상, 봉합된 상처, 표재성 2도 이하의 화상', admi: '피부' },
                '14': { name: '지르텍', manu: '한국유씨비제약', dosa: '성인 및 6세 이상의 소아 : 세티리진염산염으로서 1일 1회 10mg(단, 이상반응에 민감한 환자의 경우 5mg씩 아침, 저녁 분할 투여)', effi: '계절성 및 다년성 알레르기성 비염, 알레르기성 결막염, 만성 특발성 두드러기, 피부가려움증, 습진, 피부염(하이드로코티손 외용제와 병용)', admi: '취침 전 경구 투여' },
                '15': { name: '미리코프파워', manu: '알피바이오', dosa: '만 15세 이상 및 성인 : 1일 3회, 1회 1정', effi: '기침, 가래', admi: '식후 30분 경구 투여' },
                '16': { name: '아진팜', manu: '일양약품', dosa: '15세 이상의 성인 : 1일 3회, 1회 1정', effi: '소화불량, 식욕감퇴(식욕부진), 과식, 체함, 소화촉진, 소화불량으로 인한 위부팽만감, 정장, 변비, 묽은 변, 복부팽만감, 장내이상발효', admi: '경구 투여' },
                '17': { name: '화이투벤코프', manu: '알피바이오', dosa: '만 15세 이상 및 성인 : 1일 3회, 1회 2정', effi: '감기의 제중상(여러증상)(콧물, 코막힘, 재채기, 인후(목구멍)통, 기침, 가래, 오한(춥고 떨리는 증상), 발열, 두통, 관절통, 근육통)의 완화', admi: '식후 30분 경구 투여' },
                '18': { name: '파세몰비타', manu: '신일제약', dosa: '성인 : 1일 3회, 1회 1~2정', effi: '감기로 인한 발열 및 통증, 치통, 투동, 신경통, 근육통, 월경통, 관절통, 류마티스성 통증', admi: '공복을 피해 경구 투여' },
                '19': { name: '이부로엔', manu: '에스케이케미칼', dosa: '류마티양 관절염, 골관절염, 강직성 척추염, 연조직손상, 비관절 류마티스 질환, 급성 통풍, 건선(마른비늘증)성 관절염 : 성인 이부프로펜으로서 1일 3~4회, 1회 200~600mg(1일 최고 3200mg까지), 연소성 류마티양 관절염 : 1일 체중 kg당 20~40mg을 3~4회 분할, 경증(가벼운 증상) 및 중증도의 동통(통증), 감기 : 성인 1일 3~4회, 1회 200~400mg, 편두통 : 성인 1회 200~400mg(24시간 동안 400mg까지)',
                    effi: '감기로 인한 발열 및 동통(통증), 요통, 생리통, 류마티양 관절염, 연소성 류마티양 관절염, 골관절염(퇴행성 관절질환), 수술후 동통(통증), 두통, 편두통, 치통, 근육통, 신경통, 강직성 척추염, 급성통풍, 건선(마른비늘증),성 관절염, 연조직손상(염좌),좌상(타박상)), 비관절 류마티스질환(건염(힘줄염), 건초염(힘줄윤활막염), 활액(윤활)낭염)', admi: '경구 투여' },
                '20': { name: '훼스탈', manu: '한독', dosa: '성인 1일 3회, 1회 1정', effi: '소화불량, 식욕감퇴(식욕부진), 과식, 식체(위체(체함)), 소화촉진, 소화불량으로 인한 위부팽만감', admi: '식사 후 경구 투여' },
                '21': { name: '펜잘', manu: '종근당', dosa: '만 15세 이상의 성인 : 1일 3회, 1회 1정, 만 11세 이상~만 15세 미만 : 1일 3회, 1회 1/2~2/3정, 만 8세 이상~만 11세 미만 : 1일 3회, 1회 1/2정', effi: '두통, 치통, 발치(이를 뽑음)후 통증, 인후(목구멍)통, 귀의 통증, 관절통, 신경통, 요통, 근육통, 견통, 타박통, 골절통, 염좌통, 월경통, 외상통의 진통', admi: '경구 투여' },
                '22': { name: '바이스탑', manu: '신일제약', dosa: '만 15세 이상 : 1일 3회, 1회 2정, 만 11세 이상~만 15세 미만 : 1일 2회, 1회 2정, 만 8세 이상~만 11세 미만 : 1일 3회, 1회 1정', effi: '설사, 복통(배아픔)을 수반하는 설사, 체함, 묽은 변, 토사', admi: '경구 투여' },
                '23': { name: '로라딘', manu: '한솔신약', dosa: '성인 및 12세 이상의 소아 : 로라타딘으로서 1일 1회 10mg, 6~12세 미만의 소아(체중 30kg 이상) : 1일 1회 10mg', effi: '알레르기성 비염 증상(재채기, 콧물, 가려움, 눈의 작열감)의 일시적인 완화, 만성 특발성 두드러기 증상 완화', admi: '경구 투여' },
                '24': { name: '베아제', manu: '대웅제약', dosa: '성인 : 1일 3회, 1회 1정', effi: '소화불량, 식욕감퇴(식욕부진), 과식, 체함, 소화촉진, 소화불량으로 인한 위부팽만감', admi: '경구 투여' },
                '25': { name: '염산메클리진', manu: '한국파비스제약', dosa: '멀미에 의한 구역, 구토, 어지러움 : 성인 : 염산메클리진으로서 1일 1회 25~50mg, 미로염, 메니에르증후군, 방사선, 숙취에 의한 구역, 구토, 어지러움 : 성인 : 염산메클리진으로서 1일 2~3회, 1회 25mg(1일 75mg까지)', effi: '멀미에 의한 구역, 구토, 어지러움, 미로염, 메니에르증후군, 방사선, 숙취에 의한 구역, 구토, 어지러움', admi: '경구 투여' },
                '26': { name: '그날엔코프', manu: '경동제약', dosa: '만 15세 이상 : 1일 3회, 1회 2정', effi: '기침,가래', admi: '경구 투여' },
                '27': { name: '타이레놀', manu: '한국존슨앤드존슨', dosa: '만 12세 이상 소아 및 성인 : 1일 3~4회, 1회 1~2정(1일 최대 8정까지)', effi: '감기로 인한 발열 및 통증, 두통, 신경통, 근육통, 월경통, 염좌통, 치통, 관절통, 류마티양 통증', admi: '경구 투여' },
                '28': { name: '게보린', manu: '삼진제약', dosa: '성인 1일 3회, 1회 1정', effi: '두통, 치통, 발치 후 통증, 인후통, 귀의 통증, 관절통, 신경통, 요통, 근육통, 견통, 타박통, 골절통, 염좌통, 월경통, 외상통의 진통', admi: '공복을 피해 경구 투여' },
                '29': { name: '겔포스', manu: '보령', dosa: '성인 1일 3~4회, 1회 1포', effi: '위십이지장 궤양, 위염, 위산과다(속쓰림, 위통, 구역, 구토)', admi: '식간 및 취침시 경구 투여' },
                '30': { name: '알마겔', manu: '유한양행', dosa: '성인 및 12세 이상의 소아 : 알마게이트로서 1일 3회, 1회 1~1.5g', effi: '위십이지장궤양, 위염, 위산과다, 속쓰림, 구역, 구토, 위통, 신트림', admi: '식후 30분 경구 투여' },
                '31': { name: '노루모', manu: '일양약품', dosa: '성인 : 산화알루미늄으로서 1일 3회, 1회 1.212g', effi: '위십이지장궤양, 위염, 위산과다', admi: '경구 투여' },
                '32': { name: '알벤다졸', manu: '보령', dosa: '성인 및 24개월 이상의 소아 : 요충 : 1일 1회 알벤다졸로서 400mg복용 7일 후 한번만 더 400mg, 회충, 십이지장충, 편충, 아메리카구충 : 400mg 단회 복용, 분선충의 다른 기생충(조충)과 중증 혼합 감염시 : 1일 1회 이 약으로서 400mg씩 3일간 복용', effi: '회충, 요충, 십이지장충, 편충, 아메리카 구충, 분선충의 감염 및 읻르 혼합감염의 치료', admi: '경구 투여' },
                '33': { name: '위평원', manu: '한솔신약', dosa: '보통 성인 : 1일 3회, 1회 1포', effi: '급만성 위장카타르, 발효설사, 소화불량, 위하수, 신경성 위염, 위장허약, 숙취, 트림, 속쓰림, 구내염, 신경과민', admi: '경구 투여' },
                '34': { name: '장편환', manu: '한솔신약', dosa: '보통 성인 : 1일 3회, 1회 20환, 11~14세 : 1일 3회, 1회 13환, 8~10세 : 1일 3회, 1회 10환', effi: '급만성장염, 설사, 궤양성 대장염', admi: '경구 투여' },
                '35': { name: '케어번크림', manu: '두원사이언스제약', dosa: '1일 1회~수회 적당량', effi: '화상에 의한 짓무름과 통증의 완화', admi: '피부' },
                '36': { name: '로프민', manu: '영일제약', dosa: '성인 : 급성설사 : 초회량은 염산로페라미드로서 4mg, 유치량으로는 묽은 변이 있을 때마다 2mg씩 1일 상용량은 6~8mg이며 1일 최대투여량은 16mg, 만성설사 : 초회량은 염산로페라미드로서 4mg, 설사가 치료될 때까지 묽은 변이 있을 때마다 2mg 보통 유지용량은 1일 2~6mg이며 1일 최대용량은 16mg, 소아(9~12세) : 급성설사 : 초회량은 염산로페라미드로서 2mg 유치량으로는 묽은 변이 있을 때마다 2mg씩 1일 최대용량은 6mg', effi: '급성설사, 만성설사', admi: '경구 투여' },
                '37': { name: '포타겔', manu: '대원제약', dosa: '성인 : 디옥타헤드랄스멕타이트로서 1일 3회, 1회 3g(급성설사시의 초기 3일은 1일 용량을 2배로 증량할 수 있다. 식도염에는 식후에, 다른 정응증에는 식간에 복용), 소아(24개월 이상) : 3일 동안 이 약으로서 1일 6~9g을 3회 분할 복용하고 이후 4일 동안 1일 6g을 3회 분할 복용', effi: '성인의 식도, 위십이지장과 관련된 통증의 약화, 성인의 급만성 설사, 24개월 이상 소아의 급성 설사', admi: '경구 투여' },
                '38': { name: '아즈렌에스', manu: '태극제약', dosa: '1일 수회 환부에 도포', effi: '습진, 열상(화상), 그 외의 질환에 따른 미란 및 궤양', admi: '피부' },
            };

            const selectedDrugs = new Set();

            showDropdownButton.addEventListener('click', function () {
                drugSelect.style.display = drugSelect.style.display === 'none' ? 'block' : 'none';
            });

            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();
                const options = drugSelect.options;
                for (let i = 1; i < options.length; i++) {
                    const option = options[i];
                    const text = option.text.toLowerCase();
                    option.style.display = text.includes(filter) ? 'block' : 'none';
                }
            });

            drugSelect.addEventListener('change', function () {
                const selectedValue = drugSelect.value;
                if (selectedValue && !selectedDrugs.has(selectedValue)) {
                    selectedDrugs.add(selectedValue);
                    updateResultBox();
                }
            });

            function updateResultBox() {
                resultBox.innerHTML = '';
                if (selectedDrugs.size > 0) {
                    const table = document.createElement('table');
                    table.id = 'resultTable';
                    const headerRow = table.insertRow();
                    headerRow.innerHTML = `
                        <th>약 이름</th>
                        <th>제조사</th>
                        <th>용량</th>
                        <th>효능</th>
                        <th>용법</th>
                        <th></th>
                    `;
                    selectedDrugs.forEach(value => {
                        const drugInfo = results[value];
                        const row = table.insertRow();
                        row.innerHTML = `
                            <td>${drugInfo.name}</td>
                            <td>${drugInfo.manu}</td>
                            <td>${drugInfo.dosa}</td>
                            <td>${drugInfo.effi}</td>
                            <td>${drugInfo.admi}</td>
                            <td><span class="remove-drug" data-value="${value}">x</span></td>
                        `;
                    });
                    resultBox.appendChild(table);
                } else {
                    resultBox.appendChild(noResultsMessage);
                }
                addRemoveDrugEventListeners();
            }

            function addRemoveDrugEventListeners() {
                const removeDrugButtons = document.querySelectorAll('.remove-drug');
                removeDrugButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const value = this.getAttribute('data-value');
                        selectedDrugs.delete(value);
                        updateResultBox();
                    });
                });
            }

            clearSelectionButton.addEventListener('click', function () {
                selectedDrugs.clear();
                updateResultBox();
            });

            showResultsButton.addEventListener('click', function () {
                const resultMessages = [];
                const selectedValues = Array.from(selectedDrugs);
                let lastDrug = null;

                const drugWarnings = {
                    '1': [
                        { type: 'pregnancy', message: '화이투벤노즈 임부금기' },
                        { type: 'dose', message: '화이투벤노즈 용량주의' }],
                    '2': [
                        { type: 'pregnancy', message: '엑쎈코 임부금기' },
                        { type: 'dose', message: '엑쎈코 용량주의' }],
                    '3': [
                        { type: 'pregnancy', message: '이지엔6프로 임부금기' },
                        { type: 'overlap', drugs: ['7'], message: '이지엔6프로와 맥쎈 효능군중복' },
                        { type: 'overlap', drugs: ['19'], message: '이지엔6프로와 이부로엔 효능군중복' },
                        { type: 'overlap', drugs: ['21'], message: '이지엔6프로와 펜잘 효능군중복' },
                        { type: 'dose', message: '이지엔6프로 용량주의' }],
                    '4': [
                        { type: 'age', message: '세노바퀵 6세미만 연령금기' }],
                    '6': [
                        { type: 'age', message: '노텍 6세미만 연령금기' }],
                    '7': [
                        { type: 'pregnancy', message: '맥쌘은 임부금기' },
                        { type: 'overlap', drugs: ['19'], message: '맥쎈과 이부로엔 효능군중복' },
                        { type: 'overlap', drugs: ['21'], message: '맥쎈과 펜잘 효능군중복' },
                        { type: 'dose', message: '맥쌘 용량주의' }],
                    '8': [
                        { type: 'dose', message: '콜대원코프 용량주의' }],
                    '9': [
                        { type: 'pregnancy', message: '콜대원노즈 임부금기' },
                        { type: 'dose', message: '콜대원노즈 용량주의' }],
                    '10': [
                        { type: 'dose', message: '노보민 용량주의' }],
                    '11': [
                        { type: 'pregnancy', message: '소보민 임부금기' },
                        { type: 'dose', message: '소보민 용량주의' }],
                    '14': [
                        { type: 'age', message: '지르텍 6세미만 연령금기' }],
                    '17': [
                        { type: 'dose', message: '화이투벤코프 용량주의' }],
                    '18': [
                        { type: 'dose', message: '파세몰비타 용량주의' }],
                    '19': [
                        { type: 'pregnancy', message: '이부로엔 임부금기' },
                        { type: 'overlap', drugs: ['21'], message: '이부로엔과 펜잘 효능군중복' },
                        { type: 'dose', message: '이부로엔 용량주의' }],
                    '21': [
                        { type: 'dose', message: '펜잘 용량주의' }],
                    '22': [
                        { type: 'pregnancy', message: '바이스탑 임부금기' }],
                    '23': [
                        { type: 'age', message: '로라딘 6세미만 연령금기' },
                        { type: 'pregnancy', message: '로라딘 임부금기' },
                        { type: 'overlap', drugs: ['4'], message: '세노바퀵과 로라딘 효능군중복' },
                        { type: 'overlap', drugs: ['6'], message: '노텍과 로라딘 효능군중복' },
                        { type: 'overlap', drugs: ['14'], message: '지르텍과 로라딘 효능군중복' }],
                    '25': [
                        { type: 'age', message: '염산메클리진 65세이상 고령자 노인주의' },
                        { type: 'dose', message: '염산메클리진 용량주의' }],
                    '27': [
                        { type: 'dose', message: '타이레놀 용량주의' }],
                    '28': [
                        { type: 'age', message: '게보린은 15세미만 연령금기' },
                        { type: 'pregnancy', message: '게보린 임부금기' },
                        { type: 'dose', message: '게보린 용량주의' }],
                    '32': [
                        { type: 'age', message: '알벤다졸은 2세미만 연령금기' },
                        { type: 'pregnancy', message: '알벤다졸은 임부금기' }],
                    '36': [
                        { type: 'age', message: '로프민 24개월미만 연령금기' },
                        { type: 'pregnancy', message: '로프민 임부금기' },
                        { type: 'dose', message: '로프민 용량주의' }],
                    '37': [
                        { type: 'age', message: '포타겔 24개월미만 연령금기' },
                        { type: 'pregnancy', message: '포타겔 임부금기' }],
                };

                selectedValues.forEach(value => {
                    if (drugWarnings[value]) {
                        drugWarnings[value].forEach(warning => {
                            if (warning.type === 'overlap') {
                                warning.drugs.forEach(drug => {
                                    if (selectedValues.includes(drug)) {
                                        resultMessages.push(warning.message);
                                    }
                                });
                            }
                        });
                    }
                });

                selectedValues.forEach(value => {
                    if (drugWarnings[value]) {
                        if (lastDrug !== null && lastDrug !== value) {
                            resultMessages.push('=========================');
                        }
                        drugWarnings[value].forEach(warning => {
                            if (warning.type !== 'overlap')
                                resultMessages.push(warning.message);
                        });
                        lastDrug = value;
                    }
                });

                if (resultMessages.length === 0) {
                    resultMessages.push('선택된 약 정보가 없습니다.');
                }

                resultArea.innerHTML = '<div>' + resultMessages.join('</div><div>') + '</div>';
            });
        </script>
    </div>
</body>

</html>
