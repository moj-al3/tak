<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Feedback Ui Design</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/index.css">



</head>

<body>
  <?php require "base.php" ?>
  <div id="content" class="container">
    <div id="panel" class="panel-container">
      <strong>Your feedback will help us to improve. <br>
      </strong>
      <div class="ratings-container">

        <div class="rating">
          <img src="" alt="">
          <small>Unhappy</small>
        </div>

        <div class="rating">
          <img src="" alt="">
          <small>Neutral</small>
        </div>

        <div class=" rating active">
          <img src="" alt="">
          <small>Satisfied</small>
        </div>

      </div>
      <button class="rating-btn" id="send">Send Review</button>
    </div>
  </div>

  <script src="/assets/js/index.js"></script>
</body>

</html>