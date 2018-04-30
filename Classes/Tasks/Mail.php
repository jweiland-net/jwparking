<?php
namespace JWeiland\Jwparking\Tasks;

/*
 * This file is part of the jwparking project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Mail extends AbstractTask
{

    /**
     * @var \JWeiland\Jwparking\Configuration\ExtConf
     */
    protected $extConf;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * constructor of this class
     */
    public function __construct()
    {
        // first we have to call the parent constructor
        parent::__construct();

        // initialize some global variables
        $this->objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $this->extConf = $this->objectManager->get(\JWeiland\Jwparking\Configuration\ExtConf::class);
    }

    /**
     * The first method which will be executed when task starts
     *
     * @return bool
     */
    public function execute()
    {
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
    public function __wakeup()
    {
        $this->objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $this->extConf = $this->objectManager->get(\JWeiland\Jwparking\Configuration\ExtConf::class);
    }

    /**
     * the result of serialization is too big for db. So we reduce the return value
     *
     * @return array
     */
    public function __sleep()
    {
        return ['scheduler', 'taskUid', 'disabled', 'execution', 'executionTime'];
    }
}
