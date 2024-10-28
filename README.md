1. Admin Documentation
1. Introduction
This system is designed for cohort management by providing a platform for tracking applications, managing surveys, and displaying rounds’ data.
2. Getting Started
Cohorts: Admins can access the list of cohorts, make necessary edits, and view all associated entities, such as surveys and rounds. like in the following examples 
Admins: also can add new admin or edit/ delete his/her account
“Disabled temporarily”

Rounds: Access applicants’ applications for round1,2 to view, edit or delete, and add/view comments about each applicant in each round


Surveys:  Access applicants’ application for surveys to view, edit or delete it, an email "reminder" will be sent to any applicant did not send his/her follow up survey on time


When a new applicant apply you will get notified via email, also an email will be sent to the newly added admin to login

External Email Service:
In production (non-local environments), Gmail will be used for sending notifications.
3. User Roles and Permissions
- **Admin**: 
        - Full access to the system, including the ability to manage cohorts, applicants, rounds, and surveys.
        - Can add, edit, or delete other admins.
        - Receives email notifications for new applicants.
    - **Applicants**: 
        - Can fill out application forms for Round 1, Round 2, and surveys.
        - Receive email reminders for incomplete surveys.

2. Developer Documentation
Project Overview
    - **Purpose**: This system facilitates the management of cohorts, including tracking applications, managing surveys, and monitoring rounds data. It ensures a seamless process for both admins and applicants.
    - **Technologies Used**: 
 - Backend: Laravel (PHP)
- Frontend: React
- Database: MySQL
- Containerization: Docker
  Repos:
https://github.com/MaryamMohamedAuf/cohort-management-system-frontend-react
https://github.com/MaryamMohamedAuf/cohort-management-system-backend-laravel

System analysis
Functional requirements:
Cohorts: Admins can view, edit, and manage all cohorts. All related entities, including surveys and rounds, can be accessed from this section.
Admins: also can add new admin or edit/ delete his/her account
Rounds: Provides access to applicants' data for Round 1 and Round 2. Admins can view, edit, delete, and add comments for each applicant, facilitating comprehensive evaluation.
Surveys: admin can access applicants’ application for surveys to view, edit or delete it, an email "reminder" will be sent to any applicant did not send his/her follow up survey on time
Non-Functional Requirements:
1. Performance
 Frontend components are built with React to provide a dynamic and responsive user interface
Each component is a separate page so only the code needed for the current page is loaded, therefore the overall performance of the application improves
“Lazy Loading”
while backend APIs are designed to return data efficiently, minimizing latency by: 
log Analysis: Review logs for slow queries or errors that may impact performance.
Review Query Performance: Analyze and optimize database queries to ensure they are efficient. Use database indexing, optimize query structures, and avoid unnecessary joins or complex subqueries.
Selective Data Fetching: only the necessary data is fetched and returned. Avoid sending large datasets if only a subset is needed.
The scheduling mechanism in this system strictly follows the Single Responsibility Principle (SRP). The Console Kernel is solely responsible for defining when tasks should run, while task execution is handled by individual Command classes.
    - Why SRP Matters: This approach ensures that changes to the scheduling logic or task execution do not affect each other, leading to easier maintenance and improved code stability.
 Scheduling Logic (Console Kernel): The scheduling of tasks is defined in the App\Console\Kernel class. This class is only responsible for defining when tasks should run and which commands should be triggered.
Task Execution Logic (Command): The actual logic for sending survey reminders is encapsulated within the SendSurveyReminders command. This command is responsible for the task execution, not when it should be executed.
Command, Mailer, Controller, and Kernel Classes: Each of these components has a clear, single responsibility. The Kernel schedules tasks, the Command triggers the task, the Controller processes the business logic, and the Mailer handles the email construction. This clear separation ensures that each class has only one reason to change, adhering to SRP
2. Security
All API endpoints require authentication using Bearer tokens.
The system uses Laravel Sanctum for API token authentication.
Role-based access control is implemented to ensure users can only access appropriate  All passwords is encrypted
All user inputs are validated
3. Maintainability
Documentation: technical documentation is provided for developers, including code comments, API documentation, to ensure that developers can easily understand and extend the system.
Version Control: The use of version control systems (e.g., Git) ensures that changes are tracked and managed effectively, allowing for easy rollback and collaboration.
4. Data Integrity
Backup and Recovery: Regular backups are performed to protect against data loss, and recovery procedures are tested to ensure that data can be restored accurately in case of corruption or loss.
 5. Rate Limiter
The rate limiter is implemented to manage and control the rate of incoming requests to the application. It helps prevent abuse by limiting the number of requests a user or IP address can make within a specified time period.
The rate limiter ensures that the application can handle traffic efficiently and protect against excessive or malicious requests. It is crucial for maintaining the stability and security of the system by preventing overloads and potential abuse.
- Laravel provides built-in support for rate limiting through the `ThrottleRequests` middleware. 60 requests per minute per IP address


API Documentation
Base URL
https://localhost:8000/api
Authentication
All routes within the auth:sanctum middleware group require authentication via a Bearer token.

Documented by scribe
Visit: https://localhost:8000/docs
Implementation
Prerequisites:
- PHP 8.0+
- Composer
- Node.js 14+
- npm
- Docker
Repos:
https://github.com/MaryamMohamedAuf/cohort-management-system-frontend-react
https://github.com/MaryamMohamedAuf/cohort-management-system-backend-laravel
Backend Setup (Laravel)
Clone the repository:
git clone https://github.com/MaryamMohamedAuf/cohort-management-system-backend-laravel.git
Install dependencies:
composer install
Set up environment variables:
cp .env.example .env
php artisan key:generate
Run migrations:
php artisan migrate
Start the development server:
php artisan serve
Frontend Setup (React)
Clone the repository:
git clone https://github.com/MaryamMohamedAuf/cohort-management-system-frontend-react.git
Install dependencies:
npm install
Start the development server:
npm start
Docker Setup
To run the React application using Docker instead “in case anyone do not want to install node”:
Build the Docker image:
docker build -t cohort-management-frontend .
 Run the container:
docker run -p 3000:3000 cohort-management-frontend
To quickly fill the database to test run : php artisan db:seed
Bec, the site have factories and seeders which will fill the database with random data automatically for testing
Filtering Process
  Objective
The filtering process was developed to enable admins to efficiently search and view applicants based on specific criteria. This ensures that only relevant applicants are displayed, improving the usability and effectiveness of the cohort management system.
1. **Backend (Laravel)**
   - **Dynamic Query Building:** The backend is designed to handle complex filtering queries by dynamically building SQL queries based on the selected criteria. This allows for filtering across multiple attributes, such as gender, solution type, and funding received.
   - **API Endpoint:** A dedicated API endpoint (`GET /applicants/filter`) is exposed to handle filtering requests. The endpoint accepts query parameters corresponding to the filter options, such as arrays for `gender`, `solution_type`, and `funding_received`.
   - **Efficient Data Retrieval:** The system is optimized to retrieve only the necessary data, ensuring that large datasets are not unnecessarily fetched, which improves performance.
2. **Frontend (React)**
   - **Sidebar Filter Interface:** The frontend includes a sidebar that presents filter options to the admin. The filter options are dynamically generated based on the available data fields and values, providing a user-friendly and flexible interface.
   - **Real-Time Updates:** The filtered applicant list is updated in real time as the admin selects or deselects filter options. This is achieved through AJAX requests made using `axios`, which sends the selected filter criteria to the backend and retrieves the filtered results.
   - **Default and No Results View:** When no filters are selected, all applicants are displayed by default. If the filters result in no matching applicants, a message is displayed to the admin stating, "No applicants found with this filter," ensuring a smooth user experience.

Analytics

Admin can access this dashboard by running “http://127.0.0.1:8000/pulse” or “http://127.0.0.1:8000/telescope” after starting the server in Laravel 



Pulse
Laravel Pulse is a tool for monitoring and analyzing Laravel applications in real time. It provides insights into various aspects of your application's performance and health, such as:
Real-Time Monitoring: Track metrics and performance in real time.
Application Health: Monitor system resources, request timings, and other critical indicators.
Alerts: Set up alerts for specific conditions or performance thresholds.
Visual Dashboards: View interactive and customizable dashboards for monitoring application metrics.
Pulse is designed to help developers and system administrators keep an eye on the operational aspects of their Laravel applications, making it easier to identify issues and optimize performance.
Telescope
Laravel Telescope is a debugging and monitoring tool specifically designed for Laravel applications. It provides deep insights into various aspects of your application’s behavior:

Request Monitoring: View detailed information about HTTP requests, including headers, payloads, and response times.
Database Queries: Analyze the queries being run, including their execution time and the data involved.
Exception Tracking: Track exceptions and errors, with detailed stack traces and contextual information.
Queue Monitoring: Monitor jobs and their statuses in the queue.
Cache Monitoring: View cache operations and hits/misses.
Modularization
It is the process of dividing a software system into smaller, self-contained modules that encapsulate specific functionality. Each module focuses on a particular aspect of the application, making it easier to manage, understand, and maintain the codebase. This approach promotes **separation of concerns**, **reusability**, and **scalability**.
In a modularized system:
- Each module has a clear responsibility.
- Modules can be developed, tested, and maintained independently.
- Changes in one module have minimal impact on others, leading to better maintainability.
example:
Separation of Concerns:
   - **CohortController:** This controller handles HTTP requests related to cohorts. It interacts with the `CohortService` to perform actions and returns responses to the client. The controller is focused solely on managing the HTTP layer.
   - **CohortService:** This service contains the business logic related to the `Cohort` entity. It provides methods for creating, retrieving, updating, and deleting cohorts. The service layer encapsulates the business logic and is reusable across different parts of the application.
   - **CohortRequest:** This request class handles validation logic for incoming requests related to cohorts. It ensures that only valid data reaches the service layer.
Encapsulation and Reusability:
   - The `CohortService` encapsulates all logic related to cohorts, making it reusable across different controllers or services. If you need to manage cohorts in another part of the application, you can reuse this service.
   - Validation logic is encapsulated in the `CohortRequest` class, ensuring consistency across different endpoints that handle cohort-related data.

Events and Listeners
In our application, we utilize the Event-Listener pattern to decouple various parts of the system, which enhances maintainability and flexibility. This pattern ensures that specific actions within the application trigger events, which can then be handled by listeners to perform necessary operations.

How It Works
- **Events**: Events represent important actions or changes within the system, such as the creation of a new applicant. When such an event occurs, it is automatically dispatched.
- **Listeners**: Listeners are responsible for executing the logic associated with the event. For instance, when an `ApplicantCreated` event is fired, a listener will notify the admin of the new applicant.
Benefits
- **Separation of Concerns**: By separating the event from the logic that processes it, our codebase remains clean and organized.
- **Scalability**: Adding new listeners or modifying existing ones is straightforward and does not require changes to the core logic, allowing the system to be easily extended.
- **Flexibility**: Multiple listeners can be attached to a single event, enabling various actions to be taken in response to a single trigger.
CI/CD
Continuous integration / continuous deployment. 
react:
Laravel:

Uses Netlify to host the React app for free
https://prex-db.netlify.app
 to be accessed easily and GitHub actions to make a pipeline for testing before deployment
The backend is hosted using Vapor by AWS services
Vapor makes deploying Laravel applications to AWS much simpler by handling the underlying AWS services for you.
It uses AWS Lambda for serverless computing, API Gateway for routing, RDS for databases, and S3 for file storage.


Testing
PHPUnit is used for backend unit tests. All Laravel testing system requirements passed 

All codes are formatted correctly according to or built on The PHP Coding Standards Fixer
“A tool to automatically fix PHP Coding Standards issues”


Future Work
Implement an automated backup process to ensure the safety and reliability of critical data. This will prevent data loss and ensure business continuity.
Including more companies with Prex.
Mobile responsiveness, Enhance the UI/UX to be fully responsive, ensuring seamless access across all devices, particularly for mobile users.
Technical documentation will be expanded to include detailed explanations of new features, updates.
Perform regular security audits and vulnerability assessments to keep the application secure.
Add applicant’s data for previous cohorts.
Add charts for calculated percentage.
Implement advanced analytics and reporting features
Enhance UI/UX.
Make the code cleaner.
Enhance the security.
Making the system diagrams more consistent as any attribute change


References
https://laravel.com/docs/11.x/
https://react.dev/learn


