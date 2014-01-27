<html>
	<body>
		<form method="POST" action="<?php echo $base_url; ?>index.php/c_perizinan/tambah/<?php echo $prs_id; ?>/save">
			Nama Perizinan   : <?php echo $nm_list; ?><br/>
			Masa Perizinan : <?php echo $kalender; ?>
			<input type='hidden' name='redirect' value="<?php echo $redirect; ?>" />
			<input type='hidden' name='prs_id' value="<?php echo $prs_id; ?>" /><br/>
			<button type="submit" value="Save">Simpan</button>
		</form>
	</body>
</html>