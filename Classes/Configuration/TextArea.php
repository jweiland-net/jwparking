<?php
namespace JWeiland\Jwparking\Configuration;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package jwparking
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TextArea
{
    /**
     * Tag builder instance
     *
     * @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder
     */
    protected $tag;

    /**
     * constructor of this class
     */
    public function __construct() {
        $this->tag = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder::class);
    }

    /**
     * render textarea for extConf
     *
     * @param array $parameter
     * @return string
     */
    public function render(array $parameter = []) {
        $this->tag->setTagName('textarea');
        $this->tag->forceClosingTag(true);
        $this->tag->addAttribute('cols', 45);
        $this->tag->addAttribute('rows', 7);
        $this->tag->addAttribute('name', $parameter['fieldName']);
        $this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
        if ($parameter['fieldValue'] !== null) {
            $this->tag->setContent(trim($parameter['fieldValue']));
        }
        return $this->tag->render();
    }
}
