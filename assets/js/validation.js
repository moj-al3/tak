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
function submitValidate(btn) {
  if (validateSignUpForm()) {
    error = false;
    resetErrors();
  }
}

function validateSignUpForm(formStepsNum) {
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

  if (isEmptyStr(email.value)) {
    error = true;
    emailErr.innerHTML = "email is required";
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
