<?php 

if(isset($_POST['submit'])) {

   include "db_conn.php";

   $fname = $_POST['fname'];
   $uname = $_POST['uname'];
   $pass = $_POST['pass'];

   $data = "fname=".$fname."&uname=".$uname;
    
   if (empty($fname)) {
    	$em = "Full name is required";
    	header("Location:register.php?error=$em&$data");
	   exit;
   } else if (empty($uname)){
    	$em = "Username is required";
    	header("Location:register.php?error=$em&$data");
	   exit;
   } else if (empty($pass)){
    	$em = "Password is required";
    	header("Location:register.php?error=$em&$data");
	   exit;
   }
   
   if (!file_exists($_FILES['pp']['tmp_name']) || !is_uploaded_file($_FILES['pp']['tmp_name'])) {
      $em = "Profile picture is required";
      header("Location:register.php?error=$em&$data");
	   exit;
   } else {

      $img = $_FILES['pp'];
      $img_name = $_FILES['pp']['name'];
      $tmp_name = $_FILES['pp']['tmp_name'];
      $img_size = $_FILES['pp']['size'];
      $error = $_FILES['pp']['error'];

      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_to_lc = strtolower($img_ex);

      $allowed_exs = array('jpg', 'jpeg', 'png');

      if (in_array($img_ex_to_lc, $allowed_exs)) {
         if($error === 0) {
            if($img_size < 10485760) { //file size must be < 10MB
               $new_img_name = uniqid($uname).'.'.$img_ex_to_lc;
               $img_upload_path = '../upload/'. $new_img_name;

               move_uploaded_file($tmp_name, $img_upload_path);
            }
         }

         // hashing the password
         $pass = password_hash($pass, PASSWORD_DEFAULT);

         // Insert into Database
         $sql = "INSERT INTO users(fname, username, password, pp) VALUES(?,?,?,?)";
         $stmt = $conn->prepare($sql);
         $stmt->execute([$fname, $uname, $pass, $new_img_name]);

         header("Location:register.php?success=Your account has been created successfully");
         exit;
      } else {
         $em = "You can't upload files of this type";
         header("Location:register.php?error=$em&$data");
         exit;
      }
   }

} else {
	header("Location:register.php?error=Something went wrong!");
	exit;
}