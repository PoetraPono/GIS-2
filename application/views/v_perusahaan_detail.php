<html>
	<body>
		Nama Perusahaan : <?php echo $NM; ?><br/>
		Alamat Perusahaan : <?php echo $AL; ?><br/>
		Telepon Perusahaan : <?php echo $TL; ?><br/>
		Kategori Perusahaan : <?php echo $KT; ?><br/>
		Tentang Perusahaan : <?php echo $TN; ?><br/>
		
		<br/><br/>
		<table border=1>
			<tr><td>NO.</td><td>Nama Perizinan</td><td>Masa Berlaku Perizinan</td><td>Action</td></tr>
			<?php echo $dt_table; ?>
		</table>
		<form method="POST" action="<?php echo $base_url; ?>index.php/c_perizinan/tambah">
			<input type='hidden' value='<?php echo $linknya; ?>' name='linknya' />
			<input type='hidden' value='<?php echo $prs_id; ?>' name='prs_id' />
			<?php echo $pagination; ?><br/>
			<input type="submit" value="Tambah Masa Perizinan" />
		</form>	
		<input type="submit" onclick="window.print()" value="Print" />
	</body>
</html>