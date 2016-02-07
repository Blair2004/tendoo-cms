<p>How many installation are actives</p>
<table class="table table-bordered">
	<thead>
    	<tr>
        	<td>Site Name</td>
            <td>Ref</td>
        </tr>
    </thead>
    <tbody>
    	<?php 
		$query	=	$this->db->get( 'trackbacks' );
		$result_array	=	$query->result_array();
		if( count( $result_array ) > 0 ) {
			foreach( $result_array as $result ) {
				?>
				<tr>
				<td><?php echo $result[ 'blog_name' ];?></td>
				<td><?php echo $result[ 'url' ];?></td>
				</tr>
				<?php
			}
		} else {
			?>
            <tr>
            	<td colspan="2">No Pinback has been saved yet</td>
            </tr>
            <?php
		}
		?>		
    </tbody>
</table>