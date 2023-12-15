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