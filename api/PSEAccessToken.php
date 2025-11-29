<?php
class PSEAccessToken {
  public function getToken() {
    $endpoint = 'https://apiprd.pse.com.co/oauth/client_credential/accesstoken?grant_type=client_credentials';
    $data = [
      'grant_type' => 'client_credentials',
      'client_id' => 'AwwmP5xNvSjxTXygW2in58dKPHpfRZjM',
      'client_secret' => '1Bhw7eHBDY4zA7bM',
    ];
    $headers = [
      "Content-Type: application/x-www-form-urlencoded"
    ];

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      throw new Exception("Error en cURL: " . curl_error($ch));
    }

    curl_close($ch);
    return json_decode($response, true);
  }
}
