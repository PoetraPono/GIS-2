<html>
 <head><?php echo $map['js']; ?>
	<script type="text/javascript">
		function doPrint(){
			window.open("http://maps.googleapis.com/maps/api/staticmap?center=" + map.getCenter() + "&size=600x600&sensor=true&maptype=roadmap<?php echo $marker; ?>&zoom=" + map.getZoom());
		}
	</script>
 </head>
 <body>
	<table border=1>
	<tr>
		<td width='100px' valign='top' ><?php echo $menu; ?></td>
		<td height='450px' width='700px'><?php echo $map['html']; ?></td>
	</tr>
	</table>
	<br />
 </body>
</html>