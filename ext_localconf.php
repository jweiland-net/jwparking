<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'JWeiland.' . $_EXTKEY,
    'Parking',
    [
        'Parking' => 'list,show'
    ],
    // non-cacheable actions
    []
);

// register eID scripts
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['jwParkingGetFreeParking'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jwparking') . 'Classes/Ajax/GetFreeParking.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['jwParkingGetParkings'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jwparking') . 'Classes/Ajax/GetParkings.php';

// add scheduler
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\JWeiland\Jwparking\Tasks\Mail::class] = [
    'extension' => $_EXTKEY,
    'title' => 'Send Parking CSV',
    'description' => 'Send Parking CSV by Mail'
];
