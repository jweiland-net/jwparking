<?php
namespace JWeiland\Jwparking\Domain\Repository;

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

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParkingRepository {

	/**
	 * @var \JWeiland\Jwparking\Service\CsvService
	 */
	protected $csvService = NULL;

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
	 * find all
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function findAll() {
		return $this->csvService->getCsvData();
	}

	/**
	 * find free parkings
	 *
	 * @return integer
	 */
	public function findFreeParkings() {
		return $this->csvService->getFreeParkings();
	}

}