<html>
 <body>
	<form method="POST" action="<?php echo $base_url; ?>index.php/c_perusahaan/index">
						<input style="width:180px" type="text" name="cari" />
						<input type="submit" value="Search" />
	</form>
	<table border=1>
		<tr><td>Name</td><td>Alamat</td><td>Kategori</td><td>Action</td></tr>
		<?php echo $dt_table; ?>
	</table>
	<?php echo $pagination . "<br/>" . $tambah; ?>
 </body>
</html>