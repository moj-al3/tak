const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const submitBtn = document.getElementById("submit_btn");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");
const kfuMemberRadio = document.getElementById("kfu_member");
const visitorRadio = document.getElementById("visitor");
const nationalIdLabel = document.querySelector('label[for="national_id"]');
const regestrationForm = document.getElementById("regestration_form");
const firstName = document.getElementById("first_name");
const lastName = document.getElementById("last_name");

const nationalId = document.getElementById("national_id");
const email = document.getElementById("email");

const carPlate = document.getElementById("car_plate");
const carType = document.getElementById("car_type");

const password1 = document.getElementById("password");
const password2 = document.getElementById("password2");

const errorMessages = document.querySelectorAll(".error-message");

const firstNameErr = document.getElementById("first_name_err");
const lastNameErr = document.getElementById("last_name_err");

const nationalIdErr = document.getElementById("national_id_err");
const emailErr = document.getElementById("email_err");

const carPlateErr = document.getElementById("car_plate_err");
const carTypeErr = document.getElementById("car_type_err");

const password1Err = document.getElementById("password1_err");
const password2Err = document.getElementById("password2_err");


function isEmptyStr(str) {
    return str === "" || str === null || str === undefined;
}

function resetErrors() {
    errorMessages.forEach((errorMessage) => {
        errorMessage.innerHTML = "";
        errorMessage.hidden = true;
    });
}


async function isUserIdUsed(userId) {
    var result;
    await $.ajax({
        url: '/api/check-userid-used.php',
        type: 'GET',
        data: {user_id: userId},
        success: function (data) {
            result = data;
        },
        error: function () {
            console.error("something went wrong with checking userID")
            result = true;
        }
    });
    return result;
}

// Function to check if a car plate is used
async function isCarPlateUsed(carPlate) {
    var result;
    await $.ajax({
        url: '/api/check-car-plate.php',
        type: 'GET',
        data: {car_plate: carPlate},
        success: function (data) {
            result = data;
        },
        error: function () {
            console.error("Something went wrong with checking car plate");
            result = true;
        }
    });
    return result;
}

async function isEmailUsed(email) {
    var result;
    await $.ajax({
        url: '/api/check-email-used.php',
        type: 'GET',
        data: {email: email},
        success: function (data) {
            result = data;
        },
        error: function () {
            console.error("something went wrong with checking email")
            result = true;
        }
    });

    return result;
}

async function validateSignUpForm(formStepsNum) {
    error = false;
    resetErrors();

    // step one validation
    if (!visitorRadio.checked && !kfuMemberRadio.checked) {
        error = true;
        swal.fire({
            icon: "error",
            text: "Please Select A User Type First"
        })
    }

    if (isEmptyStr(firstName.value)) {
        error = true;
        firstNameErr.innerHTML = "This Field is required";
        firstNameErr.hidden = false;
    } else if (!isAlphabetic(firstName.value)) {
        error = true;
        firstNameErr.innerHTML = "Only alphabets are allowed";
        firstNameErr.hidden = false;
    }

    if (isEmptyStr(lastName.value)) {
        error = true;
        lastNameErr.innerHTML = "This Field is required";
        lastNameErr.hidden = false;
    } else if (!isAlphabetic(lastName.value)) {
        error = true;
        lastNameErr.innerHTML = "Only alphabets are allowed";
        lastNameErr.hidden = false;
    }

    if (formStepsNum <= 0) {
        return error;
    }
    // step two validation


    if (isEmptyStr(nationalId.value)) {
        error = true;
        nationalIdErr.innerHTML = "This Field is required";
        nationalIdErr.hidden = false;
    } else if (!isNumeric(nationalId.value)) {
        error = true;
        nationalIdErr.innerHTML = "Only numbers are allowed";
        nationalIdErr.hidden = false;
    } else if (!error && visitorRadio.checked && nationalId.value.length !== 10) {
        error = true;
        nationalIdErr.innerHTML = "The length of the ID should be 10";
        nationalIdErr.hidden = false;
    } else if (!error && kfuMemberRadio.checked && nationalId.value.length !== 9) {
        error = true;
        nationalIdErr.innerHTML = "The length of the ID should be 9";
        nationalIdErr.hidden = false;
    } else if (await isUserIdUsed(nationalId.value)) {
        error = true;
        nationalIdErr.innerHTML = "This ID is already used";
        nationalIdErr.hidden = false;

    }


    // Step three validation
    if (isEmptyStr(email.value)) {
        error = true;
        emailErr.innerHTML = "This Field is required";
        emailErr.hidden = false;
    } else if (!isValidEmail(email.value)) {
        error = true;
        emailErr.innerHTML = "Invalid email format";
        emailErr.hidden = false;
    } else if (!isEmptyStr(email.value) && (await isEmailUsed(email.value))) {
        error = true;
        emailErr.innerHTML = "This email is already used";
        emailErr.hidden = false;
    }
    if (formStepsNum <= 1) {
        return error;
    }
    // step three validation

    if (isEmptyStr(carPlate.value)) {
        error = true;
        carPlateErr.innerHTML = "This Field is required";
        carPlateErr.hidden = false;
    } else if (!isValidCarPlate(carPlate.value)) {
        error = true;
        carPlateErr.innerHTML = "Invalid car plate format. Use ABC-1234 format";
        carPlateErr.hidden = false;
    } else if (!error && (await isCarPlateUsed(carPlate.value))) {
        error = true;
        carPlateErr.innerHTML = "This car plate is already used";
        carPlateErr.hidden = false;
    }

    if (isEmptyStr(carType.value)) {
        error = true;
        carTypeErr.innerHTML = "This Field is required";
        carTypeErr.hidden = false;
    } else if (!isAlphabetic(carType.value)) {
        error = true;
        carTypeErr.innerHTML = "Only alphabets are allowed";
        carTypeErr.hidden = false;
    }
    if (formStepsNum <= 2) {
        return error;
    }
    // step four validation
    if (isEmptyStr(password1.value)) {
        error = true;
        password1Err.innerHTML = "This Field is required";
        password1Err.hidden = false;
    }
    if (!isEmptyStr(password1.value) && password1.value.length < 7) {
        error = true;
        password1Err.innerHTML = "password must be longer than 7 characters";
        password1Err.hidden = false;
    }

    if (isEmptyStr(password2.value)) {
        error = true;
        password2Err.innerHTML = "This Field is required";
        password2Err.hidden = false;
    }
// check passweord that match
    if (password1.value != password2.value) {
        error = true;
        password2Err.innerHTML = "Confirm password does not match password";
        password2Err.hidden = false;
    }
    return error;
}

function getFormData() {
    // Get the form element by its ID
    const form = document.getElementById('regestration_form');

    // Create an empty object to store form data
    const formData = {};

    // Loop through form elements and populate the formData object
    for (const element of form.elements) {
        if (element.name) {
            if (element.type === 'checkbox') {
                formData[element.name] = element.checked;
            } else {
                formData[element.name] = element.value;
            }
        }
        if (element.name === "user_type_id") {
            formData[element.name] = form.elements.user_type_id.value;
        }
    }

    console.log(formData);
    return formData;
}


async function sendDataToBackend(requestData) {
    try {
        // Perform a POST request using jQuery AJAX
        const response = await $.ajax({
            url: '/api/signup.php',
            type: 'POST',
            data: requestData
        });
        console.log(response);
        // Assuming a successful response, return true
        return true;
    } catch (error) {
        alert(error)
        console.error(error);
        // Return false in case of an error
        return false;
    }
}


let formStepsNum = 0;

nextBtns.forEach((btn) => {
    btn.addEventListener("click", async () => {
        if (await validateSignUpForm(formStepsNum)) {
            return;
        }
        formStepsNum++;
        updateFormSteps();
        updateProgressbar();
    });
});

prevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        formStepsNum--;
        updateFormSteps();
        updateProgressbar();
    });
});

function updateFormSteps() {
    formSteps.forEach((formStep) => {
        formStep.classList.contains("form-step-active") &&
        formStep.classList.remove("form-step-active");
    });
    formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressbar() {
    progressSteps.forEach((progressSteps, idx) => {
        if (idx < formStepsNum + 1) {
            progressSteps.classList.add("progress-step-active");
        } else {
            progressSteps.classList.remove("progress-step-active");
        }
    });
}

kfuMemberRadio.addEventListener("change", function () {
    if (kfuMemberRadio.checked) {
        nationalIdLabel.textContent = "KFU ID:";
    } else {
        nationalIdLabel.textContent = "National ID:";
    }
});

visitorRadio.addEventListener("change", function () {
    if (visitorRadio.checked) {
        nationalIdLabel.textContent = "National ID:";
    } else {
        nationalIdLabel.textContent = "KFU ID :";
    }
});

submitBtn.addEventListener("click", async function () {
    if (await validateSignUpForm(formStepsNum) == true) {
        return;
    }
    var result = await sendDataToBackend(getFormData());

    if (result == true) {
        await swal.fire({
            icon: "success",
            text: "Your Account Was Created Successfully",
            showConfirmButton: false,
            timer: 1500,
        })
        window.location.href = "/auth/login.php";
        return;
    }

    alert("Something Went wrong");
});

// Function to check if a string contains only alphabets
function isAlphabetic(str) {
    return /^[a-zA-Z]+$/.test(str);
}

// Function to check if a string contains only numbers
function isNumeric(str) {
    return /^\d+$/.test(str);
}

// Function to check if an email has a valid format
function isValidEmail(email) {
    // A simple regular expression for basic email format validation
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Function to check if a car plate has a valid format
function isValidCarPlate(carPlate) {
    // A simple regular expression for basic car plate format validation
    return /^[A-Za-z]{3}-\d{4}$/.test(carPlate);
}