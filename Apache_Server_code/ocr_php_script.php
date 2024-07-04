<?php

// Python 스크립트 실행
$output = shell_exec('python ocr_script.py');

// JSON 형식의 결과 파싱
$result = json_decode($output, true);

// 결과가 유효한지 확인
if ($result && isset($result['images']) && is_array($result['images']) && count($result['images']) > 0) {
    // 첫 번째 이미지에서 텍스트 추출
    $text = '';
    foreach ($result['images'][0]['fields'] as $field) {
        $text .= $field['inferText'] . "\n";
    }

    // 결과 출력
    echo $text;
} else {
    echo "OCR 결과를 가져올 수 없습니다.";
}

?>
