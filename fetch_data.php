<?php
// Check if the username and password are provided in the request
$validUsername = 'admin';
$validPassword = 'password';

if (
    isset($_SERVER['PHP_AUTH_USER']) &&
    isset($_SERVER['PHP_AUTH_PW']) &&
    $_SERVER['PHP_AUTH_USER'] === $validUsername &&
    $_SERVER['PHP_AUTH_PW'] === $validPassword
) {
    // Authentication successful, proceed to display the data
} else {
    // If the authentication fails, send the authentication challenge
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentication required.';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registrations</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <?php
  // Include the AWS SDK for PHP
  require 'vendor/autoload.php';

  use Aws\DynamoDb\DynamoDbClient;

  // Set up AWS credentials and region
  $credentials = new Aws\Credentials\Credentials('accesskey', 'secretkey');
  $region = 'us-east-1';

  // Create a DynamoDB client
  $dynamodb = new DynamoDbClient([
      'version' => 'latest',
      'credentials' => $credentials,
      'region' => $region
  ]);

  // Define the DynamoDB table name
  $registrationTableName = 'UserRegistration';

  // Check if the request came from the registration form
  $fromRegistrationForm = isset($_GET['fromRegistrationForm']);

  // Scan the DynamoDB table to retrieve all items
  $result = $dynamodb->scan([
      'TableName' => $registrationTableName
  ]);

  // Check if any items are found
  if ($result['Count'] > 0) {
      $items = $result['Items'];

      // Display the table only if the request didn't come from the registration form
      if (!$fromRegistrationForm) {
          echo '<table>';
          echo '<tr><th>Full Name</th><th>Age</th><th>Occupation</th><th>Nationality</th><th>Marital Status</th><th>Email</th></tr>';

          // Iterate over each item and display the data in the table
          foreach ($items as $item) {
              echo '<tr>';
              echo '<td>' . $item['Fullname']['S'] . '</td>';
              echo '<td>' . $item['age']['N'] . '</td>';
              echo '<td>' . $item['occupation']['S'] . '</td>';
              echo '<td>' . $item['nationality']['S'] . '</td>';
              echo '<td>' . $item['maritalstatus']['S'] . '</td>';
              echo '<td>' . $item['email']['S'] . '</td>';
              echo '</tr>';
          }

          echo '</table>';
      } else {
          echo 'Registration successful! Click <a href="fetch_data.php">here</a> to view all registrations.';
      }
  } else {
      echo '<p>No registrations found.</p>';
  }
  ?>

  <p>Click <a href="index.php">here</a> to go back to the registration form.</p>
</body>
</html>
