<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 In Cite Solution <technique@in-cite.net>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */
 
require_once(t3lib_extMgm::extPath('ics_merge_piflexform').'class.tx_icsmergepiflexform_merge.php');

/**
 * Merge tt_news flexform and ics_newssorting flexform
 * Replace marker ###LASTINDEX### width last index for listOrderBy field
 *
 * @author	Emilie Sagniez <emilie@in-cite.net>
 * @package	TYPO3
 * @subpackage	tx_icsnewssorting
 */
class tx_icsnewssorting_flexform {
	
	static function merge($flexform_ttnews, $flexform_add) {
		$flexform = $flexform_ttnews;
		// get LastIndex
		$lastIndex = 0;
		if (substr($flexform, 0, 5) == 'FILE:')
			$flexform = substr($flexform, 5);
		if (substr($flexform, 0, 4) == 'EXT:')
			$flexform = file_get_contents(t3lib_div::getFileAbsFileName($flexform));
		$flexform = t3lib_div::xml2array($flexform);
		
		$items = $flexform['sheets']['sDEF']['ROOT']['el']['listOrderBy']['TCEforms']['config']['items'];
		if (is_array($items) && !empty($items)) {
			foreach ($items as $index => $item) {
				if ($index > $lastIndex)
					$lastIndex = $index; 
			}
		}
		$lastIndex++;
		
		// replace index in new flexform
		if (substr($flexform_add, 0, 5) == 'FILE:')
			$flexform_add = substr($flexform_add, 5);
		if (substr($flexform_add, 0, 4) == 'EXT:')
			$flexform_add = file_get_contents(t3lib_div::getFileAbsFileName($flexform_add));
		
		$flexform_add = str_replace('###LASTINDEX###' , $lastIndex, $flexform_add);
		
		// merge with ics_merge_piflexform
		$new_flexform = tx_icsmergepiflexform_merge::merge($flexform_ttnews, $flexform_add);
		
		return $new_flexform;
	}
}
 
?>