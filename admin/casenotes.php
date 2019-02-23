<?php 
include('include/auth.php'); ?>
<?php include('include/functions.php'); ?>

<?php include('template/metaheader.php'); ?>
<body>
	<div id="container">
	
		<?php include('template/header.php'); ?>
		<?php include('template/leftnav.php'); ?>
		<?php if (isset($_SESSION['clientName'])) include('template/rightnav.php'); ?>
		
		<div id="content" <?php if (!isset($_SESSION['clientName'])) echo 'style="margin-right: 0; border-right: none;"'; ?> > 
			<?php 
				ShowCaseNoteForm($userRow['Name']); 
			?>
			<br/><hr/><br/>
			<?php
				if (isset($_SESSION['clientName'])) {
					if($_SERVER['REQUEST_METHOD'] == "POST")
					{
						if (!mysql_query("INSERT INTO `casenotes` (`Key`, `Client`, `Creator`, `Date`, `Contactee`, `Contactor`, `Subject`, `Comment`, `Type`) VALUES (NULL, '".mysql_real_escape_string($_SESSION['client'])."', '".mysql_real_escape_string($_SESSION['userkey'])."', '".mysql_real_escape_string($_POST['SelectedDate'])."', '".mysql_real_escape_string($_POST['Contactee'])."', '".mysql_real_escape_string($_POST['Contactor'])."', '".mysql_real_escape_string($_POST['Subject'])."', '".mysql_real_escape_string($_POST['Comment'])."', '".mysql_real_escape_string($_POST['Type'])."')"))
						{
							echo 'Error inputting case note';
						}
					}
					?>
					<table width=100% cellspacing=0 style="border-spacing: 3px 0;">
					<tr><th>Date</th><th>Added By</th><th>Person Contacted/Type of Contact</th><th width=50%>Subject</th></tr>
					<?php
						$casenotes = mysql_query("SELECT `casenotes`.*, `workers`.`Name` FROM `casenotes` JOIN `workers` ON (`Creator` = `workers`.`Key`) WHERE `Client` =".$_SESSION['client']." ORDER BY `casenotes`.`Date` DESC, `casenotes`.`Key` DESC");
						$i = 0;
						if ($casenotes)
						{
							while ($row = mysql_fetch_array($casenotes, MYSQL_ASSOC)) 
							{
								$i++;
								If ($row['Type'] == "Phone") 
								{
									$type = "Called";
								}elseif ($row['Type'] == "Email"){
									$type = "Emailed";
								}elseif ($row['Type'] == "Fax") {
									$type = "Faxxed";
								}elseif ($row['Type'] == "In Person") {
									$type = "Met With";
								}elseif ($row['Type'] == "Text") {
									$type = "Texted";
								}
								echo '<tr class="d'.($i & 1).'"><td><a href="casenote.php?note='.$row['Key'].'" onClick="window.open(this,\'Case_Notes\',\'width=385,height=425,scrollbars=no,location=no\'); return false;">'.$row['Date'].'</a></td><td>'. $row['Name'] .'</td><td>'.$row['Contactor'].' '.$type.' '.$row['Contactee'].'</td><td>'.$row['Subject'].'</td>';
							}
							mysql_free_result($casenotes);
						}
					?>
					</table>
					<?php
				}else{
					ShowCaseLoad($_SESSION['userkey']);	
				}
				?>
		</div>   
		
	</div>
	<?php include('template/footer.php'); ?>
</body>
</html>