<?php
namespace JWeiland\Jwparking\Domain\Repository;

/*
 * This file is part of the TYPO3 CMS project.
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

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ParkingRepository
{
    /**
     * @var \JWeiland\Jwparking\Service\CsvService
     */
    protected $csvService;

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
     * find all
     *
     * @return array
     * @throws \Exception
     */
    public function findAll()
    {
        return $this->csvService->getCsvData();
    }

    /**
     * find free parkings
     *
     * @return array
     */
    public function findFreeParkings()
    {
        return $this->csvService->getFreeParkings();
    }
}
