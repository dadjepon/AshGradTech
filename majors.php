<?php
// Remote database credentials
$remoteHost = "sql11.freesqldatabase.com";
$remoteUsername = "sql11670503";
$remotePassword = "Glc2I26vtM";
$remoteDatabase = "sql11670503";
$remotePort = 3306;

// Create a connection to the remote database
$conn = new mysqli($remoteHost, $remoteUsername, $remotePassword, $remoteDatabase, $remotePort);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM Courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/dist/output.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <title>title</title>
</head>

<body class="bg-adminBackgroundColor">
  
  <!-- Table -->
  <div class="overflow-x-auto w-full sm:w-3/4 my-auto mx-auto mt-6">
    <div class="p-1.5 w-full inline-block align-middle">
      <div class="overflow-hidden rounded-lg">
        <!-- button for changing between majors-->
        <div class="lg:px-36 px-10 flex justify-center">
          <div class="inline-flex rounded-md shadow-sm" role="group">
            <button id="csC-button" type="button"
              class="px-4 py-2 text-sm font-medium bg-transparent border border-hoverColor rounded-l-lg hover:bg-adminNavbarColor hover:text-hoverColor focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-adminNavbarColor hover:scale-110 transition duration-300">
              CS
            </button>
            <button id="baC-button" type="button"
              class="px-4 py-2 text-sm font-medium bg-transparent border-t border-b border-hoverColor hover:bg-adminNavbarColor hover:text-hoverColor focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-adminNavbarColor hover:scale-110 transition duration-300">
              BA
            </button>
            <button id="misC-button" type="button"
              class="px-4 py-2 text-sm font-medium bg-transparent border border-hoverColor rounded-r-lg hover:bg-adminNavbarColor hover:text-hoverColor focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-adminNavbarColor hover:scale-110 transition duration-300">
              MIS
            </button>
          </div>
        </div>

       <!--
        <div class="flex justify-start py-4 px-6">
          <select id="statusDropdown"
            class="h-full rounded-lg sm:rounded-lg border-r border-b block appearance-none w-44 bg-backgroundColor border-hoverColor text-black py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-backgroundColor mb-6 hover:scale-110 transition duration-300">
            
            <option>--</option>
            <option>2024</option>
            <option>2025</option>
            <option>2026</option>
          </select>
        </div> -->

        <!--Table-->
        <table id="course-table" class="min-w-full divide-y divide-hoverColor mt-6">
          <thead class="bg-antiquewhite">
            <tr>
              <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase">
                Course Code
              </th>
              <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase">
                Course Name
              </th>
            </tr>
          </thead>

          <tbody>
          <?php
            $uniqueCourses = array(); // Initialize an array to store unique course names and course codes

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $courseCode = $row["course_code"];
                $courseName = $row["course_name"];
                $courseKey = $courseCode . '-' . $courseName; // Create a unique key using course code and course name

                if (!isset($uniqueCourses[$courseKey])) {
                  $uniqueCourses[$courseKey] = true; // Mark the course as encountered
                  echo "<tr>";
                  echo "<td class='px-6 py-4 text-sm font-medium whitespace-nowrap text-center border-b border-hoverColor'>" . $courseCode . "</td>";
                  echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor'>" . $courseName . "</td>";
                  echo "</tr>";
                }
              }
            } else {
              echo "<tr><td colspan='2'>0 results</td></tr>";
            }
            $conn->close();
          ?>

          </tbody>
        </table>

        <!--button-->
        <div class="flex justify-center mt-10 space-x-20">
          <button id="add-button"
            class="w-40 bg-hoverColor bg-opacity-60 text-black font-normal py-2 px-4 rounded-xl mr-2 border-2 border-black hover:scale-110 transition duration-300">
            Add
          </button>
          <button id="delete-button"
            class="w-40 bg-adminBackgroundColor text-black font-normal py-2 px-4 rounded-xl border-2 border-black hover:scale-110 transition duration-300">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</body>

    <!--For script-->
<script>
  // Redirecting to majorsAdd.php when add-button is clicked
  document.getElementById("add-button").addEventListener("click", function(event) {
    window.location.href = "majorsAdd.php";
  });

  // Redirecting to majorsDelete.php when delete-button is clicked
  document.getElementById("delete-button").addEventListener("click", function(event) {
    window.location.href = "majorsDelete.php";
  });

  // Redirecting to majorsCS.php when csC-button is clicked
  document.getElementById("csC-button").addEventListener("click", function(event) {
    window.location.href = "majorsCS.php";
  });

  // Redirecting to majorsBA.php when baC-button is clicked
  document.getElementById("baC-button").addEventListener("click", function(event) {
    window.location.href = "majorsBA.php";
  });

  // Redirecting to majorsMIS.php when misC-button is clicked
  document.getElementById("misC-button").addEventListener("click", function(event) {
    window.location.href = "majorsMIS.php";
  });
</script>

</html>