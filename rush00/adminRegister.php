<?php
session_start();

if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
	header('Location: admin.php');
	exit();
 }

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
	header('Location: index.php');
	exit();
}
include('./partial/header.php');
?>
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Admin register</h1>
        <form action="controller/admin.php" method="POST">
			<input type="text" placeholder="first name" name=fname value="">
			<input type="text" placeholder="last name" name=lname value="">
			<input type="password" placeholder="passwd(*)" name=passwd value="">
			<input type="email" placeholder="email(*)" name=email value="">
            <button type="submit" class="btn btn-default">Register Admin</button>
            <input type="hidden" name="from" value="adminRegister">
            <input type="hidden" name="admin" value="true">
            <input type="hidden" name="success" value="admin">
        </form>
    </div>
<?php include('./partial/footer.php')?>
