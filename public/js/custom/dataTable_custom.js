function initializeDataTable(tableId){
    // tableId = $("#tableId")
  // initialize datatable
  $(tableId).DataTable({
                    order: [[0, 'desc']],
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "responsive": true
                });
}

// '#pickingIndexTable'
function uninitializeDataTable(tableWithHashId = '#tableId'){
    if ($.fn.DataTable.isDataTable('#pickingIndexTable')) {
      var table = $('#pickingIndexTable').DataTable();
      table.destroy();
    }
}

// search on input field
 function searchInsideTable(searchInput,tableId='#tableId') {
        const searchTerm = searchInput.value.toLowerCase();
        const tableRows = document.querySelectorAll(tableId+' tbody tr');

        tableRows.forEach((row) => {
            const cells = row.querySelectorAll('td');
            let foundMatch = false;

            cells.forEach((cell) => {
            const cellText = cell.textContent.toLowerCase();
            if (cellText.includes(searchTerm)) {
                foundMatch = true;
            }
            });

            if (foundMatch) {
            row.style.display = '';
            } else {
            row.style.display = 'none';
            }
        });
    }