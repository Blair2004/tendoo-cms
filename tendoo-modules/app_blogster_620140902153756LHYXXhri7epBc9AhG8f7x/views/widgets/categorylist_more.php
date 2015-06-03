  <div class="form-group">
    <label>Nombre catégorie à afficher.</label>
	<?php
	if(!function_exists('lazyNameGen'))
	{
		function lazyNameGen($text,$zone,$index)
		{
			if(isset($zone,$index))
			{
				$name	=	'name="tewi_wid['.$zone.']['.$index.'][params]'.$text.'"';
			}
			else
			{
				$name	=	'';
			}
			return $name;
		}
	}
	?>
    <select class="form-control" meta_widgetParams <?php echo lazyNameGen('',$zone,$index);?>>
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
						if(is_array($parameters))
						{
							if(array_key_exists('nbr_categorie',$parameters))
							{
								if($parameters['nbr_categorie'] == $i)
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
						else
						{
				?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php	
						}
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