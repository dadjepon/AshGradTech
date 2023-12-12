# AshGradCheck Software User Guide

Welcome to AshGradCheck, your comprehensive degree audit software. This guide will walk you through the steps to use the software effectively. Please follow the instructions carefully for a seamless experience.

### Table of Contents
1. [Accessing MyCAMU and Downloading Transcript](#accessing-mycamu-and-downloading-transcript)
2. [Navigating to AshGradCheck Software](#navigating-to-ashgradcheck-software)
3. [User Registration](#user-registration)
4. [Uploading Transcript](#uploading-transcript)
5. [Performing Degree Audit](#performing-degree-audit)
6. [Logging Out and Future Access](#logging-out-and-future-access)

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