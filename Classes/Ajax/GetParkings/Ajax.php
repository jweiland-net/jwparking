<?php
namespace JWeiland\Jwparking\Ajax\GetParkings;

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
use JWeiland\Jwparking\Ajax\AbstractAjaxRequest;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Ajax extends AbstractAjaxRequest
{
    /**
     * @var \JWeiland\Jwparking\Domain\Repository\ParkingRepository
     */
    protected $parkingRepository;

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
     * process ajax request
     *
     * @return string json encoded parkings
     */
    public function processAjaxRequest()
    {
        return json_encode($this->parkingRepository->findAll());
    }
}
