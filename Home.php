<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: home.php");
  exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
?>
<?php


require_once 'db_connect.php';//bring the database connection file in
if(isset($_POST['submit'])) {
    $title = $_POST['todoTitle'];// grap what was filled in title field
    $description = $_POST['todoDescription']; //grap what was filled in description field

    // check strings
    function check($string){
        $string  = htmlspecialchars($string);
        $string = strip_tags($string);
        $string = trim($string);
        $string = stripslashes($string);
        return $string;
    }

    // check for empty title
    if(empty($title)){
        $error  = true;
        $titleErrorMsg = "Title cannot be empty";
    }
    // check for empty description
    if(empty($description)){
        $error = true;
        $descriptionErrorMsg = "Description cannot be empty";
    }

    // connect to database
    db();
    global $link;
    $query = "INSERT INTO todo(todoTitle, todoDescription, date) VALUES ('$title', '$description', now() )";
    $insertTodo = mysqli_query($link, $query);
    if($insertTodo){
        echo "You added a new todo";
    }else{
        echo mysqli_error($link);
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
</head>
<body>
  <h1>Create Todo List/Notes</h1>
<button type="submit"><a href="index1.php">View all Todo</a></button>
<form method="post" action="home.php">
    <p>Todo title: </p>
    <input name="todoTitle" type="text">
    <p>Todo description: </p>
    <input name="todoDescription" type="text">
    <br>
    <input type="submit" name="submit" value="submit">
</form>
<footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge">
  <p> <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></p>
</footer>
   
    
</body>

</html>
<?php ob_end_flush(); ?>