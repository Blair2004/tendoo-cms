  <div class="form-group">
    <label for="exampleInputEmail1">Limite d'imbrication</label>
	<?php
	if(isset($zone,$index))
	{
		$name	=	'name="tewi_wid['.$zone.']['.$index.'][params]"';
	}
	else
	{
		$name	=	'';
	}
	// $this->data['keyWords']
	?>
    <select class="form-control" <?php echo $name;?> meta_widgetParams>
	    <option value="0">Aucune limite</option>
		<?php 
			for($i = 1;$i<= 10;$i++)
			{
				if(isset($parameters))
				{
					if($parameters == $i)
					{
				?>
				<option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
					}
					else
					{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php	
					}
				}
				else
				{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php
				}
			}
		?>
	</select>
  </div>