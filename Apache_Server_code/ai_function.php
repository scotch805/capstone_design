<?php

$ch = curl_init();

$url = 'https://api.openai.com/v1/chat/completions';

$api_key = 'api키를 여기에 입력하세요';

$split = explode("/////", $_POST['text']);

$prompt = $split[0];
$oldPrompt = $split[1];
$oldResult = $split[2];

$postFields = array(
    "model" => "gpt-3.5-turbo-0613",
    "messages" => array(
        array(
            "role" => "system",
            "content" => "안녕하세요. 당신의 이름은 '테스트봇'이며, 당신은 유메타랩이 개발했습니다. 당신의 이름은 '테스트봇'임을 명심하세요."
        ),
        array(
            "role" => "user",
            "content" => "$oldPrompt"
        ),
        array(
            "role" => "assistant",
            "content" => "$oldResult"
        ),
        array(
            "role" => "user",
            "content" => "$prompt"
        )
    ),
    'functions' => array(
        array(
            'name' => 'get_current_weather',
            'description' => '주어진 지역의 날씨를 알려줍니다.',
            'parameters' => array(
                // 파라메터의 요소는 사용자가 지정할 수 있으며 이를 바탕으로 사용자가 어떠한 질문을 했을 때
                // 어떠한 질문인지 확인한 후 함수를 실행할지에 대한 여부를 판단합니다.
                'type' => 'object',
                'properties' => array(
                    'location' => array(
                        'type' => 'string',
                        'description' => '대구, 서울, 광주, 부산 등과 같은 한국의 도시'
                    )
                ),
                'required' => ['location']
            )
        ),
        array(
            'name' => 'get_unse',
            'description' => '사용자의 생년월일을 인식해서 오늘의 운세를 알려줍니다.',
            'parameters' => array(
                // 파라메터의 요소는 사용자가 지정할 수 있으며 이를 바탕으로 사용자가 어떠한 질문을 했을 때
                // 어떠한 질문인지 확인한 후 함수를 실행할지에 대한 여부를 판단합니다.
                'type' => 'object',
                'properties' => array(
                    'year' => array(
                        'type' => 'string',
                        'description' => '사용자가 태어난 년도'
                    ),
                    'month' => array(
                        'type' => 'string',
                        'description' => '사용자가 태어난 월'
                    ),
                    'day' => array(
                        'type' => 'string',
                        'description' => '사용자가 태어난 일'
                    )
                ),
                'required' => ['location']
            )
        )
    ),
    "max_tokens" => 1000,
    "temperature" => 0.7
);

$header = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}
curl_close($ch);

$response = json_decode($result);
$decodedResponse = json_decode($result, true);

$botReply = var_export($response->choices[0]->message->content, true);

$functionCall = $decodedResponse['choices'][0]['message']['function_call'];
$strippedBotReply = rtrim(ltrim($botReply, "'"), "'");

if (strpos($strippedBotReply, "NULL") !== false) {
    if ($functionCall['name'] == 'get_current_weather') {
        $arguments = json_decode($functionCall['arguments'], true);
        echo $arguments['location'] . "에 대한 정보를 찾고자 하는군요!";
    } else if ($functionCall['name'] == 'get_unse') {
        $arguments = json_decode($functionCall['arguments'], true);
        echo $arguments['year'] . "년 " . $arguments['month'] . "월 " . $arguments['day'] . "일생이시군요! 운세가 보고 싶으시군요.";
    } else {
        echo "<font color=red>서버에 뭔가 오류가 있습니다. 새로고침 해주세요. $result </font>";
    }
} else {
    echo stripslashes($strippedBotReply);
}
?>
