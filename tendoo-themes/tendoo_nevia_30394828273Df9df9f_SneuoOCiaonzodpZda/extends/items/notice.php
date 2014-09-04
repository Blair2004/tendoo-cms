<?php
		if(strlen($this->notice->parse_notice(true)) > 0)
		{
		?>
<div style="display: block;" id="notification_4" class="notification notice closeable">
<p><span>Notification :</span> <?php $this->notice->parse_notice();?>.</p>
<a class="close" href="#"><i class="icon-remove"></i></a></div>
<?php
		}
