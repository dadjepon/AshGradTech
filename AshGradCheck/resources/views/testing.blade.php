<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Degree Audit Form</title>
</head>
<body>
    <h1>Degree Audit Form</h1>
    <form id="degreeAuditForm">
        <label for="major">Major:</label>
        <input type="text" id="major" name="major" required>
        <br>
        <label for="yearGroup">Year Group:</label>
        <input type="number" id="yearGroup" name="year_group" required>
        <br>
        <label for="semester">Semester:</label>
        <input type="number" id="semester" name="semester" required>
        <br>
        <label for="transcript">Upload Transcript:</label>
        <input type="file" id="transcript" name="transcript" accept=".pdf" required>
        <br>
        <button type="button" onclick="submitForm()">Submit</button>
    </form>

    <script>
        function submitForm() {
            const form = document.getElementById('degreeAuditForm');
            const formData = new FormData(form);

            fetch("https://us-central1-ashgradcheck.cloudfunctions.net/degree-audit-function/audit", {
                
                method: "POST",
                mode: "no-cors",
        headers: {
            'Content-Type': 'multipart/form-data',
            'Access-Control-Allow-Origin': '*',
        },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response from API:", data);
                // Handle the response as needed
            })
            .catch(error => {
                console.error("Error:", error);
                // Handle errors as needed
            });
        }
    </script>
</body>
</html>
