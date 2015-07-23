<?php
/** 
 * An easy way to access Auth and User_model methods
 * @branch 1.5
 * @author Blair Jersyer
 * @since 1.5
**/
class User
{
	static private $user_par;
	static function can( $permission )
	{
		$Instance	=	get_instance();
		return $Instance->auth->is_group_allowed( $permission );
	}
}