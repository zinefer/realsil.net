		<div id="right"> 
			<h2 class="navHead">Current Client</h2>
			<ul>
				<li class="listHead"><?php echo $_SESSION['clientName']; ?></li>
				<li><img name="mug" class="mugImage" src="<?php echo GetMugShot($_SESSION['clientFileLocation']); ?>"/></li>
				<!--<li><strong>Reminder:</strong> John Doe's picture is outdated or missing!</li>-->
				<li><a href="mugupload.php">Upload a new picture</a></li>
			</ul>
			<a href="?client=clear" style="float:right; padding-right:10px;">Close</a>
		</div> 
		