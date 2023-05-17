<!DOCTYPE html>
<html>
<head>
  <title>User Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
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
  <h2>Gold Grid Registration Form</h2>
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

// Set up AWS credentials and region
$credentials = new Aws\Credentials\Credentials('Aaccesskey', 'secretekey');
$region = 'us-east-1';

// Create a DynamoDB client
$dynamodb = new DynamoDbClient([
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
        'fullname' => ['S' => $fullname],
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
}
?>
