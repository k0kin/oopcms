<?php require_once("init.php"); ?>
<?php 

if ($session->isSignedIn()) 
{
	redirect("index.php");
}

if(isset($_POST['submit']))
{
	$username = trim($_POST['username']); 
	$password = trim($_POST['password']);
}

?>