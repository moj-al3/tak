<?php
  $servername="locahost";
  $username="root";
  $password="";
  $DBname="Tarkeen";

//    Create    connection
$conn = mysqli_connect('localhost','root','','Tarkeen') ;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 


?>


<?php
// #login 
if (isset($_POST['user_id']) && isset($_POST['password'])){

  function validate($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  $user_id = validate($_POST['user_id']);
  $password = validate($_POST['password']);

  // Further code logic goes here

}
  $uers_id = vaildate($_POST['user_id']);
  $password= vaildate($_POST['password'])
  if (empty($user_id)) {
    header('Location: index.php?error=User id is required');
    exit();
}
  else if (empty ($password)){
    header('Location:index.php erro= pasword  is requried ');
    exit();
  } 
  $sql ="SELECT *FROM uesrs WHERE user_id='$uers_id' AND pasword='$password' ";
  $result = mysqli_fetch_assoc($result); // ما ادري ليش كتبناه 
  if (mysqli_num_row($result)==1){
    $row =sqli_fetch_assoc($result);
    if ($row ['user_id']===$user_id && $row ['password']===$pass){
        echo 'Logged In!';
        $_SESSION['user_id ']=$row ['uer_name'];
        $_SESSION['first_name']=$row['first_name'];
        header ('Location :home.php');
        exit(); 


    }
    else{
        header(' Location: indesx.php?error=Incorrect User id or pasword ')
    }
    else{
        header('Location : index.php')//  ما ادري شنو index php
    }
  }
?>


<?php
//log out
session_start():

session_unset();
session_destroy();

header("Location:index.php")
?>








