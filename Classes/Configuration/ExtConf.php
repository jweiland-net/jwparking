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
use TYPO3\CMS\Core\SingletonInterface;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ExtConf implements SingletonInterface {

	/**
	 * filePath
	 *
	 * @var string
	 */
	protected $filePath;

	/**
	 * ajaxRefresh
	 *
	 * @var int
	 */
	protected $ajaxRefresh;

	/**
	 * parkingTitles
	 *
	 * @var string
	 */
	protected $parkingTitles = '';

	/**
	 * parkingLinks
	 *
	 * @var string
	 */
	protected $parkingLinks = '';

	/**
	 * email from address
	 *
	 * @var string
	 */
	protected $emailFromAddress;

	/**
	 * email from name
	 *
	 * @var string
	 */
	protected $emailFromName;

	/**
	 * email to address
	 *
	 * @var string
	 */
	protected $emailToAddress;

	/**
	 * email to name
	 *
	 * @var string
	 */
	protected $emailToName;





	/**
	 * constructor of this class
	 * This method reads the global configuration and calls the setter methods
	 */
	public function __construct() {
		// get global configuration
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jwparking']);
		if (is_array($extConf) && count($extConf)) {
			// call setter method foreach configuration entry
			foreach($extConf as $key => $value) {
				$methodName = 'set' . ucfirst($key);
				if (method_exists($this, $methodName)) {
					$this->$methodName($value);
				}
			}
		}
	}

	/**
	 * getter for filePath
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getFilePath() {
		if (empty($this->filePath)) {
			throw new \Exception('You have forgotten to set a file path in extension configuration.');
		} else return $this->filePath;
	}

	/**
	 * setter for filePath
	 *
	 * @param string $filePath
	 * @return void
	 */
	public function setFilePath($filePath) {
		$this->filePath = (string)$filePath;
	}

	/**
	 * Returns the ajaxRefresh
	 *
	 * @return int $ajaxRefresh
	 */
	public function getAjaxRefresh() {
		if (empty($this->ajaxRefresh)) {
			return 60;
		} else {
			return $this->ajaxRefresh;
		}
	}

	/**
	 * Sets the ajaxRefresh
	 *
	 * @param int $ajaxRefresh
	 * @return void
	 */
	public function setAjaxRefresh($ajaxRefresh) {
		$this->ajaxRefresh = (int)$ajaxRefresh;
	}

	/**
	 * Returns the parkingTitles
	 *
	 * @return string $parkingTitles
	 */
	public function getParkingTitles() {
		return $this->parkingTitles;
	}

	/**
	 * Sets the parkingTitles
	 *
	 * @param string $parkingTitles
	 * @return void
	 */
	public function setParkingTitles($parkingTitles) {
		$this->parkingTitles = (string)$parkingTitles;
	}

	/**
	 * Returns the parkingLinks
	 *
	 * @return string $parkingLinks
	 */
	public function getParkingLinks() {
		return $this->parkingLinks;
	}

	/**
	 * Sets the parkingLinks
	 *
	 * @param string $parkingLinks
	 * @return void
	 */
	public function setParkingLinks($parkingLinks) {
		$this->parkingLinks = (string)$parkingLinks;
	}

	/**
	 * getter for email from address
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getEmailFromAddress() {
		if (empty($this->emailFromAddress)) {
			$senderMail = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'];
			if (empty($senderMail)) {
				throw new \Exception('You have forgotten to set a sender email address in extension configuration or in install tool');
			} else return $senderMail;
		} else return $this->emailFromAddress;
	}

	/**
	 * setter for email from address
	 *
	 * @param string $emailFromAddress
	 * @return void
	 */
	public function setEmailFromAddress($emailFromAddress) {
		$this->emailFromAddress = (string) $emailFromAddress;
	}

	/**
	 * getter for email from name
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getEmailFromName() {
		if (empty($this->emailFromName)) {
			$senderName = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'];
			if (empty($senderName)) {
				throw new \Exception('You have forgotten to set a sender name in extension configuration or in install tool');
			} else return $senderName;
		} else return $this->emailFromName;
	}

	/**
	 * setter for emailFromName
	 *
	 * @param string $emailFromName
	 * @return void
	 */
	public function setEmailFromName($emailFromName) {
		$this->emailFromName = (string) $emailFromName;
	}

	/**
	 * getter for email to address
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getEmailToAddress() {
		if (empty($this->emailToAddress)) {
			throw new \Exception('You have forgotten to set an admin email address in extension configuration. This was needed to inform an admin about newly created records.');
		} else return $this->emailToAddress;
	}

	/**
	 * setter for email to address
	 *
	 * @param string $emailToAddress
	 * @return void
	 */
	public function setEmailToAddress($emailToAddress) {
		$this->emailToAddress = (string) $emailToAddress;
	}

	/**
	 * getter for email to name
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function getEmailToName() {
		if (empty($this->emailToName)) {
			throw new \Exception('You have forgotten to set an admin name in extension configuration.');
		} else return $this->emailToName;
	}

	/**
	 * setter for emailToName
	 *
	 * @param string $emailToName
	 * @return void
	 */
	public function setEmailToName($emailToName) {
		$this->emailToName = (string) $emailToName;
	}

}