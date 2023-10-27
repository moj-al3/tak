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
    if (isEmptyStr(firstName.value)) {
        error = true;
        firstNameErr.innerHTML = "first name is required";
        firstNameErr.hidden = false;
    }

    if (isEmptyStr(lastName.value)) {
        error = true;
        lastNameErr.innerHTML = "last name is required";
        lastNameErr.hidden = false;
    }

    if (formStepsNum <= 0) {
        return error;
    }
    // step two validation

    if (isEmptyStr(nationalId.value)) {
        error = true;
        nationalIdErr.innerHTML = "national id is required";
        nationalIdErr.hidden = false;
    }
    if (!isEmptyStr(nationalId.value) && (await isUserIdUsed(nationalId.value))) {
        error = true;
        nationalIdErr.innerHTML = "national id is already used";
        nationalIdErr.hidden = false;

    }

    if (isEmptyStr(email.value)) {
        error = true;
        emailErr.innerHTML = "email is required";
        emailErr.hidden = false;
    }

    if (!isEmptyStr(email.value) && (await isEmailUsed(email.value))) {
        error = true;
        emailErr.innerHTML = "email id is already used";
        emailErr.hidden = false;

    }
    if (formStepsNum <= 1) {
        return error;
    }
    // step three validation

    if (isEmptyStr(carPlate.value)) {
        error = true;
        carPlateErr.innerHTML = "car plate is required";
        carPlateErr.hidden = false;
    }

    if (isEmptyStr(carType.value)) {
        error = true;
        carTypeErr.innerHTML = "car type is required";
        carTypeErr.hidden = false;
    }
    if (formStepsNum <= 2) {
        return error;
    }
    // step four validation
    if (isEmptyStr(password1.value)) {
        error = true;
        password1Err.innerHTML = "password is required";
        password1Err.hidden = false;
    }
    if (!isEmptyStr(password1.value) && password1.value.length < 7) {
        error = true;
        password1Err.innerHTML = "password must be longer than 7 characters";
        password1Err.hidden = false;
    }

    if (isEmptyStr(password2.value)) {
        error = true;
        password2Err.innerHTML = "password is required";
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
        alert("Your Account Was Created Successfully");
        window.location.href = "/auth/login.php";
        return;
    }

    alert("Something Went wrong");
});
