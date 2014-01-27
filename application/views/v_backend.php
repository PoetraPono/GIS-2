<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo isset($map['js'])?$map['js']:''; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="stylesheet" href="<?php echo $base_url; ?>css/admin/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $base_url; ?>css/admin/style.css">
<title>BPMPT KARAWANG</title>
</head>

<body>

<div class="wrap-sign">
 <h1 class="logo span3"><img src="<?php echo $base_url; ?>images/logo-admin.png" /></h1>
	<div class="user">
    <ul class="calendar">
    <img src="<?php echo $base_url; ?>images/calendar1.png" />
    <span><?php echo date("F d, Y"); ?></span><br />
    <span><?php echo date("l,G:i:s"); ?></span>
    </ul>

        <div class="dropdown">
    <a class="dropdown-toggle" href="<?php echo $base_url; ?>index.php/main/logout"><?php echo $this->session->userdata('NM'); ?> <i class="icon-off icon-white"></i></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    <a href="#">Logout</a>

    </div>
    </ul>
    </div>
</div>
    
    	<div class="navigation">
        	
            <div class="clearfix"></div>
            <?php echo $menu; ?><!-- end of summary container -->
        </div> <!-- end of navigation -->
        

        <div class="page-content">
        <?php 
        	$varSearch = '<div class="search pull-right" onclick="cari()"><img src="'.$base_url.'images/magni.png" /></div>
            <div class="styled-input pull-right">
				<form method="POST" action="'.$base_url.'index.php/'.$modul.'" id="find" >
				<input name="cari" id="search" type="text" placeholder="Search . . . " data-provide="typeahead">
				</form>
			</div>';
        	if($modul=="c_perusahaan/index/1"||$modul=="c_user/index/1"||$modul=="c_survey/index/1"){
        		echo $varSearch;
        	}
        ?>
		
			<div class="clearfix"></div>
		<?php echo isset($notification)?$notification:""; ?>
        <table class="table table-bordered" width="100%">
			<?php echo $dt_table; ?>
			<?php echo isset($map['html'])?"<tr><td colspan=5>".$map['html']."</td></tr>":""; ?>
			<?php echo $pagination; ?>
		</table>
		<?php echo empty($photo)?"":$photo .'</div>'; ?>
		
  
      <div style="float:right"><?php echo $tombol; ?></div>
      <div class="clearfix"></div>
          <hr />
    </div> <!-- end of page-content -->
    


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
	
	<script type='text/javascript'>
		
		function doPrint(){
				var win = window.open('', 'Image');
				if (win) {
					win.document.writeln('<?php echo $printdata; ?><img src="http://maps.googleapis.com/maps/api/staticmap?center=' + map.getCenter() + '&size=700x600&sensor=true&maptype=roadmap&markers=<?php echo $marker; ?>&zoom=' + map.getZoom() + '" alt="image"><br/><?php echo $photo .'</div>'; ?>');
					win.document.close();
					win.focus();
					win.print();
				}
				
			}
			
		function cari(){
				document.getElementById('find').submit();
			}
	</script>
    
<!--    <script>  
 var subjects = ['PHP', 'MySQL', 'SQL', 'PostgreSQL', 'HTML', 'CSS', 'HTML5', 'CSS3', 'JSON'];   
$('#search').typeahead({source: subjects})  
</script>   -->

</body>
</html>
