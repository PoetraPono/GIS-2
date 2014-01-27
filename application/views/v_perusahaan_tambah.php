<html>
	<body>
		<form method="POST" action="<?php echo $base_url; ?>index.php/c_perusahaan/<?php echo $mode; ?>/save">
			Nama Perusahaan   : <input type="text" name="NM" value="<?php echo $NM; ?>" size="25" maxlength="50" /><br />
			Alamat Perusahaan : <textarea name="AL"><?php echo $AL; ?></textarea><br />
			Telepon Perusahaan : <input type="text" name="TL" value="<?php echo $TL; ?>" size="25" maxlength="20" /><br />
			Kategori Perusahaan : <input type="text" name="KT" value="<?php echo $KT; ?>" size="40" maxlength="150" /><br/>
			Tentang Perusahaan : <textarea name="TN"><?php echo $TN; ?></textarea><br/>
			<input type='hidden' name='ID' value='<?php echo $ID; ?>' />
			<button type="submit" value="Save">Simpan</button>
			<button type="reset" value="Reset">Reset</button>
		</form>
	</body>
</html>