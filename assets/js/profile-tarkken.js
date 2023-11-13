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
// MoreBtn.forEach(btn=> {
//    btn.addEventListener('click', e=> {
//       dialog.showModal();
//    });
// });

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
document.getElementById("delete").onclick = 
function delete1() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#blue",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
            });
        }
    });
}


document.getElementById("new car").onclick = 
async function addnewcar() {
    const { value: formValues } = await Swal.fire({
        title: "new car information",
        html: `
          <input id="swal-input1"  placeholder="Car plate">
          <input id="swal-input2"  placeholder="Car type">
        `,
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById("swal-input1").value,
                document.getElementById("swal-input2").value
            ];
        }
    });
    if (formValues) {
        Swal.fire(JSON.stringify(formValues));
    }
}


// get reference to button
var btn = document.getElementById("new car");

btn.addEventListener("click", addnewcar);

var btn = document.getElementById("delete");

btn.addEventListener("click", delete1);


window.onload = setup;













