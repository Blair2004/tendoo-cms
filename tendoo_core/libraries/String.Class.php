<?php 
class String
{
	/*
		Transforme un texte en URL ou $strip_car est le délimiteur
	*/
	public function urilizeText($text,$strip_char = '-')
	{
		if(!function_exists('stripThing'))
		{
			function stripThing($delimiter,$offset,$strip_char)
			{
				$newtext	=	explode($delimiter,$offset);
				$e = '';
				for($i = 0;$i < count($newtext) ; $i++)
				{
					if($i+1 == count($newtext))
					{
						$e .=$newtext[$i];
					}
					else
					{
						$e .=$newtext[$i].$strip_char;
					}
				}
				return $newtext	=	strtolower($e);
			}
		}
		$newtext	=	convert_accented_characters($text);
		$newtext	=	stripThing('\'',$newtext,$strip_char);
		$newtext	=	stripThing(' ',$newtext,$strip_char);
		$newtext	=	stripThing('.',$newtext,$strip_char);
		// Removing question mark to avoid security error.
		$newtext	=	stripThing('?',$newtext,$strip_char);
		$newtext	=	stripThing('\n',$newtext,$strip_char);
		return $newtext;
	}
}