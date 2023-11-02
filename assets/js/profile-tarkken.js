// const MoreBtn = document.querySelectorAll('.more-btn');
const reservationsMoreBtn = document.querySelector('.reservations-more-btn');
const violationsMoreBtn = document.querySelector('.violation-more-btn');
const closeDialogV = document.querySelector('.vio-close');
const closeDialogR = document.querySelector('.re-close');
const dialogViolations = document.querySelector('.dialog-violations');
const dialogReservations = document.querySelector('.dialog-reservations');

reservationsMoreBtn.addEventListener('click',e=>{
   dialogReservations.showModal();
})

violationsMoreBtn.addEventListener('click',e=>{
   dialogViolations.showModal();

})
// MoreBtn.forEach(btn=> {
//    btn.addEventListener('click', e=> {
//       dialog.showModal();
//    });
// });

closeDialogV.addEventListener('click', e=> {
   dialogViolations.close();
});
closeDialogR.addEventListener('click', e=> {
   dialogReservations.close();
});

$(function() {
   $(".toggle").on("click", function() {
      if ($(".item").hasClass("active")) {
         $(".item").removeClass("active");
      } else {
         $(".item").addClass("active");
      }
   });
});