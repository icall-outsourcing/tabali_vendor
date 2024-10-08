<?php

return [
	'mode'                  => 'utf-8',
	'format'                => [80, 297],
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'ICALL',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'arabic-font' => [
		'R'  => 'arabic-font.ttf',    // regular font
		'B'  => 'arabic-font.ttf',          // optional: bold font
		'I'  => 'arabic-font-Light.ttf',    // optional: italic font
		'BI' => 'arabic-font.ttf',           // optional: bold-italic font
		'useOTL' => 0xFF,
		'useKashida' => 75,		
	]
];
