function maxTwoDecimalAllowed(value){
    const regex = /^\d+(\.\d{1,2})?$/; // Regular expression for valid values

    if (regex.test(value)) {
      return true; // Value is valid
    } else {
      return false; // Value is invalid
    }
}

function fixedToTwoDecimal(value){
    value = Number(value);
    return value.toFixed(2);
}