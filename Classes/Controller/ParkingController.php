<?php
namespace JWeiland\Jwparking\Controller;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParkingController extends ActionController
{
    /**
     * @var \JWeiland\Jwparking\Configuration\ExtConf
     */
    protected $extConf;

    /**
     * @var \JWeiland\Jwparking\Service\CsvService
     */
    protected $csvService;

    /**
     * @var \JWeiland\Jwparking\Domain\Repository\ParkingRepository
     */
    protected $parkingRepository;

    /**
     * inject extConf
     *
     * @param \JWeiland\Jwparking\Configuration\ExtConf $extConf
     * @return void
     */
    public function injectExtConf(\JWeiland\Jwparking\Configuration\ExtConf $extConf)
    {
        $this->extConf = $extConf;
    }

    /**
     * inject csvService
     *
     * @param \JWeiland\Jwparking\Service\CsvService $csvService
     * @return void
     */
    public function injectCsvService(\JWeiland\Jwparking\Service\CsvService $csvService)
    {
        $this->csvService = $csvService;
    }

    /**
     * inject parkingRepository
     *
     * @param \JWeiland\Jwparking\Domain\Repository\ParkingRepository $parkingRepository
     * @return void
     */
    public function injectParkingRepository(\JWeiland\Jwparking\Domain\Repository\ParkingRepository $parkingRepository)
    {
        $this->parkingRepository = $parkingRepository;
    }

    /**
     * initializes each action method
     *
     * @return void
     */
    public function initializeAction()
    {
        // if this value was not set, then it will be filled with 0
        // but that is not good, because UriBuilder accepts 0 as pid, so it's better to set it to null
        if (empty($this->settings['pidOfDetailPage'])) {
            $this->settings['pidOfDetailPage'] = null;
        }
    }

    /**
     * add some global variables to fluid
     *
     * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
     * @return void
     */
    public function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view)
    {
        $view->assign('ajaxRefresh', (int)($this->extConf->getAjaxRefresh() * 1000));
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('parkings', $this->parkingRepository->findAll());
    }

    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
    }
}
