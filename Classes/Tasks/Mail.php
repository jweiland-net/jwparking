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
use JWeiland\Jwparking\Configuration\ExtConf;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Mail extends AbstractTask
{
    /**
     * The first method which will be executed when task starts
     *
     * @return bool
     */
    public function execute()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ExtConf $extConf */
        $extConf = $objectManager->get(ExtConf::class);

        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mail */
        $mail = new MailMessage();
        $mail->setFrom($extConf->getEmailFromAddress(), $extConf->getEmailFromName());
        $mail->setTo($extConf->getEmailToAddress(), $extConf->getEmailToName());
        $mail->setSubject('CSV-Export Jwparking');
        $mail->attach(\Swift_Attachment::fromPath(PATH_site . $extConf->getFilePath()));
        return (bool)$mail->send();
    }
}
