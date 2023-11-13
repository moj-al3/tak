// const MoreBtn = document.querySelectorAll('.more-btn');
const reservationsMoreBtn = document.querySelector('.reservations-more-btn');
const violationsMoreBtn = document.querySelector('.violation-more-btn');
const closeDialogV = document.querySelector('.vio-close');
const closeDialogR = document.querySelector('.re-close');
const dialogViolations = document.querySelector('.dialog-violations');
const dialogReservations = document.querySelector('.dialog-reservations');


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
            preConfirm: () => {
                const carPlate = document.getElementById("swal-input1").value;
                const carType = document.getElementById("swal-input2").value;
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













