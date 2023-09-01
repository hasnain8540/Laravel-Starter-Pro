<script>
    function s925ModalCalculation() {
        // Get Value for Calculation
        var exchangeRate = $('#add_inventory_modal #exchange_rate').val();
        var laborCost = $('#add_inventory_modal #labor_cost').val();
        var silverCost = $('#add_inventory_modal #silver_cost').val();
        var duty = $('#add_inventory_modal #duty').val();
        // calculate Silver Cost
        if (silverCost != '') {
            var costWithoutDuty = (Number(laborCost) + Number(silverCost)) / Number(exchangeRate);
            var finalDuty = Number(costWithoutDuty) * Number(duty) / 100;
            var unitCost = Number(costWithoutDuty) + Number(finalDuty);
            // get Gram Related Data
            var gram = $('#add_inventory_modal #uom').val();
            var gramWeight = $('#add_inventory_modal #weight').val();
            // If UOM WEIGHT not equal to gram
            if (gram != 'g') {
                unitCost = Number(gramWeight) * Number(unitCost);
            }
    
            // Parse Calculated Value to Last Cost Field
            $('#add_inventory_modal #last_cost').val(unitCost.toFixed(2));
            $('#add_inventory_modal #unit_cost').val(unitCost.toFixed(2));
        } else {
            unitCost = $('#add_inventory_modal #unit_cost').val();
    
            // Parse Calculated Value to Last Cost Field
            $('#add_inventory_modal #last_cost').val(unitCost);
            $('#add_inventory_modal #unit_cost').val(unitCost);
        }
    }
    
    </script>