<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$response = $client->request('POST', 'https://control.msg91.com/api/v5/otp?mobile=&template_id=', [
  'body' => '{"Param1":"value1","Param2":"value2","Param3":"value3"}',
  'headers' => [
    'accept' => 'application/json',
    'authkey' => 'Enter your MSG91 authkey',
    'content-type' => 'application/json',
  ],
]);

echo $response->getBody();





// import requests

// # Replace these with your actual MSG91 API credentials
// auth_key = "YOUR_MSG91_AUTH_KEY"
// template_id = "YOUR_TEMPLATE_ID"
// recipient = "RECIPIENT_PHONE_NUMBER"

// # The OTP you want to send
// otp = "1234"

// # The endpoint for MSG91 Send OTP API
// url = "https://api.msg91.com/api/v5/otp"

// # Create the payload with required parameters
// payload = {
//     "authkey": auth_key,
//     "template_id": template_id,
//     "mobile": recipient,
//     "otp": otp
// }

// try:
//     # Make the API call to send the OTP
//     response = requests.post(url, data=payload)

//     # Check the response status and handle accordingly
//     if response.status_code == 200:
//         print("OTP sent successfully.")
//     else:
//         print("Failed to send OTP. Status code:", response.status_code)

//     # If needed, you can also parse the JSON response for more information
//     # response_data = response.json()
//     # print("Response data:", response_data)

// except requests.exceptions.RequestException as e:
//     print("Error occurred while making the API call:", e)


?>