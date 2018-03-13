<?php
function getReqSign($params/* 关联数组 */, $appkey/* 字符串*/)
{
    // 1. 字典升序排序
    ksort($params);

    // 2. 拼按URL键值对
    $str = '';
    foreach ($params as $key => $value) {
        if ($value !== '') {
            $str .= $key . '=' . urlencode($value) . '&';
        }
    }

    // 3. 拼接app_key
    $str .= 'app_key=' . $appkey;

    // 4. MD5运算+转换大写，得到请求签名
    $sign = strtoupper(md5($str));
    return $sign;
}
function doHttpPost($url, $params)
{
    $curl = curl_init();

    $response = false;
    do {
        // 1. 设置HTTP URL (API地址)
        curl_setopt($curl, CURLOPT_URL, $url);

        // 2. 设置HTTP HEADER (表单POST)
        $head = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

        // 3. 设置HTTP BODY (URL键值对)
        $body = http_build_query($params);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        // 4. 调用API，获取响应结果
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        if ($response === false) {
            $response = false;
            break;
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            $response = false;
            break;
        }
    } while (0);

    curl_close($curl);
    return $response;
}
$path   = './whj.wav';
$data   = file_get_contents($path);
$base64 = base64_encode($data);
// 设置请求数据
$appkey = 'MiKfVhNfey2WUwqI';
$params = array(
    'app_id'       => '1106687373',
    'format'       => '2',
    'rate'         => '16000',
    'seq'          => '0',
    'len'          => strlen($data),
    'end'          => '1',
    'speech_id'    => 'qwe4444',
    'speech_chunk' => $base64,
    'time_stamp'   => strval(time()),
    'nonce_str'    => strval(rand()),
    'sign'         => '',
);
$params['sign'] = getReqSign($params, $appkey);
// print_r($params);
// 执行API调用
$url = 'https://api.ai.qq.com/fcgi-bin/aai/aai_asrs';
// $url      = 'https://api.ai.qq.com/fcgi-bin/aai/aai_wxasrs';
$response = doHttpPost($url, $params);
echo $response;
