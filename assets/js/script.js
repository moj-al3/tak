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
    }
    return formData;
}


async function sendDataToBackend(requestData) {
    // Define the URL of the PHP page
    const url = '/api/signup.php';
    try {
        // Perform a POST request using jQuery AJAX
        const response = await $.ajax({
            url: url,
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
    btn.addEventListener("click", () => {
        if (validateSignUpForm(formStepsNum)) {
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
    if (validateSignUpForm(formStepsNum)) {
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
