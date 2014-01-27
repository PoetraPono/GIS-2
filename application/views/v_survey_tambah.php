<html>
	<body>
		<form method="POST" action="<?php echo $base_url; ?>index.php/c_survey/tambah/save">
			Pilih Perusahaan : <?php echo $nm_list; ?><br/>
			Tanggal Beridiri : <?php echo $kalender ?><br/>
			Jumlah Karyawan : <input type="text" name="JML" value="<?php echo $JML; ?>" size="25" maxlength="20" /><br />
			Latitude Koordinasi  : <input type="text" name="LT" value="<?php echo $LT; ?>" size="25" maxlength="30" /><br/>
			Longitude Koordinasi : <input type="text" name="LN" value="<?php echo $LN; ?>" size="25" maxlength="30" /><br/>
			<button type="submit" value="Save">Simpan</button>
			<button type="reset" value="Reset">Reset</button>
		</form>
	</body>
</html>