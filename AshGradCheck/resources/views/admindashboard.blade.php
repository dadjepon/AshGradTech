<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="/dist/output.css" rel="stylesheet">
    <title>Title</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="filterTable.js"></script>
</head>
<body> -->
@extends('layouts.navbar')

@section('content')
<div class="bg-adminBackgroundColor flex flex-col lg:justify-start lg:px-36 px-10">
    <div class="h-full mt-20 overflow-x-auto">
        <h1 class="font-semibold text-3xl">Dashboard</h1>
        <span class="text-sm text-hoverColor">Manage students who are on track or not here.</span>
        <p class="text-2xl font-semibold mt-10">Students requirement analytics</p>
        <div class="w-full md:w-auto items-center bg-adminNavbarColor rounded-md my-4 lg:px-48 md:px-48 px-16">
            <!-- label in the middle of the chart -->
            <div class="py-3 px-5 relative">
                <canvas class="p-10 items-center" id="chartDoughnut"></canvas>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                    <span id="totalValue" class="text-2xl font-bold text-black"></span>
                    <p class="text-lg">total</p>
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-semibold mt-10">Pending Activities</h1>
        <div class="relative mt-2">
            <select id="statusDropdown" onchange="filterTable()"
                    class="appearance-none h-full rounded-lg sm:rounded-lg border-r border-b block appearance-none w-44 bg-backgroundColor border-hoverColor text-black py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-backgroundColor focus:border-gray-500">
                <option>All</option>
                <option>On Track</option>
                <option>Not on Track</option>
            </select>
        <!--Table-->
        <div class="overflow-x-auto w-full sm:w-4/5 mx-auto mb-2 mt-2">
            <div class="p-1.5 w-full inline-block align-middle">
                <div class="overflow-hidden rounded-lg">
                    <table id="statusTable" class="min-w-full ">
                        <thead class="bg-antiquewhite ">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase border-b border-hoverColor">
                                Student
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase border-b border-hoverColor">
                                Meeting Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase border-b border-hoverColor">
                                Meeting Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-bold text-center uppercase border-b border-hoverColor">
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody class=" border-b border-hoverColor">
                        <tr class="border-b border-hoverColor"> <!--Row 2-->
                            <td class="lg:px-2 px-6 py-4 text-sm font-medium whitespace-nowrap text-center">
                                Jone Doe
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap text-center">
                                08/11/23
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap text-center">
                                9:AM
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-center">
                                <a class="text-green-500" href="#">
                                    On Track
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b border-hoverColor"> <!--Row 1-->
                            <td class="lg:px-2 px-6 py-4 text-sm font-medium whitespace-nowrap border-b border-hoverColor text-center">
                                Mellisa Rajput
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap border-b border-hoverColor text-center">
                                12/10/23
                            </td>
                            <td class="px-6 py-4 text-sm whitespace-nowrap border-b border-hoverColor text-center">
                                9:AM
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-center border-b border-hoverColor">
                                <a class="text-red-500" href="#">
                                    Not on Track
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>


</body>
<style>
    html,
    body {
        height: 100%;
    }

    @media (min-width: 640px) {
        table {
            display: inline-table !important;
        }

        thead tr:not(:first-child) {
            display: none;
        }
    }

    td:not(:last-child) {
        border-bottom: 0;
    }

    /th:not(:last-child) {/
    /*    border-bottom: 2px solid rgba(170, 118, 124);*/
    /}/
</style>


<!-- Progress bar -->

<script>

    






    <!-- Chart doughnut -->
    const dataDoughnut = {
        labels: ["Not on track", "On track"],
        datasets: [
            {
                label: "Students",
                data: [25, 75],
                backgroundColor: [
                    "red",
                    "#1DBC82",
                ],
                hoverOffset: 20,
            },
        ],
    };

    const configDoughnut = {
    type: "doughnut",
    data: dataDoughnut,
    options: {
        plugins: {
            datalabels: {
                display: false,
            },
            doughnutlabel: {
                labels: [
                    {
                        text: '',
                        font: {
                            size: 20,
                            weight: 'normal',
                        },
                    },
                    {
                        text: 'total',
                    },
                ],
            },
        },
        maintainAspectRatio: false,
    },
};


document.addEventListener('DOMContentLoaded', function() {
    var chartDoughnut = new Chart(
        document.getElementById("chartDoughnut"),
        configDoughnut
    );
});




    

    // Calculate and set the total value
    const totalValue = dataDoughnut.datasets[0].data.reduce((acc, val) => acc + val, 0);
    document.getElementById("totalValue").innerText = totalValue;

    function filterTable() {
    // Variables
    let dropdown, table, rows, cells, status, filter;
    dropdown = document.getElementById("statusDropdown");
    table = document.getElementById("statusTable");
    rows = table.getElementsByTagName("tr");
    filter = dropdown.value;

    // Loops through rows and hides those with countries that don't match the filter
    for (let row of rows) { // for...of loops through the NodeList
        cells = row.getElementsByTagName("td");
        status = cells[3] ? cells[3].textContent.trim() : null; // gets the 3rd td or nothing
        // if the filter is set to 'All', or this is the header row, or 2nd td text matches filter
        if (filter === "All" || !status || (filter === status)) {
            row.style.display = ""; // shows this row
        }
        else {
            row.style.display = "none"; // hides this row
        }
    }
}
</script>
</html>
@endsection