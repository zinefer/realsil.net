<?
session_set_cookie_params(604800, '/',  '.realsil.net', false, true);
session_start();
setcookie(session_name(),session_id(),time()+60*15);


$con = mysql_connect("localhost","zinefer_rsil","7c7=K)ug=Usv");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("zinefer_rsil", $con);


if(isset($_POST['user']) && isset($_POST['pass']))
{
	$user = mysql_real_escape_string($_POST['user']);
	
	$selectUser = mysql_query("SELECT * FROM `workers` where `User` = '{$user}' Limit 1");
	$userRow = mysql_fetch_assoc($selectUser);
	
	$pass = md5(mysql_real_escape_string($_POST['pass'].$userRow['Salt']));
	//////$pass = mysql_real_escape_string($_POST['pass']);
	
	if($pass == $userRow['Password'])
	{			
		$cookie_hash = md5(md5($userRow['Password'].$userRow['salt']).$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
		setcookie('worker_password',$cookie_hash,time()+60*15,'/','realsil.net');
		
		$_SESSION['pass'] = $pass;
		$_SESSION['user'] = $user;
		$_SESSION['userkey'] = $userRow['Key'];		
		
		header("location: index.php");
	}else{
		echo 'Incorrect login credentials';
	}
}


include('template/metaheader.php'); ?>
<body>
	<div id="container">
	
		<? include('template/header.php'); ?>
		<? include('template/leftnav.php'); ?>
		<div id="right" style="display:none;"></div> 
		
		<div id="content" style="border-right:none"> 
			<div style="width:300px;">
				<form action="login.php" method="post">
				<h1>Login</h1>
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="user" /></td>
					</tr>
					<tr>	
						<td>Password:</td>
						<td><input type="password" name="pass" /></td>
					</tr>
					<tr>
						<td colspan=2 align=right><input type="submit" value="Submit" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>   
		
	</div>
	<? include('template/footer.php'); ?>
</body>
</html>