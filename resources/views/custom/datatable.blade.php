<script>
    "use strict";

    // Class definition
    var KTDataList = function () {
        // Define shared variables
        var datatable;
        var filterMonth;
        var filterPayment;
        var table

        // Private functions
        var initVendorList = function () {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                "info": false,
                'order': [],
            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            datatable.on('draw', function () {

            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-datatable-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Handle status filter dropdown
        var handleStatusFilter = () => {
            const filterStatus = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
            $(filterStatus).on('change', e => {
                let value = e.target.value;
                if (value === 'all') {
                    value = '';
                }
                datatable.column(1).search(value).draw();
            });
        }

        // Public methods
        return {
            init: function () {
                table = document.querySelector('.kt_table');

                if (!table) {
                    return;
                }

                initVendorList();
                handleSearchDatatable();
                handleStatusFilter();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTDataList.init();
    });
</script>
