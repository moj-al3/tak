<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");
if ($user["user_type_id"] != "2" && $user["user_type_id"] != "1") {
    die("Access Denied");
}


?>

<!DOCTYPE html>
<html>

<head>
<?php include "../snippets/layout/head.php" ?>
    <link rel="stylesheet" href="../assets/css/booking.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.21/dist/sweetalert2.min.css">

<style>
.time-reservation.selected {
    background-color: #FF0050;
}
</style>
    <title>Create Reservation</title>
</head>

<body>
<?php include "../snippets/layout/header.php" ?>
    <div id="content" class="container">
        <div class="spot-container">
            <label>Pick a flour:</label>
            <select id="flour">
                <option value="flour1">flour1</option>
                <option value="flour2">flour2</option>
                <option value="flour3">flour3</option>
            </select>
            <label>Choose car :</label>
            <select id="car">
                <option value="car1">car1</option>
                <option value="car2">car2</option>
            </select>
        </div>
        <ul class="showcase">
            <li>
                <div class="spot"></div>
                <small>Available</small>
            </li>
            <li>
                <div class="spot selected"></div>
                <small>Reserved</small>
            </li>
        </ul>

        <div class="row-container">
            <div class="row">
                <div class="spot available"><h6>A1</h6></div>
                <div class="spot available"><h6>A2</h6></div>
                <div class="spot available"><h6>A3</h6></div>
                <div class="spot available"><h6>A4</h6></div>
                <div class="spot available"><h6>A5</h6></div>
                <div class="spot available"><h6>A6</h6></div>
                <div class="spot available"><h6>A7</h6></div>
                <div class="spot available"><h6>A8</h6></div>
                <div class="spot available"><h6>A9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>B1</h6></div>
                <div class="spot available"><h6>B2</h6></div>
                <div class="spot available"><h6>B3</h6></div>
                <div class="spot available"><h6>B4</h6></div>
                <div class="spot available"><h6>B5</h6></div>
                <div class="spot available"><h6>B6</h6></div>
                <div class="spot available"><h6>B7</h6></div>
                <div class="spot available"><h6>B8</h6></div>
                <div class="spot available"><h6>B9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>C1</h6></div>
                <div class="spot available"><h6>C2</h6></div>
                <div class="spot available"><h6>C3</h6></div>
                <div class="spot available"><h6>C4</h6></div>
                <div class="spot available"><h6>C5</h6></div>
                <div class="spot available"><h6>C6</h6></div>
                <div class="spot available"><h6>C7</h6></div>
                <div class="spot available"><h6>C8</h6></div>
                <div class="spot available"><h6>C9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>D1</h6></div>
                <div class="spot available"><h6>D2</h6></div>
                <div class="spot available"><h6>D3</h6></div>
                <div class="spot available"><h6>D4</h6></div>
                <div class="spot available"><h6>D5</h6></div>
                <div class="spot available"><h6>D6</h6></div>
                <div class="spot available"><h6>D7</h6></div>
                <div class="spot available"><h6>D8</h6></div>
                <div class="spot available"><h6>D9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>E1</h6></div>
                <div class="spot available"><h6>E2</h6></div>
                <div class="spot available"><h6>E3</h6></div>
                <div class="spot available"><h6>E4</h6></div>
                <div class="spot available"><h6>E5</h6></div>
                <div class="spot available"><h6>E6</h6></div>
                <div class="spot available"><h6>E7</h6></div>
                <div class="spot available"><h6>E8</h6></div>
                <div class="spot available"><h6>E9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>G1</h6></div>
                <div class="spot available"><h6>G2</h6></div>
                <div class="spot available"><h6>G3</h6></div>
                <div class="spot available"><h6>G4</h6></div>
                <div class="spot available"><h6>G5</h6></div>
                <div class="spot available"><h6>G6</h6></div>
                <div class="spot available"><h6>G7</h6></div>
                <div class="spot available"><h6>G8</h6></div>
                <div class="spot available"><h6>G9</h6></div>
            </div>
            <div class="row">
                <div class="spot available"><h6>F1</h6></div>
                <div class="spot available"><h6>F2</h6></div>
                <div class="spot available"><h6>F3</h6></div>
                <div class="spot available"><h6>F4</h6></div>
                <div class="spot available"><h6>F5</h6></div>
                <div class="spot available"><h6>F6</h6></div>
                <div class="spot available"><h6>F7</h6></div>
                <div class="spot available"><h6>F8</h6></div>
                <div class="spot available"><h6>F9</h6></div>
            </div>
        </div>
        <div class="time-selection">
            <button  class="time-reservation ">1 hour</button>
            <button class="time-reservation ">2 hours</button>
            <button class="time-reservation ">3 hours</button>
        </div>
        <script>
        const buttons = document.querySelectorAll('.time-reservation');

        buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the "selected" class from all buttons
            buttons.forEach(b => {
                b.classList.remove('selected');
            });
            // Add the "selected" class to the clicked button
            button.classList.add('selected');
        });
    });
         </script>
        
        <div class="reserve-btn">
            <button class="rserve" type="button" onclick="window.location.href = '../reservations/show.php'">Reserve</button>
        </div>
        <div class="switch-btn">
        <button id="switchButton">Switch</button>

        </div>

    </div>
    <script>
        const rowContainer = document.querySelector('.row-container');
        const spotSelect = document.getElementById('flour');
        const spots = document.querySelectorAll('.spot.available');

        let selectedSpot = null;
        
        
        // spot select event
        spotSelect.addEventListener('change', () => {
            if (selectedSpot) {
                selectedSpot.classList.remove('selected');
                selectedSpot = null;
            }
        });
        
        // spot click event
        rowContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('spot') && e.target.classList.contains('available')) {
                if (selectedSpot) {
                    selectedSpot.classList.remove('selected');
                }

                e.target.classList.add('selected');
                selectedSpot = e.target;
            }
        });
    </script>
    <script>
document.getElementById('switchButton').addEventListener('click', () => {
  // Show the first SweetAlert with input fields and a checkbox
  Swal.fire({
    title: 'Switch Spot',
    html: `
      <input type="text" id="input1" class="swal2-input" placeholder="Previous Spot">
      <input type="text" id="input2" class="swal2-input" placeholder="New Spot">
      <input type="checkbox" id="securityViolation"> I implement the Violation
    `,
    customClass: {
      confirmButton: 'swal2-button',
      cancelButton: 'swal2-button',
      input: 'swal2-input',
    },
    showCancelButton: true,
    confirmButtonText: 'switch',
    showLoaderOnConfirm: true,
    preConfirm: () => {
      const value1 = document.getElementById('input1').value;
      const value2 = document.getElementById('input2').value;
      const securityViolation = document.getElementById('securityViolation').checked;

      if (!value1 || !value2) {
        Swal.showValidationMessage('Both fields are required');
        return false;
      }

      if (!securityViolation) {
        Swal.showValidationMessage('Please confirm the implementing violation');
        return false;
      }

      // Simulate an switch operation here (you can replace this with your actual switch logic)
      return new Promise((resolve) => {
        setTimeout(() => {
          // Simulate success
          resolve();

          // Show the second SweetAlert confirming the successful switch
          Swal.fire('Success', 'Spot switchd successfully', 'success');
        }, 2000); // You can adjust the timeout as needed
      });
    },
  });
});
</script>
    <?php include "../snippets/layout/footer.php" ?>
    <script src="../assets/js/header.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>


</body>

</html>