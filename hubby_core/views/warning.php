<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->core->hubby->getTitle();?></title>
<?php echo $this->core->file->css_load();?>
<?php echo $this->core->file->js_load();?>
</head>

<body>
	<div class="div_100_1" style="background:#FFF;border:dashed #F00 1px;">
    	<div style="padding:10px;">
            <h1 style="text-shadow:1px 1px 2px #999;color:#666;"><?php echo $this->core->hubby->getTitle();?></h1>
            <div class="paragraph"><strong><?php echo $error;?></strong></div>
		</div>
	</div>
</body>
</html>