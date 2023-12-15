

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data from Database</title>
  <link href="/dist/output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
          <th class="px-6 py-3 text-xs font-bold text-center uppercase">Actions</th>
        </tr>
      </thead>
      <tbody>

      <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "major_requirements";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Check if the course ID is provided in the request for deletion
        if (isset($_GET['id'])) {
          $courseId = $_GET['id'];

          // Prepare a delete statement
          $sql = "DELETE FROM  Courses WHERE course_id = $courseId";

          if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
          } else {
            echo "Error deleting record: " . $conn->error;
          }
        }

        // Retrieve distinct course codes and names from the database
        $sql = "SELECT DISTINCT course_code, course_name, course_id FROM Courses";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data of each row
          while($row = $result->fetch_assoc()) {
            $courseCode = $row["course_code"];
            $courseName = $row["course_name"];
            $courseId = $row["course_id"];
            echo "<tr>";
            echo "<td class='px-6 py-4 text-sm font-medium whitespace-nowrap text-center border-b border-hoverColor'>" . $courseCode . "</td>";
            echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor'>" . $courseName . "</td>";
            echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor'><button class='delete-button hover:scale-110 transition duration-300' data-course-id='" . $courseId . "'>Delete</button></td>";
            echo "</tr>";
          }
        } else {
          echo "0 results";
        }
        $conn->close();
      ?>

      <!-- <script>
      
      </script> -->





      <!-- <?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "major_requirements";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve distinct course codes and names from the database
$sql = "SELECT DISTINCT course_code, course_name FROM Courses";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    $courseCode = $row["course_code"];
    $courseName = $row["course_name"];
    echo "<tr>";
    echo "<td class='px-6 py-4 text-sm font-medium whitespace-nowrap text-center border-b border-hoverColor'>" . $courseCode . "</td>";
    echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor'>" . $courseName . "</td>";
    echo "<td class='px-6 py-4 text-sm whitespace-nowrap text-center border-b border-hoverColor hover:scale-110 transition duration-300'><button onclick='confirmDelete(" . $row["course_id"] . ")'>Delete</button></td>";
    echo "</tr>";
  }
} else {
  echo "0 results";
}
$conn->close();
?> -->

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
          document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
              if (event.target.classList.contains('delete-button')) {
                if (confirm("Are you sure you want to delete this course?")) {
                  var courseId = event.target.dataset.courseId;
                  var xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                      alert(this.responseText);
                      // You can also update the page content here if needed
                    }
                  };
                  xhttp.open("GET", "majorsDelete.php?id=" + courseId, true);
                  xhttp.send();
                }
              }
            });
          });

        // function confirmDelete(courseId) {
        //   if (confirm("Are you sure you want to delete this course?")) {
        //     window.location.href = "majorsDelete1.php?id=" + courseId;
        //   }
        // }

          // for done button
        document.getElementById('done-button').addEventListener('click', function(event) {
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
