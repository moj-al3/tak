function submitForm(inputData) {
    // Create a form element
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "");
    for (var key in inputData) {
        if (inputData.hasOwnProperty(key)) {
            // Create hidden field for each key-value pair
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", inputData[key]);
            form.appendChild(hiddenField);
        }
    }
    // Append the form to the body
    document.body.appendChild(form);
    // Submit the form
    form.submit();
}




