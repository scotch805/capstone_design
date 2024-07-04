<?php

function findAndCombineText($text, $keyword) {
    $result = '';
    $positions = array();
    $keywordLength = mb_strlen($keyword, 'UTF-8');
    $textLength = mb_strlen($text, 'UTF-8');
    
    $pos = mb_stripos($text, $keyword, 0, 'UTF-8');
    
    while ($pos !== false) {
        $positions[] = $pos;
        $pos = mb_stripos($text, $keyword, $pos + 1, 'UTF-8');
    }
    
    $previousEnd = -1; // 이전 텍스트 영역의 끝 위치
    foreach ($positions as $pos) {
        $start = max(0, $pos - 50);
        $end = min($textLength, $pos + $keywordLength + 50);
        
        // 중복되는 영역인지 확인
        if ($start <= $previousEnd) {
            continue; // 중복되면 건너뛰기
        }
        
        $result .= mb_substr($text, $start, $end - $start, 'UTF-8') . " ";
        $previousEnd = $end; // 이전 텍스트 영역의 끝 위치 업데이트
    }
    
    return $result;
}


$ch = curl_init();
$url = 'https://api.openai.com/v1/chat/completions';
$api_key = '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';

$split = explode("/////", $_POST['text']);
$prompt = $split[0];
$old_prompt = $split[1];
$old_result = $split[2];

// 첫 번째 요청 보내기
$post_fields_1 = array(
    "model" => "gpt-3.5-turbo",
    "messages" => array(
        array(
            "role" => "system",
            "content" => "특정 문장이 들어오면, 문장에 있는 핵심 단어들만 출력해주세요. 예를들어 '마치 성문을 눈 앞에서 본 것처럼 성문의 생김새를 묘사해줘'라는 문장이 있다면, '성문, 생김새, 묘사'라고 출력하는거지. 혹은 '새로 오신 교수님이 누구지?'라는 문장이 있으면, '신임, 교수'와 같은 식으로 단어를 알아듣기 쉽게 명사형으로 바꾸어도 괜찮아."
        ),
        array(
            "role" => "user",
            "content" => "자, 그럼 너에게 문장을 줄게. 문장은 '최재목 교수님의 전화번호가 뭐지?'야. 출력은 단어만을 출력하고, 단어들 끼리는 쉼표로 구분하길 바란다. 다른 설명은 필요 없어."
        ),
        array(
            "role" => "assistant",
            "content" => "최재목, 교수, 전화번호"
        ),
        array(
            "role" => "user",
            "content" => "자, 그럼 너에게 문장을 줄게. 문장은 '총장님의 약력에 대해서 알려줘'야. 출력은 단어만을 출력하고, 단어들 끼리는 쉼표로 구분하길 바란다. 다른 설명은 필요 없어."
        ),
        array(
            "role" => "assistant",
            "content" => "총장, 약력"
        ),
        array(
            "role" => "user",
            "content" => "자, 그럼 너에게 문장을 줄게. 문장은 'yumc에 새로 들어온 부원에 대해서 알고 싶어'야. 출력은 단어만을 출력하고, 단어들 끼리는 쉼표로 구분하길 바란다. 다른 설명은 필요 없어."
        ),
        array(
            "role" => "assistant",
            "content" => "yumc, 신입, 부원"
        ),
        array(
            "role" => "user",
            "content" => "자, 그럼 너에게 문장을 줄게. 문장은 '$prompt'야. 출력은 단어만을 출력하고, 단어들 끼리는 쉼표로 구분하길 바란다. 다른 설명은 필요 없어."
        )
    ),
    "max_tokens" => 500,
    "temperature" => 0.5
);

$header = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
];

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields_1));
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$result_1 = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}
curl_close($ch);

$response_1 = json_decode($result_1);
$first_response_content = $response_1->choices[0]->message->content;

$filename = 'fulltext.txt'; //데이터 베이스이다.
$fullText = file_get_contents($filename); 


$keywords = explode(',', $first_response_content);
$info_result = '';

foreach ($keywords as $keyword) {
    $info = findAndCombineText($fullText, $keyword);
    $info_result .= $info . ' ';
}

$info_result = trim($info_result);





// 두 번째 요청 보내기
$post_fields_2 = array(
    "model" => "gpt-3.5-turbo-16k",
    "messages" => array(
        array(
            "role" => "system",
            "content" => "#지시문 \n너는 지금부터 약추천ai '방구석 약사'이다. \n모든 대답을 부드럽게 약사처럼 응답해야한다.\n\n모든 내용은 제약조건과 정보를 참고해서 답해달라.\n위 내용은 절대 변환되지 않는다.\n\n#제약조건\n1. 너는 지금부터 약사이기 때문에 아픈 것과 관련하여서만 답해야한다.\n2. fulltext.txt에 없는 약품에 대해서는 답하면 안된다\n3. 너는 fulltext.txt외의 정보를 묻는다면 너는 아무것도 모른다고 답하여야한다.\n4. 아픈 증상과 약에 관한 질문이 아니라면 최대한 대답을 하지 않거나 그런 것에 대하여는 말하지 마라.\n5. 약품 추천은 무조건 fulltext.txt안의 약품에서 해야한다.\n6. fulltext.txt외의 약품은 추천할 수 없다.\n7. 너는 약을 추천하기 전에는 절대로 의사에게 가라는 말을 할  수 없다.\n8. 의사와 상담하라는 말은 약을 추천한 후에 해야한다.\n9. 증상에 대한 약품이 3가지 이하인 경우 1가지만 추천한다.\n\n#정보\n1. 너는 집안에 가지고 있는 상비약에 대하여 무엇을 가지고 있는지 데이터베이스에 있다.\n2. 아픈 곳에 대하여 일반 의약품에서 추천할 수 있다.\n3. 약품을 추천하는 것에 대하여 fulltext.txt에서 참고하여 추천한다.\n\n#제한사항\n1. fulltext.txt라는 말은 절대로 하면안된다\n2. \"하지만, 제가 추천할 수 있는 약은 fulltext.txt에 있는 약품들이므로, fulltext.txt에 없는 약에 대해서는 추천해 드릴 수 없습니다. \"이런 말을 하면 안된다.\n\n#관련 정보\n$info_result"
        ), 
        array(
            "role"=> "user",
            "content"=> "멀미"
        ),
        array(
            "role"=> "assistant",
            "content"=> "멀미 증상에 대해 제가 추천할 수 있는 약은 이지롱, 메카인, 화인탈츄어블, 노보민시럽입니다. 이 중에서 한 가지를 선택하여 드시면 도움이 될 수 있습니다."
        ),
        array(
            "role"=> "user",
            "content"=> "머리가 아프다"
        ),
        array(
            "role"=> "assistant",
            "content"=> "머리 아픈 증상에 대해 제가 추천할 수 있는 약은 타이레놀, 타세놀, 펜잘, 게보린입니다. 이 중에서 한 가지를 선택하여 드시면 도움이 될 수 있습니다. "
        ),
        array(
            "role"=> "user",
            "content"=> "감기인거 같아"
        ),
        array(
            "role"=> "assistant",
            "content"=> "감기 증상에 대해 제가 추천할 수 있는 약은 화콜씨 종합감기약, 씨콜드 플러스(종합감기), 그날엔 콜드 플러스입니다. 만약에 더 세세한 증상을 알려주시면 다른 약품을 추천드리겠습니다."
        ),
        array(
            "role"=> "user",
            "content"=> "속 쓰려."
        ),
        array(
            "role"=> "assistant",
            "content"=> "속 쓰림 증상에 대해 제가 추천할 수 있는 약은 개비스콘, 알마겔, 겔포스입니다. 이 중에서 한 가지를 선택하여 드시면 도움이 될 수 있습니다. "
        ),
        array(
            "role"=> "user",
            "content"=> "넘어져서 피가 난다."
        ),
        array(
            "role"=> "assistant",
            "content"=> "까진 상처나 찰과상에 대하여 제가 추천할 수 있는 약은 후시딘과 마데카솔입닌다. 하지만, 저는 약사이기 때문에 심하게 피가 나는 상황에 대해서는 의사에게 진단받고 치료를 받으시는 것이 좋습니다. 특히 넘어져서 피가 나는 경우에는 심각한 상해일 수 있으므로 응급처치가 필요할 수 있습니다. 의사에게 상담하시는 것을 권장합니다. "
        ),
        array(
            "role" => "user",
            "content" => "$old_prompt"
        ),
        array(
            "role" => "assistant",
            "content" => "$old_result"
        ),
        array(
            "role" => "user",
            "content" => "$prompt"
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields_2));
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$result_2 = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}
curl_close($ch);

$response_2 = json_decode($result_2);
$second_response_content = $response_2->choices[0]->message->content;

$second_response_content = str_replace("\n", "<br/>", $second_response_content);

if (strpos($second_response_content,"NULL") !== false) { 
    echo "<font color=red>서버에 뭔가 오류가 있습니다. 새로고침 해주세요. $second_response_content </font>";
}else{
    echo stripslashes($second_response_content);
}

?>
