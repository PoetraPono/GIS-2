<html>
 <body>
	<form method="POST" action="<?php echo $base_url; ?>index.php/main/login/1">
		Username: <input type="text" name="UE" size="15" maxlength="5" /><br />
		Password: <input type="password" name="PSW" maxlength="150" size="15" /><br />
		<button type="submit" value="Reset">Login</button>
		<button type="reset" value="Reset">Reset</button>
	</form>
 </body>
</html>