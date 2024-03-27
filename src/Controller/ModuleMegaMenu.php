<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\MegaMenuBundle\Controller;

use Contao\Environment;
use Contao\ModuleNavigation;
use Contao\PageModel;

class ModuleMegaMenu extends ModuleNavigation
{
    /**
     * @return array<mixed>
     */
    #[\Override]
    protected function compileNavigationRow(PageModel $objPage, PageModel $objSubpage, $subitems, $href): array
    {
        $row = parent::compileNavigationRow($objPage, $objSubpage, $subitems, $href);

        // Use the path without query string to check for active pages (see #480)
        [$path] = explode('?', (string) Environment::get('requestUri'), 2);

        $blnMultiMode = false;

        // Active page
        if (($objPage->id === $objSubpage->id || ('forward' === $objSubpage->type && $objPage->id === $objSubpage->jumpTo)) && $href === $path) {
            $blnMultiMode = true;
        }

        $row['megamenu'] = $objSubpage->megamenu;
        $row['megamenu_article'] = $objSubpage->megamenu ? $this->getArticle($objSubpage->mm_article, $blnMultiMode, true, $objSubpage->mm_col) : '';
        //            $arrCSS = StringUtil::deserialize($objSubpage->mm_cssID, true);
        $row['megamenu_id'] = $objSubpage->mm_cssID[0];
        $row['megamenu_class'] = '' !== $objSubpage->mm_cssID[1] ? ' '.$objSubpage->mm_cssID[1] : '';

        return $row;
    }
}
