<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_icsnewssorting_sorting" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:ics_newssorting/locallang_db.xml:tt_news.tx_icsnewssorting_sorting",		
		"config" => Array (
			"type"     => "input",
			"size"     => "4",
			"max"      => "4",
			"eval"     => "int",
			"checkbox" => "0",
			"range"    => Array (
				"upper" => "1000",
				"lower" => "10"
			),
			"default" => 0
		)
	),
);


t3lib_div::loadTCA("tt_news");
t3lib_extMgm::addTCAcolumns("tt_news",$tempColumns,1);
$GLOBALS['TCA']["tt_news"]['ctrl']['sortby'] = 'tx_icsnewssorting_sorting';

require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_icsnewssorting_flexform.php');
$old_flexform = $TCA['tt_content']['columns']['pi_flexform']['config']['ds']['9,list'];
$new_flexform = tx_icsnewssorting_flexform::merge($old_flexform, 'EXT:' . $_EXTKEY . '/flexform.xml');

t3lib_extMgm::addPiFlexFormValue(9, $new_flexform);

?>