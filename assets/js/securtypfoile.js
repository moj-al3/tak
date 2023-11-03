// const MoreBtn = document.querySelectorAll('.more-btn');

const violationsMoreBtn = document.querySelector('.violation-more-btn');
const closeDialogV = document.querySelector('.vio-close');
const closeDialogR = document.querySelector('.re-close');
const dialogViolations = document.querySelector('.dialog-violations');
const dialogReservations = document.querySelector('.dialog-reservations');


violationsMoreBtn.addEventListener('click', e => {
    dialogViolations.showModal();

})


closeDialogV.addEventListener('click', e => {
    dialogViolations.close();
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
