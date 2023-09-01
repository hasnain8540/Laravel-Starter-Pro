<script>

    function sendEmail(orderNo) {

        setTimeout(function () {
            toastr['info'](
                'Please wait your Request is inProgress.',
                '',
                {
                    closeButton: true,
                    tapToDismiss: true
                }
            );
        }, 1000);

        $.ajax({
            type: "get",
            url: "{{ route('saleOrder.imageMail') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                order_no: orderNo
            },
            success: function (response) {
                if (response.success) {

                    setTimeout(function () {
                        toastr['success'](
                            'Success! Email Send to Customer Successfully.',
                            'Success!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if (response.emailError) {

                    setTimeout(function () {
                        toastr['error'](
                            'Error! Default Email Not Set.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else if (response.customerError) {

                    setTimeout(function () {
                        toastr['error'](
                            'Error! Customer Not Found.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                } else {
                    setTimeout(function () {
                        toastr['error'](
                            'Error! Something went Wrong.',
                            'Error!',
                            {
                                closeButton: true,
                                tapToDismiss: true
                            }
                        );
                    }, 2000);
                }
            },
        })
    }

</script>
