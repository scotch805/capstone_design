import requests
import uuid
import time
import json

def perform_ocr(image_file, api_url, secret_key):
    request_json = {
        'images': [
            {
                'format': 'jpg',
                'name': 'demo'
            }
        ],
        'requestId': str(uuid.uuid4()),
        'version': 'V2',
        'timestamp': int(round(time.time() * 1000))
    }

    payload = {'message': json.dumps(request_json).encode('UTF-8')}
    files = [('file', open(image_file, 'rb'))]
    headers = {'X-OCR-SECRET': secret_key}

    response = requests.post(api_url, headers=headers, data=payload, files=files)

    result = response.json()
    return result

# 이미지 파일과 API URL, Secret Key 설정
image_file = 'YOUR_IMAGE_FILE'
api_url = 'https://qcha60q58k.apigw.ntruss.com/custom/v1/30497/323d24038d01cef8f13dd81fd116dc0310efbb4bd6a52a21371def27a416aa40/general'
secret_key = 'VERHS29na05zbmRqQmJ0Um1FSHFzVUNBZnJKdU9CVHo='

# OCR 수행 및 결과 출력
ocr_result = perform_ocr(image_file, api_url, secret_key)
print(json.dumps(ocr_result))  # 결과를 JSON 형식으로 출력
