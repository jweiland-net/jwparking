<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'JWeiland.' . $_EXTKEY,
	'Parking',
	array(
		'Parking' => 'list,show'
	),
	// non-cacheable actions
	array(
	)
);

// register eID scripts
$TYPO3_CONF_VARS['FE']['eID_include']['jwparkingGetFreeParking'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jwparking') . 'Classes/Ajax/GetFreeParking.php';
$TYPO3_CONF_VARS['FE']['eID_include']['jwparkingGetParkings'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('jwparking') . 'Classes/Ajax/GetParkings.php';

if (TYPO3_MODE === 'BE') {
	// add scheduler
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['JWeiland\\Jwparking\\Tasks\\Mail'] = array(
		'extension' => $_EXTKEY,
		'title' => 'Send Parking CSV',
		'description' => 'Send Parking CSV by Mail'
	);
}