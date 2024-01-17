<?php
session_start();

if (!isset($_SESSION['send_code'])) {
    header("location: ../index.php");
    exit();
} else {
    $valid_code = rand(100000, 999999);
    $_SESSION['valid_code'] = $valid_code;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "mobile": "' . $_SESSION['user_mobile'] . '",
        "templateId": #,
        "parameters": [
            {
                "name": "Code",
                "value": "' . $valid_code . '"
            }
        ]
    }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: text/plain',
            'x-api-key: #'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    unset($_SESSION['send_code']);

    $_SESSION['check_code'] = true;

    header("location: check_code.php");
    exit();
}