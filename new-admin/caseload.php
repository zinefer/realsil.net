<?php include('include/auth.php'); ?>
<?php include('include/functions.php'); ?>
<?php include('include/formfunctions.php'); ?>

<?php include('template/metaheader.php'); ?>
<body>
	<div id="container">
	
		<?php include('template/header.php'); ?>
		<?php include('template/leftnav.php'); ?>
		<?php if (isset($_SESSION['clientName'])) include('template/rightnav.php'); ?>
		
		<div id="content" <?php if (!isset($_SESSION['clientName'])) echo 'style="margin-right: 0; border-right: none;"'; ?> > 
			<?php
			if ($_GET['action']=='add') 
			{
				?>
				<h2>Add client to Case Load:</h2>
				<form action="caseload.php" method="get"> 
					<input type="text" maxlength=64 name="search" value=""/><input type="submit" value="Search" />
				</form> 
				<?php
			}else if($_GET['search'])
			{
				DisplayClientProfile(null, $_GET['search']);
			}else if($_GET['add']) 
			{
				AddClientToCL($_GET['add'], $_SESSION['userkey'], null);
			}else if($_GET['action']=='create') 
			{
			
				if($_SERVER['REQUEST_METHOD'] == "POST")
				{
					$uid = uniqid();
					if (checkdate($_POST['m'],$_POST['d'],$_POST['y'])) 
					{
						$date = $_POST['y'].'-'.$_POST['m'].'-'.$_POST['d'];
						mysql_query("INSERT INTO `clients` (`Key`, `First Name`, `Last Name`, `File Location`, `DOB`) VALUES (NULL, '".mysql_real_escape_string($_POST['FName'])."', '".mysql_real_escape_string($_POST['LName'])."', '".$uid."', '".$date."');");
						CreateClientFiles($uid);
						if ($_POST['CaseLoad'])
						{
							$clientkey = mysql_insert_id();
							if ($clientkey != 0 && $clientkey != false) {
								AddClientToCL($clientkey, $_SESSION['userkey'], null);
							}else{
								echo '<p>Error adding client to case load.</p>';
							}
						}
					}else{
						echo '<p>Invalied DOB</p>';
					}
				}else{
				?>
					<h2>Create Client</h2>
					<table cellspacing=3> 
						<form action="caseload.php?action=create" method="post"> 
							<tr><td>First Name:</td><td><input type="text" maxlength=32 name="FName" value=""/></td></tr> 
							<tr><td>Last Name:</td><td><input type="text" maxlength=32 name="LName" value=""/></td></tr> 
							<tr><td>Date of Birth:</td><td><?php selectDate(0,0,0,'d','m','y',date('Y')-25,date('Y')); ?></td></tr> 
							<tr><td>Edit Demographic?</td><td><input disabled type="checkbox" name="Demographic" /></td></tr> 
							<tr><td>Add to Case Load?</td><td><input type="checkbox" name="CaseLoad"  /></td></tr> 
							<tr><td></td><td align=right><input type="submit" value="Submit" /></td></tr> 
						</form> 
					</table> 
				<?php 
				}
			}else{
				ShowCaseLoad($_SESSION['userkey']);
			}
			?>
		</div>   
		
	</div>
	<?php include('template/footer.php'); ?>
</body>
</html>