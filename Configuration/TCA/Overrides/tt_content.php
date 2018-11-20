<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['jwparking_parking'] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['jwparking_parking'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'jwparking_parking',
    'FILE:EXT:jwparking/Configuration/FlexForms/Parking.xml'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'JWeiland.jwparking',
    'Parking',
    'Parking'
);
