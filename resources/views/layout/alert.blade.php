@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['success'](
                    '{{Session::get('success')}}',
                    'Well done!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@elseif(Session::has('info'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['info'](
                    '{{Session::get('info')}}',
                    'Heads up!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@elseif(Session::has('warning'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['warning'](
                    '{{Session::get('warning')}}',
                    'Warning!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@elseif(Session::has('danger'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['error'](
                    '{{Session::get('danger')}}',
                    'ERROR!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@elseif(Session::has('errors'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['error'](
                    '{{Session::get('errors')}}',
                    'ERROR!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@endif
@if (session('status'))
    <script>
        $(document).ready(function() {
            setTimeout(function () {
                toastr['success'](
                    '{{Session::get('status')}}',
                    'Well done!',
                    {
                        closeButton: true,
                        tapToDismiss: false
                    }
                );
            }, 2000);
        });
    </script>
@endif
