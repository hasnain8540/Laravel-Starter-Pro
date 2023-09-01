<script>
    function formatDate(date){
        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        var today = new Date(date);
                        let newDate = today.toLocaleDateString("en-US", options);
                        let time = timeformat(today);

                        return newDate + " - " + time;

    }

    function timeformat(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime.toUpperCase();
    }

    function formatOnlyDate(date) {
        var options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        var today = new Date(date);
        let newDate = today.toLocaleDateString("en-US", options);
        let time = timeformat(today);

        return newDate;

    }

    function changeTimezone(date, ianatz) {

        // suppose the date is 12:00 UTC
        var invdate = new Date(date.toLocaleString('en-US', {
            timeZone: ianatz
        }));

        // then invdate will be 07:00 in Toronto
        // and the diff is 5 hours
        var diff = date.getTime() - invdate.getTime();

        // so 12:00 in Toronto is 17:00 UTC
        return new Date(date.getTime() - diff); // needs to substract

    }


    //date format Oct 10, 2022 - 09:45 AM
    function formatDateShortMonthName(date) {
        var options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        };
        var today = new Date(date);
        today = changeTimezone(today, "America/New_York");
        let newDate = today.toLocaleDateString("en-US", options);
        let time = timeformat(today);

        return newDate + " - " + time;

    }
</script>
