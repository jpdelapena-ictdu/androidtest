<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<form action="function/regis.php" method="POST">
		<input type="text" value="0123" name="username">
		<input type="text" value="Admin" name="firstname">
		<input type="text" value="Admin" name="lastname">
		<input type="text" value="D" name="middlename">
		<input type="text" value="pass" name="password">
		<input type="submit" value="Submit">
	</form>
<br/>
<p>Login</p>
	<form action="function/userLogin.php" method="POST">
		<input type="text" value="01180001" name="username">
		<input type="text" value="abcd123456" name="password">
		<input type="submit" value="Submit">
	</form>
<p>section</p>
	<form action="function/userSection.php" method="GET">
		<input type="text" value="01180001" name="username">
		<input type="submit" value="Submit">
	</form>

<p>profile</p>
	<form action="function/userProfile.php" method="GET">
		<input type="text" value="01180001" name="username">
		<input type="submit" value="Submit">
	</form>


<p>profile</p>
	<form action="function/userGrade.php" method="GET">
		<input type="text" value="01180001" name="username">
		<input type="text" value="1" name="section_id">
		
		<input type="submit" value="Submit">
	</form>
<p>profile</p>

	<form action="function/newsFeed.php" method="GET">
		<input type="text" value="01180001" name="username">
		
		<input type="submit" value="Submit">
	</form>

<p>Timestamp</p>
	<form action="function/adminPostNews.php" method="POST" enctype="multipart/form-data">
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>