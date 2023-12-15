<?php
// Connect to the database (replace with your database credentials)
$conn = new mysqli("localhost", "root", "", "major_requirements");

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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data from Database</title>
  <link href="/dist/output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-adminBackgroundColor">
  <!-- button for changing between majors-->
  <div class="lg:px-36 px-10 flex justify-center mt-8">
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
  <!--Table-->
  <div class="container mx-auto mt-10">
    <!-- <h1 class="text-2xl font-bold mb-4">Data from Database</h1> -->
    <table class="min-w-full divide-y divide-hoverColor">
      <thead class="bg-antiquewhite">
        <tr>
          <th class="px-6 py-3 text-xs font-bold text-center uppercase">Course Code</th>
          <th class="px-6 py-3 text-xs font-bold text-center uppercase">Course Name</th>
          <!-- Add more headers for additional columns -->
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            if (strpos($row["major_id"], 1) !== false){
              echo "<tr>";
              echo "<td class='px-6 py-4 text-sm font-medium whitespace-nowrap text-center border-b border-hoverColor'>" . $row["course_code"] . "</td>";
              echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor'>" . $row["course_name"] . "</td>";
              // Add more cells for additional columns
              echo "</tr>";
            }
          }
        } else {
          echo "<tr><td colspan='2'>0 results</td></tr>";
        }
        $conn->close(); // closing database
        ?>
      </tbody>
    </table>
  </div>

      <!--button-->
      <div class="flex justify-center mt-2 mb-6 space-x-20">
        <button id="done-button" class="w-40 ml-20 mt-8 bg-hoverColor bg-opacity-60 text-black font-normal py-2 px-4 rounded-xl mr-2 border-2 border-black hover:scale-110 transition duration-300">
          Done
        </button>
      </div>
</body>

        <script>
          // for done button
        document.getElementById('done-button').addEventListener('click', function(event) {
            window.location.href = 'majors.php'; 
        });

        // Redirecting to majorsBA.php when baC-button is clicked
        document.getElementById("baC-button").addEventListener("click", function(event) {
          window.location.href = "majorsBA.php";
        });

        // Redirecting to majorsMIS.php when misC-button is clicked
        document.getElementById("misC-button").addEventListener("click", function(event) {
          window.location.href = "majorsMIS.php";
        });

        // Redirecting to majorsCS.php when csC-button is clicked
        document.getElementById("csC-button").addEventListener("click", function(event) {
          window.location.href = "majorsCS.php";
        });
        </script>

</html>
