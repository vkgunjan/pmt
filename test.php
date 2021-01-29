
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Orient Bell Limited - List Boutique</title>
<link rel="stylesheet" type="text/css" href="css/menu.css">
<link href="images/obl-favicon.png" rel="shortcut icon" title="Orient Bell Limited" />


<script type="text/javascript">
function setExpDate(formDate){
    // set number of days to add
    var interval = 30;
    var startDate = new Date(Date.parse(formDate));
    document.write('start: ' + startDate);
    var expDate = startDate;
    expDate.setDate(startDate.getDate() + interval);
    document.write('<br>expire: ' + expDate);
};
</script>

<script>
!window.jQuery && document.write('<script src="fancybox/jquery-1.4.3.min.js"><\/script>');
!window.jQuery && document.write('<script src="fancybox/jquery.mousewheel-3.0.4.pack.js"><\/script>');	
!window.jQuery && document.write('<script src="fancybox/jquery.fancybox-1.3.4.pack.js"><\/script>');	
!window.jQuery && document.write('<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" media="screen"/>');	

</script>
<script type="text/javascript">
		$(document).ready(function() {
		
			$(".a").fancybox({
				'width'				: '80%',
				'height'			: '50%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				'opacity'			: '0.4',
							
			});

		});
	</script>


</head>
<body >


				<a href="display-boutique.php?boutique_code='.$f['Code'].'&brand='.$f['Brand'].'" class="a">asdf
							</a>

asdfasdfasdf<br />asdfasdfasdfasdfa<br />asdfasdfasdfasdfsad<br />
<input type="text" size="10" maxlength="10" id="startDate" name="startDate" onblur="setExpDate(this.value)">

 </body></html>
