<?php
// URL API LINE
$API_URL = 'https://api.line.me/v2/bot/message';
// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'AfloHD5h5mp5vwODJOY/3DtoJbnaXWenNiBHp5d19LXHJP0Bfvyrhtsvrx9clx8qkJg5w4yBQxUEubarfPA0TbP+sZo91eceSs4PBVM7fM3uI2oXkxG2hn8iagLUsFnBmbQGUw8e4eoW9PyMu6UtCwdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
$CHANNEL_SECRET = '4e59cafdca31e4044ce7ac16becd770a';

// Set HEADER
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
// Get request content
$request = file_get_contents('php://input');
// Decode JSON to Array
$request_array = json_decode($request, true);

function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
    
    $reply_message = '';
    $reply_token = $event['replyToken'];
    $data = [
       'replyToken' => $reply_token,
       'messages' => [
          ['type' => 'text', 
           'text' => json_encode($request_array)]
       ]
    ];
    $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
    $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
    echo "Result: ".$send_result."\r\n";
 }
}
echo "OK";

?>