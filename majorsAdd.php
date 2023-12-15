<?php
// Connect to the database (replace with your database credentials)
$conn = new mysqli("localhost", "root", "", "major_requirements");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data from Database</title>
  <link href="/dist/output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-adminBackgroundColor">
  <!--For inserting values-->
  <form method="post">
    <div class="grid grid-cols-2 gap-6 mr-60 ml-60 mt-40">
      <div>
        <label for="course-code" class="block">Course Code:</label>
        <input type="text" id="course-code" name="course-code" class="bg-transparent border-b border-black mt-1 outline-none focus:shadow-xl" />
      </div>
      <div>
        <label for="course-name" class="block">Course Name:</label>
        <input type="text" id="course-name" name="course-name" class="bg-transparent border-b border-black mt-1 outline-none focus:shadow-xl" />
      </div>
      <div>
        <label for="major" class="block">Major:</label>
        <select name="major" name="major" class="w-52 bg-transparent border-b border-black mt-1 outline-none focus:shadow-xl">
          <option>--</option>
          <option value="1">Computer Science</option>
          <option value="2">Business Administration</option>
          <option value="3">Management Information Systems</option>
        </select>
      </div>
      <div>
        <label for="passing-grade" class="block">Passing Grade:</label>
        <input type="text" id="passing-grade" name="passing-grade" class="bg-transparent border-b border-black mt-1 outline-none focus:shadow-xl" />
      </div>
    </div>
    <div class="inline-flex">
      <div class="col-span-2 ml-60 mt-10">
        <button type="submit" id="done-button" class="w-40 mt-8 bg-hoverColor bg-opacity-60 text-black font-normal py-2 px-4 rounded-xl mr-2 border-2 border-black hover:scale-110 transition duration-300">
          Done
        </button>
      </div>
      <div class="col-span-2 ml-60 mt-10">
        <button type="button" id="back-button" class="w-40 mt-8 bg-adminBackgroundColor bg-opacity-60 text-black font-normal py-2 px-4 rounded-xl mr-2 border-2 border-black hover:scale-110 transition duration-300">
          back
        </button>
      </div>
    </div>
  </form>

<?php
//Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  // retrive from data
  $courseCode = $_POST['course-code'];
  $courseName = $_POST['course-name'];
  $majorId = $_POST['major'];
  $passingGrade = $_POST['passing-grade'];

    // // Insert data into the database
  $sql = "INSERT INTO Courses (course_code, course_name, major_id, passing_grade) VALUES ('$courseCode', '$courseName', '$majorId', '$passingGrade')";
  
  // Insert data into the database
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New record created successfully');</script>";
  } else {
    echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
  }

  $conn->close(); // Close the connection
}
?>


</body>

        <script>
          // for back button
        document.getElementById('back-button').addEventListener('click', function(event) {
            window.location.href = 'majors.php'; 
        });

          // Redirecting to majorsCS.php when csC-button is clicked
        document.getElementById("csC-button").addEventListener("click", function(event) {
          window.location.href = "majorsCS.php";
        });

        // Redirecting to majorsMIS.php when misC-button is clicked
        document.getElementById("misC-button").addEventListener("click", function(event) {
          window.location.href = "majorsMIS.php";
        });

        // Redirecting to majorsBA.php when baC-button is clicked
        document.getElementById("baC-button").addEventListener("click", function(event) {
          window.location.href = "majorsBA.php";
        });
        </script>

</html>