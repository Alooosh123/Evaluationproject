Evaluationproject: Interactive Lecturer Evaluation System

Author: Alaa Alameri

Project Overview

Evaluationproject is an automated evaluation system designed to collect and analyze student responses to assess lecturer performance. The system provides an interface for users (students) to answer a set of specific questions. It then processes these responses using a special analytical function to calculate a final evaluation score, which can reach 5/5 if the performance is deemed excellent. The project aims to provide a clear and objective measure of teaching quality.

Key Features

    Response Collection: User-friendly interface for students to submit their evaluations for lecturers.

    Custom Data Analysis: Utilizes a special mathematical/logical function to process quantitative responses.

    Scoring System: Transforms the analysis results into a 5-star evaluation scale (5/5).

    User Management: A simple authentication system (Login) to verify the identity of users (students/administrators).

    Organized Database: Secure storage of evaluation and user data using MySQL.

Technology Stack

This project is built using a set of essential and effective web technologies:

    Backend: PHP for managing application logic, data processing, and interacting with the database.

    Database: MySQL for storing evaluation data, users, and lecturers.

    Frontend:

        HTML for building the basic structure of the web pages.

        CSS for styling and formatting the user interface.

        JavaScript for adding interactivity and client-side input validation.

Installation & Setup

To run this project locally, you will need a web server environment that supports PHP and MySQL. We recommend using the WAMP package (for Windows) or XAMPP (for multiple platforms).

Prerequisites

    Local Server Software: WAMP or XAMPP.

Steps

    Install the Web Server:

        Install and run WAMP (or XAMPP) on your machine.

    Transfer Project Files:

        Download or Clone the project files.

        Transfer the entire project folder (Evaluationproject) into your local server's directory.

            For WAMP: This directory is typically C:\wamp64\www or similar.

            For XAMPP: This directory is typically C:\xampp\htdocs.

    Database Setup:

        Open the database management interface (e.g., phpMyAdmin) by navigating to: http://localhost/phpmyadmin in your browser.

        Create a new database with your preferred name (e.g., evaluation_db).

        Inside the project folder, you will find the database file named eva (likely a .sql file).

        Import this file (eva.sql) into the new database you just created.

    Configuration (If Required):

        You may need to modify the database connection details (like username, password, and database name) within the project's connection file (typically a PHP file, such as config.php or db_connection.php).

        Common Default Credentials: Username: root, Password: (empty).

    Run the Application:

        Ensure the WAMP/XAMPP server is running.

        Open your browser and navigate to the project address, which will typically be:

        http://localhost/Evaluationproject/

 Usage

    Home Page (Login): You will be directed immediately to the Login Form.

    Login: Enter the user credentials (student/administrator) to access the system (Login user).

    Start Evaluation: After logging in, students can begin answering questions to evaluate the lecturers.

    View Results: Administrators can view the final results, including the final 5/5 score for each lecturer.

Core File Structure

To get started, focus on the following files:

    Login Form: Refers to the initial page containing the login form (often index.php or login.php).

    Login user: Refers to the logic for validating credentials (a PHP file handling the input).

    eva.sql: The MySQL database file that must be imported.

    Other PHP files: Contain the logic for fetching evaluation questions, processing responses, and calculating the final score.
