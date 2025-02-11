<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

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
    ['megamenu' => 'mm_article,mm_cssID'],
    $GLOBALS['TL_DCA']['tl_page']['subpalettes'],
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
        'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
    ]],
    ['mm_article' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['mm_article'],
        'inputType' => 'picker',
        'foreignKey' => 'tl_article.title',
        'eval' => ['mandatory' => true, 'tl_class' => 'clr'],
        'sql' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'default' => 0],
        'relation' => ['type' => 'hasOne', 'load' => 'lazy'],
    ]],
    ['mm_cssID' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['mm_cssID'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['tl_class' => 'w50', 'multiple' => true, 'size' => 2],
        'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
    ]],
    ['noLink' => [
        'label' => &$GLOBALS['TL_LANG']['tl_page']['noLink'],
        'exclude' => false,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12', 'mandatory' => false, 'isBoolean' => true],
        'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
    ]],
    $GLOBALS['TL_DCA']['tl_page']['fields'],
);
