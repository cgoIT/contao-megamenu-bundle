<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

use Contao\Backend;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;

/*
 * Extend palettes
 */
PaletteManipulator::create()
    ->addLegend('megamenu_legend', 'routing_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('megamenu', 'megamenu_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('noLink', 'megamenu', PaletteManipulator::POSITION_AFTER)
    ->applyToPalette('regular', 'tl_page')
    ->applyToPalette('forward', 'tl_page')
    ->applyToPalette('redirect', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'] = array_merge(
    ['megamenu'],
    $GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'],
);

$GLOBALS['TL_DCA']['tl_page']['subpalettes'] = array_merge(
    ['megamenu' => 'mm_article'],
    $GLOBALS['TL_DCA']['tl_calendar']['subpalettes'],
);

/*
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['fields'] = array_merge(
    ['megamenu' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['megamenu'],
        'exclude' => false,
        'inputType' => 'checkbox',
        'eval' => ['mandatory' => false, 'isBoolean' => true, 'submitOnChange' => true],
        'sql' => "char(1) NOT NULL default ''",
    ]],
    ['mm_article' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['mm_article'],
        'inputType' => 'picker',
        'foreignKey' => 'tl_article.title',
        'eval' => ['mandatory' => true, 'tl_class' => 'clr wizard'],
        'sql' => 'int(10) unsigned NOT NULL default 0',
        'relation' => ['type' => 'hasOne', 'load' => 'lazy'],
        'wizard' => [
            ['tl_page_mm', 'editArticle'],
        ],
    ]],
    ['mm_col' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['mm_col'],
        'exclude' => false,
        'inputType' => 'text',
        'eval' => ['mandatory' => false, 'maxlength' => 255, 'decodeEntities' => true],
        'sql' => "varchar(255) NOT NULL default ''",
    ]],
    ['mm_cssID' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['mm_cssID'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['multiple' => true, 'size' => 2],
        'sql' => "varchar(255) NOT NULL default ''",
    ]],
    ['noLink' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['noLink'],
        'exclude' => false,
        'inputType' => 'checkbox',
        'eval' => ['mandatory' => false, 'isBoolean' => true],
        'sql' => "char(1) NOT NULL default ''",
    ]],
);

class tl_page extends Backend
{
    public function editArticle(DataContainer $dc): string
    {
        $title = sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_article']['edit']), $dc->value);

        return $dc->value < 1 ? '' : ' <a href="contao?do=article&amp;table=tl_content&amp;id='.$dc->value.'" title="'.$title.'">'.Image::getHtml('alias.svg', $title, 'style="vertical-align:top;"').'</a>';
    }
}
