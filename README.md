# Deploy-web-app-to-connect-aws-dynamodb-data
# AWS CLOUD PROJECT 
### TEAM GITHUB (Azubi Africa Cloud Projects)

<a name="readme-top"></a>
## Collaborations
#### This is a hand-on cloud engineering project delivered by the azubi africa cloud team in 2023. After 6 months of AWS cloud training and front-end development, we got a chance to work on some realife cloud projects. It focuses on working with dynamo dB, Docker, Composer, AWS ECS, Fargate and other AWS Services as well as a third-party email service (Brevo-formally SendinBlue). I was able to work with:

1. Fahad Mohammed [@_linkedin](https://www.linkedin.com/in/fahad-mohammed2)
2. Dotse Dossou [@ linkedin](https://www.linkedin.com/in/dotse-dossou)
3. Joseph Baako [@ linkedin](https://www.linkedin.com/in/joseph-baako)

## About The Project
The web App should have the ability to add new records, send notifications on app activity and also view data from the DynamoDB. 

## User Registration Form
This is a simple user registration form implemented in PHP. It allows users to enter their personal information and submit the form. The submitted data is stored in an AWS DynamoDB table, and an email notification is sent to the user using the SendinBlue service. The application is designed to run on AWS Fargate, and it publishes custom metrics to CloudWatch.

## Prerequisites
Before running this code, ensure that you have the following prerequisites:

- PHP installed on your system
- Composer installed to manage PHP dependencies
- An AWS account with DynamoDB, CloudWatch, and ECR services configured
- A SendinBlue account with an API key
- Docker installed on your system
- AWS CLI installed and configured with the appropriate credentials and permissions
## Architectural Diagram
The architectural diagram below shows the various AWS services and other third-party services needed to run the project successfully.

![Architectural Diagram of the Project](https://github.com/aduome/Deploy-web-app-to-connect-aws-dynamodb-data/blob/main/Photos/Azubi%20Team%20Github%20Project%204_Updated%20with%20SendinBlue_Brevo.png)

## Configuration
1. Clone the repository or download the code files to your local system. [Github Repo](https://github.com/aduome/Deploy-web-app-to-connect-aws-dynamodb-data)

2. Open the [index.php](https://github.com/aduome/Deploy-web-app-to-connect-aws-dynamodb-data/blob/main/index.php)
 file and configure the following variables:

- `$credentials`: Set your AWS access key and secret key.
- `$region`: Set the AWS region where your DynamoDB, CloudWatch, and ECR services are located.
- `$tableName`: Specify the name of the DynamoDB table where user registration data will be stored.
- `$config`: Set your SendinBlue API key.
- `$senderEmail`: Replace with your sender email address.
- `$sendSmtpEmail`: Configure the email subject and content based on your requirements.
3. Install the required PHP dependencies using Composer. Run the following command in the project directory:
```
composer install
```
4. Build the Docker image and push it to AWS ECR:

- Create an ECR repository to store the Docker image.

- Run the following commands in the project directory:
```
# Build the Docker image
docker build -t user-registration-form .

# Tag the image with the ECR repository URI
docker tag user-registration-form:latest <ECR_REPOSITORY_URI>:latest

# Push the image to ECR
aws ecr get-login-password --region <AWS_REGION> | docker login --username AWS --password-stdin <ECR_REPOSITORY_URI>
docker push <ECR_REPOSITORY_URI>:latest
```
Replace `<ECR_REPOSITORY_URI>` with the URI of your ECR repository and `<AWS_REGION>` with the AWS region where your ECR repository is located.

5. Configure the AWS Fargate Task Definition:

- Create a task definition that specifies the container image from your ECR repository and resource requirements.
- Set up the appropriate permissions for the task to access DynamoDB, CloudWatch, and SendinBlue services.
- Define the environment variables for the PHP application, including the AWS access key, secret key, region, and SendinBlue API key.
6. Deploy the application on AWS Fargate:

- Create a cluster and configure the desired number of tasks and their placement.
- Launch the tasks using the configured task definition.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Usage
1. Access the user registration form by using the public URL or the IP address of the Fargate tasks.
2. Fill in the form fields with the required information and click the "Submit" button.
3. The form data will be stored in the DynamoDB table, and an email notification will be sent to the user.
4. Custom metrics will be published to CloudWatch, allowing you to monitor the user registration activity.
### Using LocalHost
1. Start a PHP server to run the application locally. In the project directory, run the following command:
```
php -S localhost:8000
```
- Open a web browser and navigate to `http://localhost:8000` to access the user registration form.

- Fill in the form fields with the required information and click the "Submit" button.

- The form data will be stored in the DynamoDB table, and an email notification will be sent to the user.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Monitoring with CloudWatch
- Configure CloudWatch Alarms to receive notifications when specific conditions are met, such as high registration rates or failures.
- Use CloudWatch Dashboards to create customized visualizations and monitor the user registration metrics over time.
- Set up CloudWatch Event Rules to trigger actions based on specific events, such as sending notifications or invoking AWS Lambda functions.
### Publish a custom metric to CloudWatch
```
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

```
This section publishes a custom metric to the CloudWatch service. It uses the `putMetricData` method of the CloudWatch client to send metric data. The metric data configuration should be provided inside the `MetricData` parameter.

## License
- This project is licensed under the GNU General Public License v3.0.
- Feel free to customize and modify the code to fit your specific needs.

## Acknowledgments
This code is based on the AWS SDK for PHP and the SendinBlue PHP SDK.

<!-- CONTACT -->

## Contact

Daniel Agyei - [@my_linkedin](https://www.linkedin.com/in/daniel-owusu-banahene-agyei-3a4172136)

Email: [My Email](daniel.agyeibanahene@gmail.com)

Project Link: [Project Link](https://github.com/aduome/Deploy-web-app-to-connect-aws-dynamodb-data)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- References -->
## References

### Useful Resources And Links

* [Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
* [Composer Cheat sheet](https://devhints.io/composer)
* [Docker Cheat sheet](https://docs.docker.com/get-started/docker_cheatsheet.pdf)
* [GitHub Pages](https://pages.github.com)
* [Gitpod](https://www.gitpod.io/)
* [Chat GPT](https://chat.openai.com/auth/login)
<p align="right">(<a href="#readme-top">back to top</a>)</p>
