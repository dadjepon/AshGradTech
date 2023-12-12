# AshGradCheck System Implementation

## Technology & Justification

For our implementation, the AshGradCheck system is built upon a scalable three-tier architecture, comprising a frontend, backend, and a database. This architecture ensures a clear separation of concerns, making the application modular, maintainable, and adaptable to future changes. The software stacks and tools selected for the individual tiers were chosen specifically to optimize performance, user experience, and system reliability. In this section, we discuss the core functionalities of our software and the technologies that helped successfully develop the system.

### Frontend - Tailwind CSS 🎨

The AshGradCheck system employs Tailwind CSS for the frontend to utilize its utility-first approach. This aligns with our goal of developing a clean and responsive user interface. The modular nature of Tailwind CSS makes it easy to customize and maintain during development. The framework facilitates the creation of a responsive and visually appealing user interface, aligning with contemporary design principles. The use of "sr-only" classes enhances accessibility, making AshGradCheck inclusive and user-friendly for individuals with visual impairments.

### Backend - Laravel (PHP) 🚀

Laravel forms the backbone of the AshGradCheck application. Laravel's elegance in syntax, coupled with powerful features like the Eloquent ORM and Blade templating engine, ensures the efficient handling of client-side requests, data processing, and seamless communication between the frontend and the database. Laravel's adoption of the MVC architectural pattern organizes our code for clear communication between frontend and backend, streamlining development, debugging, and maintenance. This scalable structure ensures that AshGradCheck can effortlessly accommodate future enhancements, making it an efficient tool for long-term development and growth.

### Database (MySQL) 🗃️

MySQL is chosen as the database management system, ensuring data integrity and efficient storage and retrieval of student records. Its compatibility with Laravel's Eloquent ORM streamlines database operations and enhances overall system performance. MySQL plays a pivotal role in maintaining the integrity of student records, fostering efficient data handling, and contributing to the overall stability and responsiveness of the AshGradCheck application.

### OCR Tool (Google Document AI) 🔍

The OCR functionality is powered by a customized Google Document AI tool, trained on our dataset of Ashesi University transcripts. Leveraging Google's state-of-the-art OCR capabilities, this tool extracts text data accurately from scanned transcripts. This OCR feature plays a pivotal role in providing users with a comprehensive and accurate degree audit, contributing significantly to the application's core functionality and user experience.

### API Integration (Flask - Python) 🐍

The business logic for accepting a user's transcript and evaluating their graduation status is exposed through a Flask API, implemented as a Google Cloud Function. Flask's lightweight and flexible nature, combined with seamless deployment on Google Cloud, ensures an efficient microservices architecture and facilitates the integration of our system with other applications.




# AshGradCheck Software User Guide

Welcome to AshGradCheck, your comprehensive degree audit software. This guide will walk you through the steps to use the software effectively. Please follow the instructions carefully for a seamless experience.

### Table of Contents
1. [Accessing MyCAMU and Downloading Transcript](#accessing-mycamu-and-downloading-transcript)
2. [Navigating to AshGradCheck Software](#navigating-to-ashgradcheck-software)
3. [User Registration](#user-registration)
4. [Uploading Transcript](#uploading-transcript)
5. [Performing Degree Audit](#performing-degree-audit)
6. [Logging Out and Future Access](#logging-out-and-future-access)
  

#### Technology & Justification<a name="technology--justification"></a>

### 1. Accessing MyCAMU and Downloading Transcript<a name="accessing-mycamu-and-downloading-transcript"></a>

Start by accessing your MyCAMU page, Ashesi University's LMS for managing your academic information. Follow these steps:

- **Homepage:** Visit the homepage of your MyCAMU account.

- **Navigate to Transcript:** Find and navigate to the transcript page within MyCAMU.

- **Scroll to Bottom:** Scroll down to the bottom of the transcript page. This is crucial to ensure that the entire content is captured during the printing process.

- **Print or Download as PDF:** Right-click on the screen or use the keyboard shortcut (Ctrl/Cmd + P) to open the print dialog. Choose the option to download the page as a PDF. Ensure the print preview captures all the grade pages in the transcript.

### 2. Navigating to AshGradCheck Software<a name="navigating-to-ashgradcheck-software"></a>

Once you have downloaded your transcript PDF, proceed to AshGradCheck Software. Here is where you can perform a detailed degree audit.

- **URL:** Use the provided URL to navigate to the AshGradCheck Software page.

### 3. User Registration<a name="user-registration"></a>

If you are a first-time user, you need to sign up. Follow these steps:

- **Sign Up:** Click on the sign-up link and provide the required information.
  
- **Credentials:** Remember the login credentials you used during sign-up.

### 4. Uploading Transcript<a name="uploading-transcript"></a>

After successfully signing up, you'll be directed to a page where you can upload your downloaded transcript PDF.

- **Upload PDF:** Click the upload button and select the downloaded PDF from your computer.

### 5. Performing Degree Audit<a name="performing-degree-audit"></a>

Performing a degree audit is a straightforward process.

- **Audit Button:** Click the "Audit" button to initiate the audit process.

### 6. Logging Out and Future Access<a name="logging-out-and-future-access"></a>

After completing the audit, you can log out. Future access is easy:

- **Logout:** Click on the logout button to sign out from your current session.

- **Login:** When returning, use the credentials you provided during the sign-up process to log in. You can access results from your previous audits or perform new audits.

Congratulations! You have successfully used AshGradCheck Software to perform a degree audit. If you have any questions or encounter issues, please refer to the provided support resources or contact our helpdesk for assistance.




# Degree Audit API Documentation (For DEVS)

## Overview

The Degree Audit API provides functionality to perform an audit on a student's transcript and evaluate their progress towards degree requirements.

- Base URL: https://us-central1-ashgradcheck.cloudfunctions.net/degree-audit-function/audit
- HTTP Method: POST

## Request

### Headers

No special headers are required for this request.

### Parameters

- `transcript` (file) - The student's transcript in PDF format.
- `semester` (text) - The semester of the level in which a student is currently in. (You either select '1' or '2' as the semester) For example, in level 300, you could be in the first semester (1) or the second semester (2).
- `major` (text) - The major or program of study for the student.
- `year_group` (text) - The year group or graduation year of the student.

### Example Request

```http
POST /audit
Content-Type: multipart/form-data

transcript: [Binary PDF file]
semester: 1
major: CS
year_group: 2024
```

### Example Response (Success)
```json
{
    "failed": ["Linear Algebra", "Calculus II"],
    "total_credits": 23.0,
    "track_status": "On Track"
}
```
