<?php include('include/auth.php'); ?>
<?php include('include/functions.php'); ?>

<?php

	if($_GET['image']) 
	{
		// get variables
		$imgfile = $_GET['image'];
		$cropStartX = $_GET['cropStartX'];
		$cropStartY = $_GET['cropStartY'];
		$cropW = $_GET['cropWidth'];
		$cropH = $_GET['cropHeight'];
		
		/*echo $imgfile;
		echo $cropStartX;
		echo $cropStartY;
		echo $cropW;
		echo $cropH;*/
		

		// Create two images
		$origimg = imagecreatefromjpeg($imgfile);
		$cropimg = imagecreatetruecolor(143,180);

		// Get the original size
		list($width, $height) = getimagesize($imgfile);

		// Crop
		imagecopyresized($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, 143, 180, $cropW, $cropH);

		// force download nes image
		//header("Content-type: image/jpeg");
		//header('Content-Disposition: attachment; filename="'.$imgfile.'"');
		imagejpeg($cropimg, "clientfiles/".$_SESSION['clientFileLocation']."/mug.jpg");
		
		//unlink( $_GET['image']);

		// destroy the images
		imagedestroy($cropimg);
		imagedestroy($origimg);
		
		die();
	}else if(!empty($_FILES["uploadImage"])) {
  		// get file name
		$filename = basename($_FILES['uploadImage']['name']);
		
		// get extension
  		$ext = substr($filename, strrpos($filename, '.') + 1);
  		
  		// check for jpg only
  		if ($ext == "jpg") {
      		// generate unique file name
  			$newName = 'clientfiles/temp/'.time().'.'.$ext;
  			
  			// upload files
        	if ((move_uploaded_file($_FILES['uploadImage']['tmp_name'], $newName))) {
			
        		// get height and width for image uploaded
        		list($width, $height) = getimagesize($newName);
        		
        		// return json data
           		echo '{"image" : "'.$newName.'", "height" : "'.$height.'", "width" : "'.$width.'" }';
				die();
        	}
        	else {
           		echo '{"error" : "An error occurred while moving the files"}';
        	}
  		} 
  		else {
     		echo '{"error" : "Invalid image format"}';
  		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>REAL Independent Living Program</title>
		<!-- css -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.2/build/resize/assets/skins/sam/resize.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.5.2/build/imagecropper/assets/skins/sam/imagecropper.css" />
		<!-- js -->
		<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.5.2/build/yahoo-dom-event/yahoo-dom-event.js&2.5.2/build/dragdrop/dragdrop-min.js&2.5.2/build/element/element-beta-min.js&2.5.2/build/resize/resize-beta-min.js&2.5.2/build/imagecropper/imagecropper-beta-min.js&2.5.2/build/connection/connection-min.js&2.5.2/build/json/json-min.js"></script>
		<script type="text/javascript" src="include/jquery.js"></script>
		<style type="text/css">			
			#hd{
				font-size: 2em;
				font-weight: bold;
				text-align: left;
				padding-bottom: 20px;
				border-bottom: 1px solid #ccc;
				margin: 10px 10px 10px 0;
			}
			
			#uploadForm{
				text-align: center;
			}
			
			#saveButton {
				display:block;
				margin:0 auto;
				visibility: hidden;
			}
			
			#imageContainer{
				margin: 20px 0px 20px 0;
			}
			
			#loader {
				position: absolute;
				background-image:url(img/loader.gif);
				background-repeat:no-repeat;
				background-position: center center;
				height:100px;
				width:100px;
				left:50%;
				top:50%;
				visibility:hidden;
			}
		</style>
		<script type="text/javascript">
			var url = "";
			uploader = {
				carry: function(){
					document.getElementById('uploadButton').value='Uploading';
					// set form
					YAHOO.util.Connect.setForm('uploadForm', true);
					// upload image
					YAHOO.util.Connect.asyncRequest('POST', 'mugupload.php', {
						upload: function(o){
							// parse our json data
							var jsonData = YAHOO.lang.JSON.parse(o.responseText);
							
							// put image in our image container
							YAHOO.util.Dom.get('imageContainer').innerHTML = '<img id="yuiImg" src="' + jsonData.image + '" width="' + jsonData.width + '" height="' + jsonData.height + '" alt="" />';
							
							// init our photoshop
							photoshop.init(jsonData.image); 
							
							// get first cropped image
							photoshop.getCroppedImage();
						}
					});
				}
			};
						
			photoshop = {
				image: null,
				crop: null,
				//url: null,
				
				init: function(image){
					// set our image
					photoshop.image = image;
					
					// our image cropper from the uploaded image
					photoshop.crop = new YAHOO.widget.ImageCropper('yuiImg', { 
						initialXY: [20, 20], 
						minHeight: 180,
						minWidth: 143,
						initHeight: 180,
						initWidth: 143,
						ratio: true,
						keyTick: 5, 
						shiftKeyTick: 50 
				    });
					
					photoshop.crop.on('moveEvent', function() {
						// get updated coordinates
						photoshop.getCroppedImage();
					});
				},

				
				getCroppedImage: function(){
					var coordinates = photoshop.getCoordinates();
					url = 'image=' + photoshop.image + '&cropStartX=' + coordinates.left +'&cropStartY=' + coordinates.top +'&cropWidth=' + coordinates.width +'&cropHeight=' + coordinates.height;
					document.getElementById('uploadButton').value='Upload';
					document.getElementById('saveButton').style.visibility='visible';
				},
				
				getCoordinates: function(){
					return photoshop.crop.getCropCoords();
				}
			};
			
			function redirect () {
				document.getElementById('saveButton').value='Saving';
				$.ajax({
				type: "GET",
				url: "mugupload.php",
				data: url,
				success: function(msg){
					document['mug'].src = "clientfiles/<?php echo $_SESSION['clientFileLocation']; ?>/mug.jpg" + "?rand=" + Math.random();
					document.getElementById('saveButton').value='Save';
				}
				}); 
			}
			
			
			
			// add listeners
			YAHOO.util.Event.on('uploadButton', 'click', uploader.carry);
		</script>
		<link rel="stylesheet" type="text/css" href="style.css" /> 
	</head>
<body class="yui-skin-sam">
	<div id="container">
	
		<?php include('template/header.php'); ?>
		<?php include('template/leftnav.php'); ?>
		<?php if (isset($_SESSION['clientName'])) include('template/rightnav.php'); ?>
		
		<div id="content" <?php if (!isset($_SESSION['clientName'])) echo 'style="margin-right: 0; border-right: none;"'; ?> > 
			<?php if (isset($_SESSION['clientName'])) { ?>
			<div id="doc4" class="yui-t7">
				<div id="hd">
					Upload New Picture for <?php echo $_SESSION['clientName']; ?>
				</div>
				
				<div id="bd">
					<form action="mugupload.php" enctype="multipart/form-data" method="post" name="uploadForm" id="uploadForm">
						Image : <input type="file" name="uploadImage" id="uploadImage" />
						<input type="button" id="uploadButton" value="Upload"/>
					</form>
					
					<div id="imageContainer"></div>
					
					<input type="button" id="saveButton" value="Save" onclick="redirect()"/>
				</div>
			</div>
			<?php }else{ 
			ShowCaseLoad($_SESSION['userkey']);	
			}
			?>
		</div>   
		
	</div>
	<?php include('template/footer.php'); ?>
</body>
</html>