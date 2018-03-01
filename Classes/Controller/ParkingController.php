<?php
namespace JWeiland\Jwparking\Controller;

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
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParkingController extends ActionController {

	/**
	 * @var \JWeiland\Jwparking\Configuration\ExtConf
	 */
	protected $extConf = NULL;

	/**
	 * @var \JWeiland\Jwparking\Service\CsvService
	 */
	protected $csvService = NULL;

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
	public function injectExtConf(\JWeiland\Jwparking\Configuration\ExtConf $extConf) {
		$this->extConf = $extConf;
	}

	/**
	 * inject csvService
	 *
	 * @param \JWeiland\Jwparking\Service\CsvService $csvService
	 * @return void
	 */
	public function injectCsvService(\JWeiland\Jwparking\Service\CsvService $csvService) {
		$this->csvService = $csvService;
	}

	/**
	 * inject parkingRepository
	 *
	 * @param \JWeiland\Jwparking\Domain\Repository\ParkingRepository $parkingRepository
	 * @return void
	 */
	public function injectParkingRepository(\JWeiland\Jwparking\Domain\Repository\ParkingRepository $parkingRepository) {
		$this->parkingRepository = $parkingRepository;
	}

	/**
	 * initializes each action method
	 *
	 * @return void
	 */
	public function initializeAction() {
		// if this value was not set, then it will be filled with 0
		// but that is not good, because UriBuilder accepts 0 as pid, so it's better to set it to NULL
		if (empty($this->settings['pidOfDetailPage'])) {
			$this->settings['pidOfDetailPage'] = NULL;
		}
	}

	/**
	 * add some global variables to fluid
	 *
	 * @return void
	 */
	public function initializeView() {
		$this->view->assign('siteUrl', GeneralUtility::getIndpEnv('TYPO3_SITE_URL'));
		$this->view->assign('ajaxRefresh', (int)($this->extConf->getAjaxRefresh() * 1000));
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('parkings', $this->parkingRepository->findAll());
	}

	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
	}

}