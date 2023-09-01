<script>
    "use strict";

    // getRecords(null, null, null, null, 4)

    /*
    search form submission
     */
    // getRecords(null, null, null, null)

    $('#filterSearchForm').submit(function (e) {
        e.preventDefault();
        const from_date = $('#from_date').val();
        const to_date = $('#to_date').val();
        const zero_balance = $('#last_zero_balance').val();

        getRecords(from_date, to_date, zero_balance);
    });

    //loading data table
    function getRecords(from_date, to_date, zero_balance) {
        const table = $('#accountReceiveableTable').DataTable({
            language: {search: '<i class="fa fa-search"></i>', searchPlaceholder: "Search Customer"},
            processing: true,
            serverSide: false,
            destroy: true,
            search: true,
            ajax: {
                url: "{{ route('searchReceiveable') }}",
                data: {
                    "from_date": from_date,
                    "to_date": to_date,
                    "zero_balance": zero_balance
                },
            },

            columns: [
                {data: 'date', name: 'date'},
                {data: 'transaction_no', name: 'transaction_no'},
                {data: 'description', name: 'description'},
                {data: 'type', name: 'type'},
                {data: 'amount', name: 'amount'},
                {data: 'account_balance', name: 'account_balance'},
            ],
        })
    }

</script>
