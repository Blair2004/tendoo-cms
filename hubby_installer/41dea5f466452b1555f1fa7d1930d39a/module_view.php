<?php 
if($elementOpt['CAROUSSEL'] ===TRUE)
{
	if($newsOpt['CAROUSSEL']['SHOW'] === TRUE)
	{
		if(count($news) > 0)
		{
			foreach($news as $n)
			{
				$theme->defineCaroussel(
					$n['TITLE'],
					$n['CONTENT'],
					$n['IMAGE'],
					$this->core->url->site_url(array($Contller[0]['PAGE_CNAME'],'read',$n['ID'],$this->core->hubby->urilizeText($n['TITLE']))),
					null
				);
			}
		}
		else
		{
			$theme->defineCarousselItem('http://localhost/kroft/html/img/dummies/03.jpg?1182560560731','Aucun element Disponible','Aucun element disponible','http://www.luiszuno.com/');
		}
	}
}
if($elementOpt['INFOSMALLDETAILS'] ===TRUE)
{
	if($newsOpt['INFOSMALLDETAILS']['SHOW'] === TRUE)
	{
		if(count($news_2) > 0)
		{
			foreach($news_2 as $n)
			{
				$theme->defineOnTopContent(
					$n['IMAGE'],
					$n['TITLE'],
					$n['CONTENT'],
					$this->core->url->site_url(array($Ctrl_2[0]['PAGE_CNAME'],'read',$n['ID'],$this->core->hubby->urilizeText($n['TITLE']))),
					$n['DATE']
				);
			}
		}
		else
		{
			$theme->defineOnTopContent(
				'',
				'Aucun element disponible',
				'...',
				'#',
				''
			);
		}
	}
}
/*if($elementOpt['ONTOP'] === TRUE)
{
	if($newsOpt['ONTOP']['SHOW'] === TRUE)
	{
		if(count($news_3) > 0)
		{
			foreach($news_3 as $v)
			{
				$theme->defineBlogRetreival(
					$v['IMAGE'],
					$v['IMAGE'],
					$v['TITLE'],
					$v['CONTENT'],
					$this->core->url->site_url(array($Ctrl_3[0]['PAGE_CNAME'],'read',$v['ID'],$this->core->hubby->urilizeText($v['TITLE']))),
					$n['DATE']
				);
			}
		}
	}
}*/
$theme->parseIndex();