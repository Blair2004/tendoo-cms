<div class="table-responsive">
    <table class="table table-striped m-b-none">
        <thead>
            <tr>
                <th><?php _e( 'Author' );?></th>
                <th width="400"><?php _e( 'Preview' );?></th>
                <th><?php _e( 'Related Post' );?></th>
                <th><?php _e( 'Posted on' );?></th>
                <th><?php _e( 'Status' );?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                                if(count($getComments) > 0)
                                {
                                    foreach($getComments as $g)
                                    {
                                        if($g['AUTEUR'] != '0')
                                        {
                                            $user				=	get_instance()->users_global->getUser($g['AUTEUR']);
                                        }
                                        else
                                        {
                                            $user['PSEUDO']		=	$g['OFFLINE_AUTEUR'];
                                        }
                                ?>
            <tr>
                <td><?php echo $user['PSEUDO'];?></td>
                <td><a href="<?php echo module_url( array( 'comments_manage' , $g[ 'ID' ] ) , 'blogster' );?>"><?php echo word_limiter($g['CONTENT'],20);?></a></td>
                <td><?php 
                                        $article	=	$news->getSpeNews($g['REF_ART']);
                                        echo $article[0]['TITLE'];
                                        ?></td>
                <td><?php echo timespan($g['DATE']);?></td>
                <td><?php
                                        if($setting['APPROVEBEFOREPOST'] == 0)
                                        {
                                            echo __( 'N/A' );
                                        }
                                        else
                                        {
                                            echo $g['SHOW'] == '0' ? __( 'Unapproved' ) : __( 'Approved' );
                                        }
                                        ?></td>
            </tr>
            <?php
                                    }
                                }
                                else
                                {
                                    ?>
            <tr>
                <td colspan="5"><?php _e( 'There is no comment right now' );?></td>
            </tr>
            <?php
                                }
                                ?>
        </tbody>
    </table>
</div>
