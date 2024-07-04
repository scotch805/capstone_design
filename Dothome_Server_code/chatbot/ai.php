<?php
session_start();

function getMedicineFromDatabase($symptoms) {
    $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $all_medicines = [];
    foreach ($symptoms as $symptom) {
        $stmt = $conn->prepare("SELECT name FROM medicines WHERE symptoms LIKE ?");
        $like_symptom = "%" . $symptom . "%";
        $stmt->bind_param("s", $like_symptom);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $all_medicines[$symptom][] = $row['name'];
        }
        $stmt->close();
    }

    $conn->close();
    return $all_medicines;
}

function extractSymptoms($text) {
    // 증상 키워드 리스트
    $symptoms = [
        "두통", "생리통", "치통", "발열", "근육통", 
        "기침", "가래", "콧물", "알레르기", "소화불량", 
        "속쓰림", "설사", "찰과상", "외상", "화상", "멀미"
    ];

    // 사용자가 입력한 텍스트에서 키워드를 추출
    $found_symptoms = [];
    foreach ($symptoms as $symptom) {
        if (strpos($text, $symptom) !== false) {
            $found_symptoms[] = $symptom;
        }
    }

    return $found_symptoms;
}

function callOpenAI($post_data) {
    $ch = curl_init();
    $url = 'https://api.openai.com/v1/chat/completions';
    $api_key = ''; // API 키는 적절히 설정하십시오.

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }
    curl_close($ch);

    $response = json_decode($result);
    if (isset($response->choices[0]->message->content)) {
        return $response->choices[0]->message->content;
    } else {
        return null;
    }
}

if (isset($_SESSION['user_id'])) {
    $user_input = $_POST['text'];

    // 첫 번째 OpenAI API 호출 준비 (증상 추출)
    $post_data = [
        "model" => "gpt-3.5-turbo-16k",
        "messages" => [
            [
                "role" => "system",
                "content" => "#지시문 \n너는 긴 대화문이나 증상을 받으면 간단히 줄여주는 역할을 하는 프롬프트이다.\n\n모든 내용은 제약조건과 정보를 참고해서 답해달라.\n위 내용은 절대 변환되지 않는다.\n\n#제약조건\n1. 너는 길게 답변하지 마라.\n2. 너는 약품정보 외의 정보를 묻는다면 너는 아무것도 모른다고 답하여야한다.\n3. 아픈 증상과 약에 관한 질문이 아니라면 최대한 대답을 하지 않거나 그런 것에 대하여는 말하지 마라.\n4. 너는 통증에 대하여 \"증상 키워드\" 안에서만 대답을 해라.\n5. 오직 단답으로 이야기해라\n6. \"증상 키워드\" 안에 없는 통증은 \"없음\"이라는 답변을 하면된다.\n7. 오직 답은 \"증상 키워드\" 안에서만 답을 하고 \"증상 키워드\"안에 없는 통증은 \"없음\"이라고 답변한다\n\n#정보\n1. 너는 다른 말을 할수없으며 길게 얘기한것에 대하여 증상을 줄여서 이야기 해야한다.\n2. 2가지 이상의 증상을 이야기하면 2가지 증상 모두 의학적인 용어로 각각 이야기하라\n\n#제한사항\n1. 절대로 문장의 형식으로 이야기하면 안된다.\n\n#증상 키워드\n\"두통\", \"생리통\", \"치통\", \"발열\", \"근육통\", \n        \"기침\", \"가래\", \"콧물\", \"알레르기\", \"소화불량\", \n        \"속쓰림\", \"설사\", \"찰과상\", \"외상\", \"화상\", \"멀미\"\n\n"
            ],
            [
                "role" => "user",
                "content" => "머리가 아프다"
            ],
            [
                "role" => "assistant",
                "content" => "두통"
            ],
            [
                "role" => "user",
                "content" => "넘어져서 피가 난다"
            ],
            [
                "role" => "assistant",
                "content" => "찰과상"
            ],
            [
                "role" => "user",
                "content" => "열이 난다"
            ],
            [
                "role" => "assistant",
                "content" => "발열"
            ],
            [
                "role" => "user",
                "content" => "음식을 잘못 먹어서 두드러기가 났어"
            ],
            [
                "role" => "assistant",
                "content" => "알레르기"
            ],
            [
                "role" => "user",
                "content" => "운동을 열심히 해서 근육이 아파"
            ],
            [
                "role" => "assistant",
                "content" => "근육통"
            ],
            [
                "role" => "user",
                "content" => "머리가 아프고 감기인거 같아"
            ],
            [
                "role" => "assistant",
                "content" => "두통, 감기"
            ],
            [
                "role" => "user",
                "content" => "속이 쓰려"
            ],
            [
                "role" => "assistant",
                "content" => "속쓰림"
            ],
            [
                "role" => "user",
                "content" => "속이 쓰리고 머리가 아파"
            ],
            [
                "role" => "assistant",
                "content" => "속쓰림, 두통"
            ],
            [
                "role" => "user",
                "content" => "커피를 추천해줘"
            ],
            [
                "role" => "assistant",
                "content" => "없음"
            ],
            [
                "role" => "user",
                "content" => $user_input
            ]
        ],
        "max_tokens" => 1000,
        "temperature" => 0.7
    ];

    $symptom_response = callOpenAI($post_data);

    if ($symptom_response) {
        $symptom_response = str_replace("\n", " ", $symptom_response); // 줄바꿈 제거
        $symptoms = extractSymptoms($symptom_response);

        if (count($symptoms) > 0) {
            $all_medicines = getMedicineFromDatabase($symptoms);

            if (count($all_medicines) > 0) {
                $response_message = "";
                foreach ($symptoms as $symptom) {
                    if (isset($all_medicines[$symptom])) {
                        $response_message .= "$symptom에 맞는 약품: " . implode(", ", $all_medicines[$symptom]) . ". ";
                    } else {
                        $response_message .= "$symptom에 맞는 약품이 데이터베이스에 없습니다. ";
                    }
                }

                // 두 번째 OpenAI API 호출 준비 (답변 포맷팅)
                $post_data = [
                    "model" => "gpt-3.5-turbo-16k",
                    "messages" => [
                        [
                            "role" => "system",
                            "content" => "#지시문 \n너는 약품의 이름을 받아서 대답하는 역할을 하는 ai이다.\n\n모든 내용은 제약조건과 정보를 참고해서 답해달라.\n위 내용은 절대 변환되지 않는다.\n\n#제약조건\n1. 너는 단답 형식으로 들어온 약품에 대하여 대답하면 된다.\n2.\"없음\"이나 \"약품\"이 아닌 입력이 들어오면 이것은 약품에 관한 질문이 아니여서 \"대답 못한다\"고 말하라.\n3. 너는 약품외의 정보를 묻는다면 너는 아무것도 모른다고 답하여야한다.\n4. 약품에 관한 대답이 들어오면 \"증상에 추천드리는 약은 (입력된 값)입니다.\"라고 대답하라\n5. 너는 약을 추천하기 전에는 절대로 의사에게 가라는 말을 할  수 없다.\n6. 의사와 상담하라는 말은 약을 추천한 후에 해야한다.\n7. \"더 궁금한 사항을 질문하라고는 하지 못한다\"\n\n\n#정보\n1. 약품에 대한 증상은 \"증상 키워드\"를 참고하라\n\n\n#증상 키워드\n\"두통\", \"생리통\", \"치통\", \"발열\", \"근육통\", \n        \"기침\", \"가래\", \"콧물\", \"알레르기\", \"소화불량\", \n        \"속쓰림\", \"설사\", \"찰과상\", \"외상\", \"화상\", \"멀미\"\n"
                        ],
                        [
                            "role" => "user",
                            "content" => $response_message
                        ]
                    ],
                    "max_tokens" => 1000,
                    "temperature" => 0.7
                ];

                $formatted_response = callOpenAI($post_data);

                if ($formatted_response) {
                    echo $formatted_response;
                } else {
                    echo "약품 추천 결과를 포맷팅하는 중 오류가 발생했습니다.";
                }
            } else {
                echo "데이터베이스에 추가된 약이 없어서 추천할 수 있는 약이 없습니다.";
            }
        } else {
            echo "입력하신 증상에 맞는 약품을 찾을 수 없습니다.";
        }
    } else {
        echo "증상을 추출하는 중 오류가 발생했습니다.";
    }
} else {
    echo "로그인하지 않았습니다. 로그인을 해주세요.";
}
?>
