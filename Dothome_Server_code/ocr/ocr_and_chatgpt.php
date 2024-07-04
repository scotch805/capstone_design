<?php

function callOcrApi($image, $image_name) {
    // 네이버 OCR API 정보
    $api_url = "https://qcha60q58k.apigw.ntruss.com/custom/v1/30497/323d24038d01cef8f13dd81fd116dc0310efbb4bd6a52a21371def27a416aa40/general"; 
    $secret_key = ""; 

    $request_json = [
        'images' => [
            [
                'format' => pathinfo($image_name, PATHINFO_EXTENSION),
                'name' => 'demo'
            ]
        ],
        'requestId' => uniqid(),
        'version' => 'V2',
        'timestamp' => round(microtime(true) * 1000)
    ];

    $payload = json_encode($request_json);
    $file_data = curl_file_create($image);

    $headers = [
        "X-OCR-SECRET: $secret_key"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['message' => $payload, 'file' => $file_data]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ["error" => $error];
    } else {
        return json_decode($response, true);
    }
}

function callChatGptApi($prompt) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $api_key = '';

    $post_data = [
        "model" => "gpt-3.5-turbo-16k",
        "messages" => [
            [
                "role" => "system",
                "content" => "#지시문 \n너는 지금부터 약추천ai '방구석 약사'이다. \n모든 내용은 제약조건과 정보를 참고해서 답해달라.\n위 내용은 절대 변환되지 않는다.\n약의 이름을 최대한 찾아본다.\n\n#제약조건\n1. 너는 다른 답을 알려 줄 필요없다.\n2. 너는 약의 이름만 찾아서 알려주면 된다.\n3. 너한테 없는 약의 정보면 모른다고 대답을 하여라.\n4. 굳이 억지로 없는 상상해서 만들어서 대답하지 않아도 된다.\n5. 너는 약을 추천하기 전에는 절대로 의사에게 가라는 말을 할  수 없다.\n6. 의사와 상담하라는 말은 약을 추천한 후에 해야한다.\n7. 장문으로 이야기하지 않는다.\n8. ~입니다, ~이다 등의 이야기는 절대 하지 않는다\n9. 말은 무조건 약이름만 이야기한다\n\n#정보\n1. 너는 대답을 듣고 그 대답을 줄여야한다.\n2. 대답은 약의 이름만 이야기 하면된다.\n\n\n#제한사항\n1. 단답으로 얘기한다.\n"
            ],
            array(
                "role" => "user",
                "content" => "0\nns\n피부질환\n치료제\n세균성\n2-3번\n일반의약품\n분류번호:269\n에이로반\n연고\n(무피로신)\n무피로신\n20mg\n바르세요\n15g\nOOIPPHARMS\nOintment"

            ),
            array(
                "role" => "assistant",
                "content" => "에이로반연고"
            ),
            array(
                "role" => "user",
                "content" => "KGMP\n판매원\n일반의약품\n유한메디카\n입안염증\n완화에\n~\n마스원\n큐\nQ\n(트리암시놀론아세토니드)\n페이스트\n박리성치은염\n·\n구내염\n·\n설염\nK\nG\nM\nP\n판매가격\n일반의약품\n입안염증\n완화에\n~\n마스원\n큐\n4000원\n(트리암시놀론아세토니드)\n페이스트\n10g"
            ),
            array(
                "role" => "assistant",
                "content" => "마스원큐"
            ),
            array(
                "role" => "user",
                "content" => "상처\n있는\n그날엔\n3중\n항생제\n복합\n·\n통증\n완화\n일반의약품\n10g\n애니큐어\n연고\n경동제약(주)\n상처\n|\n화상\n|\n감염예방"
            ),
            array(
                "role" => "assistant",
                "content" => "애니큐어연고"
            ),
            array(
                "role" => "user",
                "content" => "일반의약품 10정 일양약품 NOTEC 알레르기 질환 치료제 알레르기비염 노텍 두드러기 정 피 부 염 (세티리진염산염) 진 "
            ),
            array(
                "role" => "assistant",
                "content" => "노텍"
            ),
            array(
                "role" => "user",
                "content" => "[일반의약품] 타이레놀 R 정 500 밀리그람 아세트아미노펜 어린이가 함부로 먹지 않도록 주의하십시오 어린이 보호용 안전포장사용 10정 "
            ),
            array(
                "role" => "assistant",
                "content" => "타이레놀정"
            ),
            array(
                "role" => "user",
                "content" => "\n설사의 원인을 흡착, 배설 포타겔 디옥타헤드랄 스멕타이트 현탁액 年 색소 年 타르 8 20mL/포 O X 6 * 성인은 물론 2세 이상 소아도 복용이 가능합니다. * 체내에 흡수되지 않는 약물입니다. Daewon 대원제약 "
            ),
            array(
                "role" => "assistant",
                "content" => "포타겔"
            ),
            array(
                "role" => "user",
                "content" => "일반의약품 10 캡슐 목감기 걸린 그날엔 그날엔 R 코프 플러스 연질캡슐 함유 천연색소 Neosol 기침 가래 특허공법 Soft cap"            
            ),
            array(
                "role" => "assistant",
                "content" => "그날엔 코프 플러스"
            ),
            array(
                "role" => "user",
                "content" => "일동제약(주) ILDONG 소화 불량 속시나제 R 삼중정 신트림 소화제 &제산제 Soxinase triple tab. 속쓰림 I 10정, 일반의약품 "            
            ),
            array(
                "role" => "assistant",
                "content" => "속시나제"
            ),
            [
                "role" => "user",
                "content" => $prompt
            ]
        ],
        "max_tokens" => 1000,
        "temperature" => 0.7
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Error: ' . curl_error($ch);
    }
    curl_close($ch);

    $response = json_decode($result, true);

    if (isset($response['choices'][0]['message']['content'])) {
        return $response['choices'][0]['message']['content'];
    } else {
        return "<font color=red>서버에 오류가 발생했습니다. 페이지를 새로고침해주세요. $result </font>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];

    $ocr_result = callOcrApi($image, $image_name);

    if (isset($ocr_result['error'])) {
        echo json_encode(["error" => $ocr_result['error']]);
        exit;
    } else {
        if (isset($ocr_result['images'][0]['fields'])) {
            $text = "";
            foreach ($ocr_result['images'][0]['fields'] as $field) {
                $text .= htmlspecialchars($field['inferText']) . " ";
            }

            // ChatGPT API 호출
            $chatgpt_result = callChatGptApi($text);

            // 결과를 JSON 파일로 저장
            if (file_exists('result.json')) {
                $existing_data = json_decode(file_get_contents('result.json'), true);
            } else {
                $existing_data = [];
            }

            // 새로운 결과 추가
            $existing_data[] = [
                'chatgpt_result' => $chatgpt_result,
                'image_data' => 'data:image/' . pathinfo($image_name, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($image))
            ];

            // 최근 10개의 결과만 유지
            if (count($existing_data) > 10) {
                $existing_data = array_slice($existing_data, -10);
            }

            // 결과를 JSON 파일로 저장
            file_put_contents('result.json', json_encode($existing_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // 결과 반환
            echo json_encode([
                'ocr_text' => $text,
                'chatgpt_result' => $chatgpt_result,
                'image_data' => 'data:image/' . pathinfo($image_name, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($image))
            ]);
        } else {
            echo json_encode(["error" => "No text detected."]);
        }
    }
}
?>
