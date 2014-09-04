  <div class="form-group">
    <label for="exampleInputEmail1">Limite des mots clés</label>
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
		<?php 
			for($i = 1;$i<= 30;$i++)
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
        <option value="all">Tout afficher</option>
	</select>
  </div>