<!DOCTYPE html>
<html>
<head>
  <title>User Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url("https://pixabay.com/get/gb041c99819b3149fd2883df47fcf933feccc67ae482cd7e701173eb83fae562e091e353e0acaccdb2aadfafb733f58e2e0742655cc6e4713fc1898f4de296aeef991cb5c45bc790183c5952faf173a07_1280.jpg");
      background-color: #f5f5f5;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h2>Azubi_Team_Github Registration Form</h2>
  <form action="/submit" method="post">
    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" required>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>

    <label for="occupation">Occupation:</label>
    <input type="text" id="occupation" name="occupation" required>

    <label for="nationality">Nationality:</label>
    <input type="text" id="nationality" name="nationality" required>

    <label for="maritalstatus">Marital Status:</label>
    <select id="maritalstatus" name="maritalstatus" required>
      <option value="single">Single</option>
      <option value="married">Married</option>
      <option value="divorced">Divorced</option>
    </select>

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>

    <input type="submit" value="Submit">
  </form>
</body>
</html>

<?php
// Include the AWS SDK for PHP
require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\Ses\SesClient;
use Aws\CloudWatch\CloudWatchClient;

// Set up AWS credentials and region
$credentials = new Aws\Credentials\Credentials('accesskey', 'secretkey');
$region = 'us-east-1';

// Create a DynamoDB client
$dynamodb = new DynamoDbClient([
    'version' => 'latest',
    'credentials' => $credentials,
    'region' => $region
]);

// Create an AWS SES client
$sesClient = new SesClient([
    'version' => 'latest',
    'credentials' => $credentials,
    'region' => $region
]);

// Create an AWS CloudWatch client
$cloudWatchClient = new CloudWatchClient([
    'version' => 'latest',
    'credentials' => $credentials,
    'region' => $region
]);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $nationality = $_POST['nationality'];
    $maritalstatus = $_POST['maritalstatus'];
    $email = $_POST['email'];

    // Define the DynamoDB table name
    $tableName = 'UserRegistration';

    // Create an item to be inserted into the table
    $item = [
        'Fullname' => ['S' => $fullname],
        'age' => ['N' => $age],
        'occupation' => ['S' => $occupation],
        'nationality' => ['S' => $nationality],
        'maritalstatus' => ['S' => $maritalstatus],
        'email' => ['S' => $email]
    ];

    // Put the item into the DynamoDB table
    $result = $dynamodb->putItem([
        'TableName' => $tableName,
        'Item' => $item
    ]);

   // Check the result
    if ($result['@metadata']['statusCode'] === 200) {
      echo 'User registration successful!';
  } else {
      echo 'User registration failed.';
  }
        // Publish a custom metric to CloudWatch
        $cloudWatchClient->putMetricData([
            'Namespace' => 'UserRegistration',
            'MetricData' => [
                [
                    'MetricName' => 'RegistrationCount',
                    'Dimensions' => [
                        [
                            'Name' => 'RegistrationType',
                            'Value' => 'User'
                        ]
                    ],
                    'Unit' => 'Count',
                    'Value' => 1
                ]
            ]
        ]);
    

    // Send an email notification
    $message = "A new user has registered:\n\nFull Name: " . $fullname . "\nEmail: " . $email . "\nNationality: " . $nationality;

    $sesClient->sendEmail([
        'Source' => 'sourceemailaddress.com',
        'Destination' => [
            'ToAddresses' => ['destinationemail.com']
        ],
        'Message' => [
            'Subject' => [
                'Data' => 'New User Registration',
            ],
            'Body' => [
                'Text' => [
                    'Data' => $message,
                ],
            ],
        ],
    ]);
}
?>
