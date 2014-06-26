<?php
class Tdate extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		$this->instance	=	get_instance();
	}
	// New Tendoo 0.9.8 retourne le timezone enregistré
	public function getTimeZone()
	{
		$options	=	$this->instance->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		return $timezone;
	}
	// Crée un objet date sur la base d'un format et d'une chaine de caractère donnée. en utilisant le TimeZone définie
	// Renvoi un objet DateTime; T098
	public function createDateFromString($format,$string)
	{
		$date		=	DateTime::createFromFormat('d-m-Y H:i e',$string.' '.$this->getTimeZone());
		return $date;
	}
	public function time($timestamp	=	'',$toArray	=	false)
	{
		$timestamp	=	strtotime($timestamp);
		$this->load->helper('date');
		$options	=	$this->instance->options->get();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		$timeformat	=	$options[0]['SITE_TIMEFORMAT'];
		if($timezone== '')
		{
			$timezone 		= 'UTC';
		}
		if($timeformat	==	'')
		{
			$timeformat		=	'type_1';
		}
		$daylight_saving 	= TRUE;
		if($timestamp	==	'')
		{
			$timestamp				=	$this->timestamp();
		}
		$month					=	array(
			1	=>	'Janvier',
			2	=>	'F&eacute;vrier',
			3	=>	'Mars',
			4	=>	'Avril',
			5	=>	'Mai',
			6	=>	'Juin',
			7	=>	'Juillet',
			8	=>	'Ao&ucirc;t',
			9	=>	'Septembre',
			10	=>	'Octobre',
			11	=>	'Novembre',
			12	=>	'Decembre'
		);
		$timeToArray			=	array(
			'd'=>mdate('%d',$timestamp),
			'y'=>mdate('%Y',$timestamp),
			'M'=>mdate('%n',$timestamp),
			'm'=>mdate('%m',$timestamp),
			'h'=>mdate('%H',$timestamp),
			'i'=>mdate('%i',$timestamp),
			's'=>mdate('%s',$timestamp),
			't'=>mdate('%t',$timestamp),
			'month'	=>	$month[mdate('%n',$timestamp)]
		);
		
		if($toArray	==	true)
		{
			return $timeToArray;
		}
		if($timeformat 	==	'type_1')
		{
			return mdate('Le %d '.$month[$timeToArray['M']].' %Y - %H:%i:%s',$timestamp);
		}
		elseif($timeformat 	==	'type_2')
		{
			return mdate('%d/%m/%Y - %H:%i:%s',$timestamp);
		}
		elseif($timeformat 	==	'type_3')
		{
			return mdate('%Y/%m/%d - %H:%i:%s',$timestamp);
		}
	}
	public function arrayToTimestamp($date)
	{
		return strtotime($date['y'].'-'.$date['M'].'-'.$date['d'].' '.$date['h'].':'.$date['i'].':'.$date['s']);
	}
	public function timestamp()
	{		
		// $this->load->helper('date');
		$options	=	$this->instance->options->get();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		if($timezone== '')
		{
			$timezone 		= 'Etc/UTC';
		}
		// $tz_object	=	new DatetimeZone($timezone);
		$date		=	new DateTime(null,new DatetimeZone($timezone));
		$timestamp	=	strtotime($date->format('Y-m-d H:i:s'));
		return $timestamp;
	}
	public function getFuseau()
	{
		$final		=	array();
		$final[]	=	array(
			'Index'	=>	'UTC-11',
			'Code'	=>	'Pacific/Samoa',
			'States'=>	'Pacifique (Samoa, Niue)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-10',
			'Code'	=>	'Pacific/Tahiti',
			'States'=>	'Pacifique (Tahiti, Honolulu, Fakaofo)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-09',
			'Code'	=>	'America/Anchorage',
			'States'=>	'Am&eacute;rique (Anchorage)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-08',
			'Code'	=>	'Pacific/Pitcairn',
			'States'=>	'Pacifique (Pitcairn, Vancouver) Amerique(Tijuana, Los angeles)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-07',
			'Code'	=>	'America/Phoenix',
			'States'=>	'Amerique (Phoenix, Mazatlan, Hermosillo, Denver, Edmonton)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-06',
			'Code'	=>	'America/Winnipeg',
			'States'=>	'Amerique (Winnipeg, Tegucigalpa, Regina, Rankin_Inlet, Monterrey)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-05',
			'Code'	=>	'America/Toronto',
			'States'=>	'Amerique (Toronto, Port-au-Prince, Panama, New York, Lima, Nassau)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-04:30',
			'Code'	=>	'America/Caracas',
			'States'=>	'Amerique (Caracas)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-04',
			'Code'	=>	'America/Virgin',
			'States'=>	'Am&eacute;rique (Virginie, Tortola, St Vincent, Porto Rico)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-03:30',
			'Code'	=>	'America/St_Johns',
			'States'=>	'Am&eacute;rique (St Johns)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-03',
			'Code'	=>	'Chile/Continental',
			'States'=>	'Chilie, Amérique(Paramaribo, Miquelon, Maceio, Godthab), Argentine (Buenos Aires)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-02',
			'Code'	=>	'America/Sao_Paulo',
			'States'=>	'Br&eacute;sil (Sao Paulo), Atlantic (Cap-vert), Montevideo'
		);
		$final[]	=	array(
			'Index'	=>	'UTC-01',
			'Code'	=>	'Atlantic/Azores',
			'States'=>	'Atlantique (Azores)'
		);$final[]	=	array(
			'Index'	=>	'UTC-GMT:0',
			'Code'	=>	'Europe/London',
			'States'=>	'Europe(Londres, Lisbon, Jersey, St Helena) Afrique (Abidjan, Accra, Bamako, Bissau)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+1',
			'Code'	=>	'Europe/Zurich',
			'States'=>	'Allemange(Zurich), Italie(Vatican, Rome), France(Paris), Afrique(Guin&eacute;e Equa., Nigeria, Brazzaville, Niamey'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+2',
			'Code'	=>	'Europe/Vilnius',
			'States'=>	'Europe(Vilnius, Tallinn, Riga, Sofia, Kiev), Asie (Jerusalem, Istanbul, Amman), Afrique(Caire, Gaborone, Lusaka, Maputo, Mbabane, Tripoli)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+3',
			'Code'	=>	'Asia/Qatar',
			'States'=>	'Asie(Qatar, Kuwait, Baghdad), Afrique(Nairobi, Khartoum, Kampala, Asmera)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+4',
			'Code'	=>	'Indian/Reunion',
			'States'=>	'Asie (Dubaï, Yerevan, Baku)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5',
			'Code'	=>	'Asia/Yekaterinburg',
			'States'=>	'Asie(Yekaterinburg, Tashkent, Oral, Dushanbe)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5:30',
			'Code'	=>	'Asia/Calcutta',
			'States'=>	'Asie(Calcutta)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+5:45',
			'Code'	=>	'Asia/Katmandu',
			'States'=>	'Asie(Katmandu)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+6',
			'Code'	=>	'Asia/Thimphu',
			'States'=>	'Asie(Thimphu, Omsk, Novosibirsk, Bishkek, Almaty)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+6:30',
			'Code'	=>	'Asia/Rangoon',
			'States'=>	'Asie(Rangoon)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+7',
			'Code'	=>	'Asia/Vientiane',
			'States'=>	'Asie( Vientiane, Jakarta, Hovd, Dhaka, Bangkok)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+8',
			'Code'	=>	'Australia/West',
			'States'=>	'Australie(Ouest), Asie(Taipei, Singapore, Manila, Macao, Hong Kong)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+9',
			'Code'	=>	'Pacific/Palau',
			'States'=>	'Pacifique(Palau), Asie(Tokyo, Seoul, Jayapura)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+9:30',
			'Code'	=>	'Australia/North',
			'States'=>	'Australie(Nord)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+10',
			'Code'	=>	'Pacific/Yap',
			'States'=>	'Pacifique(Yap, Truk, Saipan, Port Moresby), Australie(Queensland)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+11',
			'Code'	=>	'Pacific/Ponape',
			'States'=>	'Pacifique(Ponape, Noumea, Kosrae), Australie(Victoria, Tasmanie, Canberra)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+11:30',
			'Code'	=>	'Pacific/Norfolk',
			'States'=>	'Pacific(Norfolk)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+12',
			'Code'	=>	'Pacific/Wallis',
			'States'=>	'Pacifique(Wallis, Tarawa, Nauru, Funafuti)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+13',
			'Code'	=>	'Pacific/Tongatapu',
			'States'=>	'Pacifique(Tongatapu, Auckland, Chatham)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+13:45',
			'Code'	=>	'Pacific/Chatham',
			'States'=>	'Pacifique(Chatham)'
		);
		$final[]	=	array(
			'Index'	=>	'UTC+14',
			'Code'	=>	'Pacific/Kiritimati',
			'States'=>	'Pacifique(Kiritimati)'
		);
		return $final;
	}
	public function timespan($timestamp)
	{
		return timespan($timestamp,$this->timestamp());
	}
	public function datetime($defaulFormat = '%Y-%m-%d %H:%i:%s')
	{
		$this->load->helper('date');
		$timestamp			=	$this->timestamp();
		$datetime			=	mdate($defaulFormat,$timestamp);
		return $datetime;
	}
}