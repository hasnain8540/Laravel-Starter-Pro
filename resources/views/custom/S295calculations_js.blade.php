<script>
function s925Calculation() {
    // Get Value for Calculation
    var exchangeRate = $('#exchange_rate').val();
    var laborCost = $('#labor_cost').val();
    var silverCost = $('#silver_cost').val();
    var duty = $('#duty').val();
    // calculate Silver Cost
    if (silverCost != '') {
        var costWithoutDuty = (Number(laborCost) + Number(silverCost)) / Number(exchangeRate);
        var finalDuty = Number(costWithoutDuty) * Number(duty) / 100;
        var unitCost = Number(costWithoutDuty) + Number(finalDuty);
        // get Gram Related Data
        var gram = $('#uom').val();
        var gramWeight = $('#weight').val();
        // If UOM WEIGHT not equal to gram
        if (gram != 'g') {
            unitCost = Number(gramWeight) * Number(unitCost);
        }

        // Parse Calculated Value to Last Cost Field
        $('#last_cost').val(unitCost.toFixed(2));
        $('#unit_cost').val(unitCost.toFixed(2));
    } else {
        unitCost = $('#unit_cost').val();

        // Parse Calculated Value to Last Cost Field
        $('#last_cost').val(unitCost);
        $('#unit_cost').val(unitCost);
    }
}

</script>