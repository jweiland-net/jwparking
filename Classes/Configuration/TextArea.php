<?php
namespace JWeiland\Jwparking\Configuration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Stefan Froemken <projects@jweiland.net>, jweiland.net
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\ViewHelpers\Form\TypoScriptConstantsViewHelper;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TextArea {

	/**
	 * Tag builder instance
	 *
	 * @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder
	 */
	protected $tag = NULL;

	/**
	 * constructor of this class
	 */
	public function __construct() {
		$this->tag = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\Core\\ViewHelper\\TagBuilder');
	}

	/**
	 * render textarea for extConf
	 *
	 * @param array $parameter
	 * @param TypoScriptConstantsViewHelper $parentObject
	 * @return string
	 */
	public function render(array $parameter = array(), TypoScriptConstantsViewHelper $parentObject) {
		$this->tag->setTagName('textarea');
		$this->tag->forceClosingTag(TRUE);
		$this->tag->addAttribute('cols', 45);
		$this->tag->addAttribute('rows', 7);
		$this->tag->addAttribute('name', $parameter['fieldName']);
		$this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
		if ($parameter['fieldValue'] !== NULL) {
			$this->tag->setContent(trim($parameter['fieldValue']));
		}
		return $this->tag->render();
	}

}