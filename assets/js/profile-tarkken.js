// const MoreBtn = document.querySelectorAll('.more-btn');
const reservationsMoreBtn = document.querySelector('.reservations-more-btn');
const violationsMoreBtn = document.querySelector('.violation-more-btn');
const closeDialogV = document.querySelector('.vio-close');
const closeDialogR = document.querySelector('.re-close');
const dialogViolations = document.querySelector('.dialog-violations');
const dialogReservations = document.querySelector('.dialog-reservations');
const firstName = document.getElementById("first_name");
const lastName = document.getElementById("last_name");
const email = document.getElementById("email");
$(function () {
    // trigger form editing when the edit icon is clicked
    $("#edit").on("click", function () {
        $("#edit").addClass("hide");
        $("#save").removeClass("hide");
        $(".editable").removeAttr('readonly');
    });

    $("#save").on("click", async function () {

        var response = await Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to save the changes?",
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            cancelButtonColor: '#ff0050',
            preConfirm: async () => {
                if (!firstName.value || !lastName.value || !email.value) {
                    Swal.showValidationMessage('All fields are required');
                    return false;
                }
                if (!isAlphabetic(firstName.value)) {
                    Swal.showValidationMessage("Only alphabets are allowed for First Name");
                    return false;
                }
                if (!isAlphabetic(lastName.value)) {
                    Swal.showValidationMessage("Only alphabets are allowed for Last Name");
                    return false;
                }
                if (!isValidEmail(email.value)) {
                    Swal.showValidationMessage("Invalid email format");
                    return false;
                }
            }


        });
        if (response.isConfirmed) {
            $("#user-form").submit();
        }
    });
});

if (reservationsMoreBtn != null) {
    reservationsMoreBtn.addEventListener('click', e => {
        dialogReservations.showModal();
    })
}


violationsMoreBtn.addEventListener('click', e => {
    dialogViolations.showModal();

})


closeDialogV.addEventListener('click', e => {
    dialogViolations.close();
});
closeDialogR.addEventListener('click', e => {
    dialogReservations.close();
});

$(function () {
    $(".toggle").on("click", function () {
        if ($(".item").hasClass("active")) {
            $(".item").removeClass("active");
        } else {
            $(".item").addClass("active");
        }
    });
});

async function deleteCar(carID) {
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#blue",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    });
    if (result.isConfirmed) {
        submitForm({"action": "delete_car", "car_id": carID});
    }
}


document.getElementById("new car").onclick =
    async function addnewcar() {
        const {value: formValues} = await Swal.fire({
            title: "new car information",
            html: `
          <input id="swal-input1"  placeholder="Car plate">
          <input id="swal-input2"  placeholder="Car type">
        `,
            focusConfirm: false,
            preConfirm: async () => {
                const carPlate = document.getElementById("swal-input1").value;
                const carType = document.getElementById("swal-input2").value;
                if (!carPlate || !carType) {
                    Swal.showValidationMessage('Both fields are required');
                    return false;
                }
                if (!isValidCarPlate(carPlate)) {
                    Swal.showValidationMessage('Invalid car plate format. Use ABC-1234 format');
                    return false;
                }
                if (await isCarPlateUsed(carPlate)) {
                    Swal.showValidationMessage('This car plate is already used');
                    return false;
                }

                if (!isAlphabetic(carType)) {
                    Swal.showValidationMessage("Only alphabets are allowed for car type");
                    return false;

                }

                submitForm({"action": "add_car", "car_plate": carPlate, "car_type": carType});
            }
        });
    }


// get reference to button
var btn = document.getElementById("new car");

btn.addEventListener("click", addnewcar);

var btn = document.getElementById("delete");

btn.addEventListener("click", delete1);


window.onload = setup;

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




