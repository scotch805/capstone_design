<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Image OCR Predictor</title>
    <style>
        body {
            background:#FCFDFE;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        html, body{
            margin:0;
            height:100%;
            overflow:hidden;
        }
        .info_box{
            width: 90%;
            margin: 0 auto;
            text-align: center;
            height: 130px;
        }
        .info_box .login {height:22%;text-align: right;cursor:pointer;}
        .info_box .title{
            margin-top:30px;
            margin-left: 0%;
            cursor:pointer;
        }
        .title_name{
            margin:0px;
            font-weight: 300;
            font-size: 45px;
        }
        .container{
            border-top:1px solid #ccc;
            display: flex;
            margin:0 auto;
            width:95%;
            height:calc(100% - 130px); /* 컨테이너 높이 조정 */
            position:relative;
        }
        .content {
            flex:1;
            overflow-y: auto; /* 스크롤 가능하도록 설정 */
        }
        .sidebar {
            width: 300px;
            height: 100%;
            border-left: 1px solid #ccc;
            position: relative; /* absolute에서 relative로 변경 */
            right:0px;
            display: flex;
            flex-direction: column;
            background-color:white;
        }
        .sidebar h2 {
            position: sticky;
            top: 0;
            background-color: white;
            padding-top: 10px;
            padding-bottom: 10px;
            z-index: 1;
        }
        .sidebar-content {
            overflow-y: auto;
            flex: 1;
            padding-top: 20px; /* 제목과 내용 사이의 여유 공간 */
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px; /* 하단 여유 공간 추가 */
        }
        .result-item {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
            padding-bottom: 10px;
            font-size: 16px; /* 결과보기 글자 크기 증가 */
        }
        h1 {
            font-weight:500;
            font-size:40px;
        }
        h2 {
            font-weight:500;
            font-size:40px;
        }
        .subtitle { position:relative;display:flex;font-weight:100;font-size:20px; top:-20px;}
        .imgform{position:relative;display:flex;font-weight:100;font-size:20px; top:-30px;}

        .result-item pre {
            display: none;
            font-size: 16px; /* 결과보기 글자 크기 증가 */
        }
        .result-item:hover pre {
            display: block;
        }
        img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
        .pill-info {
            font-size: 16px; /* pill-info 글자 크기 증가 */
        }
        button {
            border-radius:20px;
            border:none;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            font-size:15px;
            height:30px;
            width:100px;
            background-color:#D9D9D9;
            cursor:pointer;
        }
        button[type="submit"]{

            border-radius:20px;
            border:none;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            font-size:15px;
            height:30px;
            background: linear-gradient(210deg, #ADF47C, #379947);
            color:black;
            border:none;
            border-radius:20px;
            cursor:pointer; }
    </style>
    <script>
        function handleFormSubmit(event) {
            event.preventDefault();
            var formData = new FormData(event.target);

            fetch('ocr_and_chatgpt.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                document.getElementById("result").innerHTML = `
                    <h2>OCR 결과:</h2>
                    <pre>${result.ocr_text}</pre>
                    <h2>ChatGPT 결과:</h2>
                    <pre>${result.chatgpt_result}</pre>`;
                addRecentResult(result);
            })
            .catch(error => console.error('Error:', error));
        }

        function addRecentResult(result) {
            const recentResults = document.querySelector('.sidebar-content');
            const resultItem = document.createElement('div');
            resultItem.classList.add('result-item');
            resultItem.innerHTML = `
                <h3>결과</h3>
                <p>${result.chatgpt_result}</p>
                <pre style="display:none;">${result.chatgpt_result}</pre>
                <img src="${result.image_data}" alt="Uploaded Image">
                <button onclick="fetchPillInfo(event, '${result.chatgpt_result}')">정보보기</button>
                <div class="pill-info" style="display:none;"></div>
            `;
            recentResults.insertBefore(resultItem, recentResults.firstChild);
        }

        function fetchPillInfo(event, query) {
            event.stopPropagation();
            const button = event.target;
            const pillInfoDiv = button.nextElementSibling;

            fetch('fetch_pill_info.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ query: query })
            })
            .then(response => response.json())
            .then(result => {
                pillInfoDiv.style.display = 'block';
                pillInfoDiv.innerHTML = `${result.pill_info}`;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    
<div class="info_box">
    <div class="user-info">
        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </div>
        <div class="title" onclick=window.open("../main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
</div>
<div class="container">
    <div class="content">
        <h1>약 인식</h1>
        <p class="subtitle">사진 촬영으로 상비약의 정보를 확인해보세요.</p>
        <form class="imgform" onsubmit="handleFormSubmit(event)" enctype="multipart/form-data">
            <input type="file" id="file" name="image" accept="image/*" required>
            <button type="submit">인식 시작</button>
        </form>
        <div id="result"></div>
    </div>
    <div class="sidebar">
        <h2>최근 결과</h2>
        <div class="sidebar-content">
            <?php
            if (file_exists('result.json')) {
                $existing_data = json_decode(file_get_contents('result.json'), true);
                $existing_data = array_reverse($existing_data); // 최신 결과를 위로
                foreach ($existing_data as $index => $result) {
                    echo '<div class="result-item">';
                    if (isset($result['chatgpt_result'])) {
                        echo "<p>" . htmlspecialchars($result['chatgpt_result']) . "</p>";
                        echo '<pre style="display:none;">' . htmlspecialchars($result['chatgpt_result']) . '</pre>';
                    } else {
                        echo "<p>텍스트를 감지하지 못했습니다.</p>";
                    }
                    if (isset($result['image_data'])) {
                        echo '<img src="' . $result['image_data'] . '" alt="Uploaded Image">';
                    }
                    echo '<button onclick="fetchPillInfo(event, \'' . htmlspecialchars($result['chatgpt_result']) . '\')">정보 보기</button>';
                    echo '<div class="pill-info" style="display:none;"></div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
