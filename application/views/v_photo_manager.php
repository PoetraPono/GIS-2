<html>
 <body>
	Data Photo dari Survey Perusahaan
	<table border=1>
		<tr><td>No</td><td>Photo </td><td>Action</td></tr>
		<?php echo $dt_table; ?>
	</table>
	<form method="POST" action="<?php echo $base_url; ?>index.php/c_survey/photo/tambah" enctype="multipart/form-data">
						Tambah Photo <input type='hidden' name='sre_id' value='<?php echo $sre_id; ?>' />
						<input type='file' name='fl' id='fl' />
						<input type='submit' name='submit' value='Upload' />
	</form>
 </body>
</html>