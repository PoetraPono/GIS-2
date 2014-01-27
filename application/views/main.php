<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $base_url; ?>css/style.css">
		<?php echo $map['js']; ?>
		<script type="text/javascript">
			function doPrint(){
				var win = window.open('', 'Image');
				if (win) {
					win.document.writeln('<img src="<?php echo $base_url; ?>images/logo.png" /><hr/><br/><?php echo $printdata; ?><br/><img src="http://maps.googleapis.com/maps/api/staticmap?center=' + map.getCenter() + '&size=700x600&sensor=true&maptype=roadmap<?php echo $marker; ?>&zoom=' + map.getZoom() + '" alt="image">');
					win.document.close();
					win.focus();
					win.print();
				}
				
			}
			
			function cari(){
				document.getElementById('find').submit();
			}
		</script>
<title>BPMPT KARAWANG</title>
</head>

<body>

<div class="wrap-sign">
<div class="menu-top span7">
<?php echo $menu; ?>
</div>
<div class="dropdown navbar-inverse">

			<?php echo $logged_in; ?>

		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="padding: 15px 15px 15px 15px; background:#fff; z-index:9999;">

			<form action="<?php echo $base_url; ?>index.php/main/login/1" method="post">
				<input type="text" placeholder="Username" name="UE" size="15" maxlength="5" />
				<input type="password" placeholder="Password" name="PSW" maxlength="150" size="15" />
				<br/>
				<input type="submit" class="btn" value="Sign in" />

			</form>

		</ul>

	</div>
</div>
<div class="container1">
    <div class="header">
    <h1 class="logo"><img src="<?php echo $base_url; ?>images/logo.png" /></h1>
    </div>
    <div class="page-content">
    
    	<div class="navigation span4">
        	<div class="search pull-left"><img  src="<?php echo $base_url; ?>images/magni.png" onclick="cari()"/></div>
            <div class="styled-input">
			<form method="POST" action="<?php echo $base_url; ?>index.php/main/search" id="find">
				<input id="search" type="text" name="cari" data-provide="typeahead" placeholder="Search . . . " data-items="4" data-source="['Ahmedabad','Akola']">
				<select name='k_list'><option value='KOSONG'>-- Pilih Kategori --</option><?php echo $list; ?></select>
			</form>
    
    
            </div>
            <div class="clearfix"></div>
            <div class="summary-container">
               <?php echo $hasil; ?>
			   <div><?php echo $pagination; ?></div><br/>
            </div> <!-- end of summary container -->
        </div> <!-- end of navigation -->
      
            <div class="map span11">
				<?php echo $map['html']; ?>
            </div>            

    </div> <!-- end of page-content -->
    
</div> <!-- end of container -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript">

<script src="<?php echo $base_url; ?>js/bootstrap-dropdown.js"></script>
<script src="<?php echo $base_url; ?>js/bootstrap.js"></script>
<script src="<?php echo $base_url; ?>js/bootstrap-typeahead.js"></script>
<script src="<?php echo $base_url; ?>js/application.js"></script>
<script src="<?php echo $base_url; ?>js/bootstrap-button.js"></script>
<script src="<?php echo $base_url; ?>js/html5shiv.js"></script>
<script src="<?php echo $base_url; ?>js/jquery.js"></script>

	<script type="text/javascript">
    $('.typeahead').typeahead()
    </script>
	<script type="text/javascript">
	$('.dropdown-toggle').dropdown()
    </script>
    
	<script type="text/javascript">
	$('#myModal').modal('toggle')
	</script>
    
<!--    <script>  
 var subjects = ['PHP', 'MySQL', 'SQL', 'PostgreSQL', 'HTML', 'CSS', 'HTML5', 'CSS3', 'JSON'];   
$('#search').typeahead({source: subjects})  
</script>   -->

</body>
</html>
