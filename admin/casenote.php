<?php include('include/auth.php'); ?>
<?php include('include/functions.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<meta name="description" content="description"/>
	<meta name="keywords" content="keywords"/> 
	<meta name="author" content="author"/> 
	<link rel="stylesheet" type="text/css" href="popup.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="datepicker.css" media="screen"/>
	<title>CaseNote</title>
	<script language="JavaScript">
		function refreshParent() {
		  window.opener.location = window.opener.location;
		  window.close();
		}
	</script>
</head>
<body>
	<?php
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{			if (isset($_POST['delete'])){	$casenote = mysql_query("DELETE FROM `casenotes` WHERE `casenotes`.`Key` =".mysql_real_escape_string($_GET['note'])." LIMIT 1");			}			
			if ($_GET['note'])
			{
				$casenote = mysql_query("UPDATE `casenotes` SET `Creator` = '".mysql_real_escape_string($_POST['Worker'])."', `Date` ='".mysql_real_escape_string($_POST['SelectedDate'])."', `Contactee` ='".mysql_real_escape_string($_POST['Contactee'])."', `Contactor` ='".mysql_real_escape_string($_POST['Contactor'])."', `Subject` ='".mysql_real_escape_string($_POST['Subject'])."', `Comment` ='".mysql_real_escape_string($_POST['Comment'])."', `Type` ='".mysql_real_escape_string($_POST['Type'])."' WHERE `casenotes`.`Key` =".mysql_real_escape_string($_GET['note']));
			}else{
				echo 'Error updating Case Note.';
			}
			echo "<script language=javascript>refreshParent();</script>";
		}
		if ($_GET['note'])
		{
			$workers = RetrieveWorkers();
			$casenote = mysql_query("SELECT * FROM `casenotes` WHERE `Key`=".mysql_real_escape_string($_GET['note']));
			$note = mysql_fetch_row($casenote);
			if ($note)
			{ 
				if ($note[8] == "Phone") 
				{
					$type[0] = "Phone";
					$type[1] = "Email";
					$type[2] = "Fax";
					$type[3] = "In Person";
					$type[4] = "Text";
				}elseif ($note[8] == "Email"){
					$type[0] = "Email";
					$type[1] = "Phone";
					$type[2] = "Fax";
					$type[3] = "In Person";
					$type[4] = "Text";
				}elseif ($note[8] == "Fax"){
					$type[0] = "Fax";
					$type[1] = "Email";
					$type[2] = "Phone";
					$type[3] = "In Person";
					$type[4] = "Text";
				}elseif ($note[8] == "In Person"){
					$type[0] = "In Person";
					$type[1] = "Fax";
					$type[2] = "Email";
					$type[3] = "Phone";
					$type[4] = "Text";
				}elseif ($note[8] == "Text"){
					$type[0] = "Text";
					$type[1] = "Fax";
					$type[2] = "Email";
					$type[3] = "Phone";
					$type[4] = "In Person";
				}
				echo '<table cellspacing=3><form action="casenote.php?note='.$_GET['note'].'" method="post">';
				echo '<tr><td>Date:</td><td><input type="text" value="'.$note[3].'" name="SelectedDate" id="SelectedDate"></td></tr>';
				echo '<tr><td>Creator:</td><td><select name="Worker"><option value="'.$note[2].'">'.$workers[$note[2]].'</option></select></td></tr>';
				echo '<tr><td>Person Contacted/Type of Contact:</td><td><select name="Type"><option value="'.$type[0].'">'.$type[0].'</option><option value="'.$type[1].'">'.$type[1].'</option><option value="'.$type[2].'">'.$type[2].'</option><option value="'.$type[3].'">'.$type[3].'</option><option value="'.$type[4].'">'.$type[4].'</option></select></td></tr>';
				echo '<tr><td>Person Contacting:</td><td><input type="text" maxlength=32 name="Contactee" value="'.$note[4].'"/></td></tr>';
				echo '<tr><td>Person Contacted:</td><td><input type="text" maxlength=32 name="Contactor" value="'.$note[5].'"/></td></tr>';
				echo '<tr><td>Subject:</td><td><input maxlength=255 type="text" name="Subject" value="'.$note[6].'"/></td></tr>';
				echo '<tr><td valign=top>Comment:</td><td><textarea name="Comment" rows="8" cols="25">'.$note[7].'</textarea></td></tr>';
				echo '<tr><td></td><td align=right><input name="delete" type="submit" value="Delete" style="margin-right: 3px;"/><input type="button" value="Close" style="margin-right: 3px;" onClick="window.close();"/><input type="submit" value="Submit" /></td></tr>';
				echo '</form></table>';
			}else{
				echo '<p>Invalid Case ID</p>';
			}
		}else{
			echo '<p>Error</p>';
		}
	?>
</body>
</html>