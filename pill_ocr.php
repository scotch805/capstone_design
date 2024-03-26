<!doctype html>
<html lang="en">

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
</head>

<body>
    <header>

    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <input type="file" id="input_image" accept="image/*" onchange="loadImage(this)">
                    <br>
                    <img id="preview" width="640" />
                </div>
                <div class="col-md-6">
                    
                    <div id="medicineInfo"></div>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-primary" id="pred_button" onclick="predict()">예측</button>
            <div id="prediction"></div>
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script>
        let model;

        async function app() {
            model = await tf.loadLayersModel('https://raw.githubusercontent.com/scotch805/medicine/main/model/model.json');
        }

        async function loadImage(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function predict() {
            let image = document.getElementById("preview");
            image = tf.browser.fromPixels(image);
            image = tf.image.resizeBilinear(image, [224, 224]).div(255);
            image = tf.expandDims(image, 0);
            const pred = model.predict(image).arraySync();
            const { values, indices } = tf.topk(pred, 3);
            const topIndices = indices.arraySync()[0];

            let predictionHTML = '';
            for (let i = 0; i < topIndices.length; i++) {
                predictionHTML += `${imagenetLabels[topIndices[i]]} : ${(values.arraySync()[0][i] * 100).toFixed(2)}%<br>`;
            }
            document.getElementById('prediction').innerHTML = predictionHTML;

            // 가장 확률이 높은 약품의 정보를 출력
            const topPredictionIndex = topIndices[0];
            const topPrediction = medicineInfo[topPredictionIndex];
            const infoHTML = `
                <h3>약품 정보</h3>
                <p>이름: ${topPrediction.name}</p>
                <p>제조사: ${topPrediction.manu}</p>
                <p>카테고리: ${topPrediction.cate}</p>
                <p>용법 및 복용량: ${topPrediction.dosa}</p>
                <p>효능: ${topPrediction.effi}</p>
                <p>투여 방법: ${topPrediction.admi}</p>
            `;
            document.getElementById('medicineInfo').innerHTML = infoHTML;
        }

        const imagenetLabels = [
            "나제오디정",
            "네오티가손",
            "미노씬캡슐",
            "아진팜정",
            "애스펜정",
            "타이레놀정",
            "테라싸이클린캡슐",
            "펠로엔정"
        ];


        const medicineInfo = {
            // 약품 정보들
            '0': { name: '나제론오디정0.1mg', manu: '보령', cate: '전문의약품', dosa: '성인 : 항암제(시스플라틴 등) 투여 전 1시간 이내에 1일 1회 0.1 mg을 투여', effi: '항암제(시스플라틴 등) 투여로 인한 구역 및 구토의 방지', admi: '경구 투여' },
            '1': { name: '네오티가손10mg', manu: '휴온스', cate: '전문의약품', dosa: '1일 25 ～ 30 mg을 약 2 ～ 4주간', effi: '국소 또는 전신화된 농포성 건선, 심상성 건선', admi: '경구 투여' },
            '2': { name: '미노씬캡슐50mg', manu: '에스케이케미카', cate: '전문의약품', dosa: '성인 : 초회 200mg을 투여 후 12시간마다 100 mg 투여<br>12세 이상의 소아 : 초회 체중 Kg당 4mg 투여 후 12시간마다 체중 Kg당 2mg 투여', effi: '유효균종 : 리케차, 폐렴미코플라스마, 육아종피막성구균, 트라코마 클라미디아, 연성하감균, 콜레라균, 페스트균<br> 적응증 : 발진티푸스, 발진열, 양충병(쯔쯔가무시병), 큐열, 진드기열, 미코플라스마폐렴, 앵무병', admi: '경구 투여' },
            '3': { name: '아진팜정', manu: '일양약품', cate: '일반의약품', dosa: '15세 이상의 성인 1회 1정, 1일 3회', effi: '소화불량, 식욕감퇴(식욕부진), 과식, 체함, 소화불량으로 인한 위부팽만감', admi: '경구 투여' },            
            '4': { name: '애스펜정', manu: '휴온스', cate: '전문의약품', dosa: '성인 : 덱시부프로펜으로서 1회 300 mg을 1일 2～4회', effi: '류마티스관절염, 관절증,강직척추염, 외상 및 수술 후 통증성 부종 또는 염증', admi: '경구 투여' },
            '5': { name: '타이레놀정500mg', manu: '한국존슨앤드존슨', cate: '일반의약품', dosa: '만 12세 이상 소아 및 성인: 1회 1~2정씩 1일 3-4회 (4-6시간 마다)', effi: '두통, 신경통, 근육통, 월경통, 염좌통', admi: '필요시 경구 투여' },
            '6': { name: '테라싸이클린캡슐250mg', manu: '종근당', cate: '전문의약품', dosa: '성인 : 1일 1 g을 4회 분할 투여 <br>12세 이상의 소아 : 1일 체중 kg당 25 ～ 50 mg을 4회 분할 투여', effi: '유효균종 : 테트라사이클린염산염에 감수성인 리케차, 폐렴미코플라스마, 육아종피막성구균, 트라코마 클라미디아 <br>적응증 : 발진티푸스, 발진열, 양충병(쯔쯔가무시병), 미코플라스마폐렴, 비둘기병, 앵무병, 서혜육아종', admi: '경구 투여' },
            '7': { name: '펠로엔정', manu: '휴온스', cate: '전문의약품', dosa: '성인 : 1회 1정, 1일 3회', effi: '골관절염, 류마티스관절염, 요통', admi: '식후 경구 투여' }
       
        };
        app();

    </script>
</body>

</html>