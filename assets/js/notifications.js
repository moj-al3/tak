// define util functions
function numberOfDays(endDate) {
  today = new Date();
  var time_difference = endDate.getTime() - today.getTime();
  //calculate days difference by dividing total milliseconds in a day
  var days_difference = time_difference / (1000 * 60 * 60 * 24);
  return Math.ceil(days_difference);
}

// define alert functions
function showParkingReminder() {
  Swal.fire({
    title: "Reminder!",
    text: "if you still need extra time please click extend or you can cancel your reservation",
    
    confirmButtonText: "Extend",
    showCancelButton:true,
    cancelButtonText:"Cancel Reservation",
    cancelButtonColor: '#d33',

  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'You Chose Extend',
        showConfirmButton: false,
        timer: 1500
      })
    }
  })
}
function showBlockedMessage(blockEndDateString) {
  endDate = new Date(blockEndDateString);
  period = numberOfDays(endDate);
  Swal.fire({
    title: "Blocked",
    text: `Sorry you cannot reserve a parking till ${period} days.`,
    icon: "error",
    confirmButtonText: "Close",
    confirmButtonColor: "#d33",
  });
}
function showViolationMessage(userFirstName,blockEndDateString) {
  endDate = new Date(blockEndDateString);
  period = numberOfDays(endDate);
  Swal.fire({
    title: "Violations message",
    text: `Dear ${userFirstName},you are currently broke the rules of reservation and you will be able to reserve again after passing ${period} days.`,
    icon: "error",
    confirmButtonText: "Close",
    confirmButtonColor: "#d33",
  });
}


// define setup
function setup() {
  // get reference to button
  var btn = document.getElementById("test-button-1");
  // add event listener for the button, for action "click"
  btn.addEventListener("click", showParkingReminder);

  // get reference to button
  var btn2 = document.getElementById("test-button-2");
  // add event listener for the button, for action "click"
  btn2.addEventListener("click", function () {
    showBlockedMessage("10/6/2023");
  });

  // get reference to button
  var btn3 = document.getElementById("test-button-3");
  // add event listener for the button, for action "click"
  btn3.addEventListener("click", function () {
    showBlockedMessage("10/2/2023");
  });

   // get reference to button
   var btn4 = document.getElementById("test-button-4");
   // add event listener for the button, for action "click"
   btn4.addEventListener("click", function () {
     showViolationMessage("bayan","10/18/2023");
   });
}

function getBlockedUntil(){

  return "10/20/2023"
}

// NOTE: we wrap the function inside another function if we want to pass values to the inner function
// without accedentily calling it
// window.onload = function () {
//     setup(1,2,3);
// };

// NOTE: this is wrong becuase we are giving it the result of the call to the function
// window.onload = setup();
window.onload = setup;

// const buttons = document.querySelectorAll(".btn");
//   buttons.forEach(function (button) {
//     button.addEventListener("click", function (event) {
//       // do something when the button is clicked
//     //   alert(event)
//       alert("You clicked a button with a value of "+event.target.value);
//     });
//   });

//   run a check if there is any notification
  // setInterval(function () {
  //   // run the checks
  //   Swal.fire({
  //     position: "top-end",
  //     icon: "success",
  //     title: "Your work has been saved",
  //     showConfirmButton: false,
  //     timer: 1500,
  //   });
  // }, 5000);
