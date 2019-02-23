<?php include('include/auth.php'); ?>
<?php include('include/functions.php'); ?>

<?php include('template/metaheader.php'); ?>
<body>
	<div id="container">
	
		<?php include('template/header.php'); ?>
		<?php include('template/leftnav.php'); ?>
		<?php if (isset($_SESSION['clientName'])) include('template/rightnav.php'); ?>
		
		<div id="content" <?php if (!isset($_SESSION['clientName'])) echo 'style="margin-right: 0; border-right: none;"'; ?> > 
			<?php
			if (!isset($_SESSION['clientName']))
			{
				ShowCaseLoad($_SESSION['userkey']);	
			}else{
				ShowClientIndex($_SESSION['client'], $_SESSION['clientName']);	
			}
			?>
		</div>   
		
	</div>
	<?php include('template/footer.php'); ?>
</body>
</html>