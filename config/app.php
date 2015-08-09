<?php
return [
	'modules' => [
		'App',
	],

	'services' => [
		'System\Services\ServerRequestService',
		'System\Services\RoutesService',
		'System\Services\SessionService',
		'System\Services\ViewRendererService',
	],

	/**
	 * Timezone
	 * Set the default timezone used by various PHP date functions.
	 */
	'timezone' => 'Asia/Tehran',

	/**
	 * Charset
	 * Default character set used internally in the framework.
	 */
	'charset' => 'UTF-8',

	/**
	 * google reCaptcha config
	 */
	'reCaptcha' => [
		'site_key'   => '6LddBwoTAAAAALksuOYRnYpVZw2ohmMBl6SttyNe',
		'secret'    => '6LddBwoTAAAAAKC3si35cydNn81bMtDkAAy7ZW6d'
	]
];