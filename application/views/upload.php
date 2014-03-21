<html>
	<head>
		<title>Upload Form</title>
	</head>
	<body>
		<a href="<?php echo $url_logout ?>">LOGOUT</a><br><br>
		<?php echo form_open_multipart('main/upload');?>
		<input type="file" name="userfile" size="20" /><br><br>
		<input type="submit" value="upload" />
		</form>
		<p><?php echo $this->session->flashdata('upload_error');?></p>
		<?php if($map){ foreach($map as $file) echo "<br><a href='".$url_folder."/".$file."'>".$file."</a>"; }?>
</body>
</html>