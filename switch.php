<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.21/dist/sweetalert2.min.css">
</head>
<body>
 
  <script src="assets/js/sweetalert2.all.min.js"></script>

</body>
<script>
document.getElementById('switchButton').addEventListener('click', () => {
  // Show the first SweetAlert with input fields and a checkbox
  Swal.fire({
    title: 'Switch Spot',
    html: `
      <input type="text" id="input1" class="swal2-input" placeholder="Previous Spot">
      <input type="text" id="input2" class="swal2-input" placeholder="New Spot"> <br><br>
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
</html>
