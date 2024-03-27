<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['megamenu'] = '{title_legend},name,headline,type;{nav_legend},levelOffset,showLevel,hardLimit,showProtected;{megamenu_animated_legend:hide},moomenu_aktiv;{reference_legend:hide},defineRoot;{template_legend:hide},navigationTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'] = array_merge(
    ['moomenu_aktiv'],
    $GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'],
);
$GLOBALS['TL_DCA']['tl_module']['subpalettes'] = array_merge(
    ['moomenu_aktiv' => 'moomenu_activestate, moomenu_timeout, moomenu_speed, moomenu_slide, moomenu_fade, moomenu_css'],
    $GLOBALS['TL_DCA']['tl_module']['subpalettes'],
);
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['default'] = 'nav_mm';

$GLOBALS['TL_DCA']['tl_module']['fields'] = array_merge(
    ['moomenu_aktiv' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_aktiv'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['submitOnChange' => true, 'isBoolean' => true, 'mandatory' => false],
        'sql' => "char(1) NOT NULL default ''",
    ]],
    ['moomenu_activestate' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_activestate'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql' => "varchar(255) NOT NULL default ''",
    ]],
    ['moomenu_slide' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_slide'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50'],
        'sql' => "char(1) NOT NULL default ''",
    ]],
    ['moomenu_fade' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_fade'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50'],
        'sql' => "char(1) NOT NULL default ''",
    ]],
    ['moomenu_speed' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_speed'],
        'exclude' => true,
        'inputType' => 'select',
        'options' => ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
        'default' => '5',
        'eval' => ['tl_class' => 'clr'],
        'sql' => "char(1) NOT NULL default ''",
    ]],
    ['moomenu_timeout' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_timeout'],
        'exclude' => true,
        'inputType' => 'text',
        'default' => 200,
        'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
        'sql' => "varchar(255) NOT NULL default ''",
    ]],
    ['moomenu_css' => [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['moomenu_css'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50'],
        'sql' => "char(1) NOT NULL default ''",
    ]],
);
