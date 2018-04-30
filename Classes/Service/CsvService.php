<?php
namespace JWeiland\Jwparking\Service;

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
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CsvService implements SingletonInterface
{
    /**
     * @var \JWeiland\Jwparking\Configuration\ExtConf
     */
    protected $extConf;

    /**
     * @var \TYPO3\CMS\Core\Registry
     */
    protected $sysRegistry;

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
     * inject sysRegistry
     *
     * @param \TYPO3\CMS\Core\Registry $sysRegistry
     * @return void
     */
    public function injectSysRegistry(\TYPO3\CMS\Core\Registry $sysRegistry)
    {
        $this->sysRegistry = $sysRegistry;
    }

    /**
     * get data-array from CSV file
     *
     * @return array
     * @throws \Exception
     */
    public function getCsvData()
    {
        $csvData = $this->sysRegistry->get('JWeiland', 'csvData', null);
        if ($csvData === null || $this->isCsvFileModified()) {
            // get fresh data
            $csvData = [];
            $lines = @file($this->extConf->getFilePath());
            foreach ($lines as $key => $line) {
                list($title, $parkings, $occupied, $free, $isOpened) = str_getcsv($line, ',');
                $csvData[] = [
                    'uid' => $key,
                    'title' => $this->overrideTitleIfConfigured((string)utf8_encode($title), $key),
                    'parkings' => (int)$parkings,
                    'occupied' => (int)$occupied,
                    'free' => $isOpened == 0 ? '---' : (int)$free,
                    'isOpened' => (bool)$isOpened,
                    'link' => (int)$this->getLinkForParking($key)
                ];
            }
            $csvData = $this->sortCsvByTitle($csvData);
            $this->sysRegistry->set('JWeiland', 'csvData', $csvData);
        }
        return $csvData;
    }

    /**
     * get free parkings
     *
     * @return array
     * @throws \Exception
     */
    public function getFreeParkings()
    {
        $freeParkings = $this->sysRegistry->get('JWeiland', 'freeParkings', null);
        if ($freeParkings === null || $this->isCsvFileModified()) {
            // get fresh data
            $csvData = $this->getCsvData();
            $freeParkings = 0;
            foreach ($csvData as $parking) {
                $freeParkings += $parking['free'];
            }
            $this->sysRegistry->set('JWeiland', 'freeParkings', $freeParkings);
        }
        return $freeParkings;
    }

    /**
     * Sort CSV data by title
     *
     * @param array $csv
     * @return array
     */
    protected function sortCsvByTitle($csv)
    {
        $titles = [];
        foreach ($csv as $row) {
            $titles[] = (int)substr($row['title'], 1);
        }
        array_multisort($titles, SORT_NUMERIC, SORT_ASC, $csv);
        return $csv;
    }

    /**
     * You can override a special row with help of a textarea in extConf
     * f.e. 5 = new title
     *
     * @param string $title
     * @param int $rowNumber
     * @return string The title
     */
    protected function overrideTitleIfConfigured($title, $rowNumber)
    {
        $parkingTitles = $this->extConf->getParkingTitles();
        if (trim($parkingTitles) !== '') {
            $rows = GeneralUtility::trimExplode(CHR(10), $parkingTitles, true);
            if (count($rows)) {
                foreach ($rows as $row) {
                    list($key, $newTitle) = GeneralUtility::trimExplode('=', $row, false);
                    if ((int)$key === (int)$rowNumber) {
                        return $newTitle;
                    }
                }
            }
        }
        return $title;
    }

    /**
     * You can define target links for each parking in extConf
     * f.e. 5 = 123
     * f.e. 6 = city.html
     *
     * @param int $rowNumber
     * @return string
     */
    protected function getLinkForParking($rowNumber)
    {
        $parkingLinks = $this->extConf->getParkingLinks();
        if (trim($parkingLinks) !== '') {
            $rows = GeneralUtility::trimExplode(CHR(10), $parkingLinks, true);
            if (count($rows)) {
                foreach ($rows as $row) {
                    list($key, $link) = GeneralUtility::trimExplode('=', $row, false);
                    if ((int)$key === (int)$rowNumber) {
                        return $link;
                    }
                }
            }
        }
        return '';
    }

    /**
     * check if csv file was modified
     * throws Exception if file does not exist
     * saves modification date/time to sysRegistry
     *
     * @return bool
     * @throws \Exception
     */
    public function isCsvFileModified()
    {
        $filePath = PATH_site . $this->extConf->getFilePath();
        if (@is_file($filePath)) {
            $maxAllowedModificationDate = filemtime($filePath) + ($this->extConf->getAjaxRefresh());
            if ($GLOBALS['EXEC_TIME'] < $maxAllowedModificationDate) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new \Exception('File not found. Maybe you have forgotten to set CSV-file in extension configuration', 1414596996);
        }
    }
}
