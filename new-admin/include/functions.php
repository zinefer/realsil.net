<?php

function ShowCaseLoad($workerkey)
{
	if ($workerkey)
	{
		echo '<h2>Case Load</h2>';
		$caseloadresult = mysql_query("SELECT * FROM `caseloads` where `Worker` = '" . mysql_real_escape_string($workerkey) . "';");
		if ($caseloadresult) 
		{
			if (mysql_num_rows($caseloadresult)!=0)
			{
				while ($row = mysql_fetch_array($caseloadresult, MYSQL_ASSOC)) 
				{
					echo '<a href="?client='.$row['Client'].'">'.$row['Client Name'].'</a><br/>';
				}
			}else{
				echo '<p>Your case load is empty.</p>';
			}
		}else{
			echo '<p>Error</p>';
		}
		echo '<br/><a href="caseload.php?action=add">Add client to case load</a>';
	}else{
		return;
	}
}

function CreateClientFiles($uniqueloc) 
{
	mkdir("clientfiles/".$uniqueloc);	
}

function GetMugShot($clientfileloc) 
{
	if (file_exists('clientfiles/'.$clientfileloc.'/mug.jpg')){
		return 'clientfiles/'.$clientfileloc.'/mug.jpg';
	}else{
		return 'img/anon.gif';
	}
}

function DisplayClientProfile($clientkey=null, $searchname) 
{
	if ($searchname) 
	{
		$names = explode(" ", $searchname);
		$clientresult = mysql_query("SELECT `Key`, `First Name`, `Last Name`, `File Location`, `DOB`, `SIL Entry Date` FROM `clients` WHERE `First Name` = '".mysql_real_escape_string($names[0])."' AND `Last Name` = '".mysql_real_escape_string($names[1])."' LIMIT 1;");
		if (mysql_num_rows($clientresult)!=0) 
		{
			$client = mysql_fetch_row($clientresult);
			$img = GetMugShot($client[3]);
			echo '<img class="mugImage" src="'.$img.'" ALIGN=LEFT>
				<h2>'.$client[1].' '.$client[2].'</h2>
				<p>DOB: '.$client[4].'</p>
				<form action="caseload.php" method="get"> 
					<input type="hidden" maxlength=64 name="add" value="'.$client[0].'"/>
					<br/><br/><br/>
					<input type="submit" value="Add to case load" />
				</form>';
			//echo $client[2];
		}else{
			echo '<p>Client not found</p><br/>
				<a href="caseload.php?action=create">Create Client</a><br/>
				<a href="caseload.php?action=add">Search again</a>';
		}
	}else if ($clientkey) 
	{
		//TODO: Display by key
	}else{
		echo 'Error';
	}
}

function CaseLoadCheck($clientkey, $workerkey) 
{
	if ($clientkey && $workerkey)
	{
		$clresult = mysql_query("SELECT * FROM `caseloads` where `Worker` = '".mysql_real_escape_string($workerkey)."' AND `Client`='".mysql_real_escape_string($clientkey)."';");
		if (mysql_num_rows($clresult) == 0) 
		{
			return false; //Is not in case load
		}else{
			return true; //Is in case load
		}
	}else{
		return 'Error';
	}
}

function AddClientToCL($clientkey, $workerkey, $searchname = null) 
{
	if ($searchname) 
	{
		//TODO: add by search
	}else if ($clientkey) {
		$clcheck = CaseLoadCheck($clientkey, $workerkey);
		if ($clcheck == false) 
		{
			$clientresult = mysql_query("SELECT `First Name`, `Last Name` FROM `clients` WHERE `Key` = '".mysql_real_escape_string($clientkey)."' LIMIT 1;");
			if (mysql_num_rows($clientresult) != 0) 
			{
				$client = mysql_fetch_row($clientresult);
				mysql_query("INSERT INTO `caseloads` (`Worker`, `Client`, `Client Name`) VALUES ('".mysql_real_escape_string($workerkey)."', '".mysql_real_escape_string($clientkey)."', '".$client[0].' '.$client[1]."');");
				ShowCaseLoad($_SESSION['userkey']);
			}else{
				echo '<p>Client doesn\'t exist.<p>';
			}
		}else if ($clcheck == true) 
		{
			echo '<p>Client is already in your case load.</p>';
		}else if ($clcheck == 'Error') 
		{
			echo '<p>Error.</p>';
		}
	}
}

function ShowClientIndex ($clientkey, $clientname) 
{
	if ($clientkey && $clientname) 
	{
		echo '<h2>'.$clientname.'</h2>';
		?>
		<a href="casenotes.php">Case Notes</a><br/>
		<a href="#">Demographic</a><br/>
		<a href="#">Upload New Picture</a><br/>
		<?php
	}
}

function ShowCaseNoteForm($contacting = null)
{
	?>
	<table cellspacing=3>
	<form action="casenotes.php?insert=true" method="post" name="CaseNote">
		<tr><td>Date:</td><td><input type="text" value="<?php echo date('Y-m-d'); ?>" name="SelectedDate" id="SelectedDate"></td><td></td></tr>
		<tr><td>Type:</td><td><select name="Type"><option value="In Person">In Person</option><option value="Phone">Phone</option><option value="Email">Email</option><option value="Fax">Fax</option><option value="Text">Text</option></select></td><td></td></tr>
		<tr><td>Person Contacting:</td><td><input type="text" maxlength=32 name="Contactor" value="<?php echo $contacting; ?>"/></td><td rowspan=2><a href="#" onclick="a = document.CaseNote.Contactor.value; document.CaseNote.Contactor.value = document.CaseNote.Contactee.value; document.CaseNote.Contactee.value = a;"><img src="img/flip.gif"/></a></td></tr>
		<tr><td>Person Contacted:</td><td><input type="text" maxlength=32 name="Contactee" value=""/></td></tr>
		<tr><td>Subject:</td><td><input maxlength=255 type="text" name="Subject" value=""/></td><td></td></tr>
		<tr><td valign=top>Comment:</td><td colspan=2><textarea name="Comment" rows="8" cols="25"></textarea></td></tr>
		<tr><td></td><td align=right><input type="submit" value="Submit" /></td><td></td></tr>
	</form>
	</table>
	<?php
}
function RetrieveWorkers() {  
		$result = mysql_query("SELECT `Key`, `Name` FROM `workers`");
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$arr[$row["Key"]] = $row["Name"];
		}
		mysql_free_result($result);
		return $arr;
	} 