<html><head><?php echo $map['js']; ?></head>
	<body>
		Nama Perusahaan : <?php echo $NM; ?><br/>
		Alamat Perusahaan : <?php echo $AL; ?><br/>
		Telepon Perusahaan : <?php echo $TL; ?><br/>
		Kategori Perusahaan : <?php echo $KT; ?><br/>
		Tentang Perusahaan : <?php echo $TN; ?><br/><br/>
		
		Detail Survey <br/>
		Jumlah Karyawan : <?php echo $JML_KRA; ?><br/>
		Tanggal Berdiri : <?php echo $TGL_PNI; ?><br/><br/>
		<?php echo $gambar; ?>
		<br/><br/>
		<table border=1>
			<tr><td>NO.</td><td>Nama Perizinan</td><td>Masa Berlaku Perizinan</td></tr>
			<?php echo $dt_table; ?>
			<tr><td colspan=3 height='450px' width='700px'><?php echo $map['html']; ?></td></tr>
		</table><br/>
		<input type="submit" onclick="window.print()" value="Print" />
	</body>
</html>