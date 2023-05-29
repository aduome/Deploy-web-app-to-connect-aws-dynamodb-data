# Deploy-web-app-to-connect-aws-dynamodb-data
# AWS CLOUD PROJECT 
### TEAM GITHUB (Azubi Africa Cloud Projects)

<a name="readme-top"></a>
## Collaborations
#### This is a hand-on cloud engineering project delivered by the azubi africa cloud team in 2023. After 6 months of AWS cloud training and front-end development, we got a chance to work on some realife cloud projects. It focuses on working with dynamo dB, docker, composer, AWS ECS, Fargate and other AWS Services. I was able to work with:

1. Fahad Mohammed [@_linkedin](https://www.linkedin.com/in/fahad-mohammed2)
2. Dotse Dossou [@ linkedin](https://www.linkedin.com/in/dotse-dossou)
3. Joseph Baako [@ linkedin](https://www.linkedin.com/in/joseph-baako)
4.  Darko Larbi [@_linkedin](https://www.linkedin.com/in/kdarkolarbi)


## About The Project
## The project have four major tasks which are:
The App should now have the ability to add new records, send notifications on app activity and also view data from the DynamoDB. Explore the Deliverables Menu option to derive insights on the details required.
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
## Configuration
1. Clone the repository or download the code files to your local system.

2. Open the index.php file and configure the following variables:

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
