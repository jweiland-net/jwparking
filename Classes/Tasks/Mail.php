<?php
namespace JWeiland\Jwparking\Tasks;

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
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Mail extends AbstractTask {

	/**
	 * @var \JWeiland\Jwparking\Configuration\ExtConf
	 */
	protected $extConf;

	/**
	 * constructor of this class
	 */
	public function __construct() {
		// first we have to call the parent constructor
		parent::__construct();

		// initialize some global variables
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->extConf = $this->objectManager->get('JWeiland\\Jwparking\\Configuration\\ExtConf');
	}

	/**
	 * The first method which will be executed when task starts
	 *
	 * @return boolean
	 */
	public function execute() {
		/** @var \TYPO3\CMS\Core\Mail\MailMessage $mail */
		$mail = new MailMessage();
		$mail->setFrom($this->extConf->getEmailFromAddress(), $this->extConf->getEmailFromName());
		$mail->setTo($this->extConf->getEmailToAddress(), $this->extConf->getEmailToName());
		$mail->setSubject('CSV-Export Jwparking');
		$mail->attach(\Swift_Attachment::fromPath(PATH_site . $this->extConf->getFilePath()));
		return (bool)$mail->send();
	}


	/**
	 * scheduler serializes this object so we have to tell unserialize() what to do
	 *
	 * @return void
	 */
	public function __wakeup() {
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->extConf = $this->objectManager->get('JWeiland\\Jwparking\\Configuration\\ExtConf');
	}

	/**
	 * the result of serialization is too big for db. So we reduce the return value
	 *
	 * @return array
	 */
	public function __sleep() {
		return array('scheduler', 'taskUid', 'disabled', 'execution', 'executionTime');
	}

}