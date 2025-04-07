<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['megamenu'] = '{title_legend},name,headline,type;{nav_legend},levelOffset,showLevel,hardLimit,showProtected;{reference_legend:collapsed},defineRoot;{template_legend:collapsed},navigationTpl;{protected_legend:collapsed},protected;{expert_legend:collapsed},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['fields']['navigationTpl']['default'] = 'nav_mm';
