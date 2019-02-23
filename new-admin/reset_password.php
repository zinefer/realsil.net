<?php 
	include('include/auth.php'); 
	include('include/functions.php'); 

	$msg=' ';
	
	if(isset($_POST['submit']))
	{	include('include/authorize.php');
		//create a new salt
		$salt = '';
		for ($i = 0; $i <= 3; $i++)
		{$salt .= chr(rand(33, 126)); }
		
		$pass = md5(mysql_real_escape_string($_POST['pass'].$salt));;
		
		
		if(preg_match($authorize['worker_password'], $_POST['pass']))
		{
			$update = "UPDATE  `workers` SET  `Password` =  '{$pass}', `Salt` = '{$salt}', PasswordExpires = DATE_ADD(CURDATE(),INTERVAL 30 DAY) WHERE  `workers`.`Key`={$_SESSION['userkey']};";
			mysql_query($update);
			
			unset($_SESSION['password_expired']);
			$msg .= "Password successfully changed.";
		}else{
			$msg .= $authorize_error['worker_password'].'<br/>';
		}
	}
	
?>

<?php include('template/metaheader.php'); ?>
<body>
	<div id="container">
	
		<?php include('template/header.php'); ?>
		<?php include('template/leftnav.php'); ?>
		
		<div id="content"> 
			<p>Your password is expired. You must change it to continue.</p>
			<p><b><?=$msg?></b></p>
		
			<form method='post'>
			<table>
				<tr>	
					<td>Password:</td>
					<td><input type="password" name="pass" /></td>
				</tr>
				<tr>
					<td colspan=2 align=right><input type="submit" name='submit' value="Submit" /></td>
				</tr>
			</table>
			</form>
		</div>   
		
	</div>
	<?php include('template/footer.php'); ?>
</body>
</html>