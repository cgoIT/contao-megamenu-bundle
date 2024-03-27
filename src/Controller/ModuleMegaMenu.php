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

use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\Database;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\ModuleNavigation;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\Routing\Exception\ExceptionInterface;

class ModuleMegaMenu extends ModuleNavigation
{
    #[\Override]
    protected function renderNavigation($pid, $level = 1, $host = null, $language = null): string
    {
        // Get all active subpages
        $arrSubpages = self::getPublishedSubpagesByPid($pid, $this->showHidden, false);

        if (null === $arrSubpages) {
            return '';
        }

        $items = [];
        $security = System::getContainer()->get('security.helper');
        $blnShowUnpublished = System::getContainer()->get('contao.security.token_checker')->isPreviewMode();

        $objTemplate = new FrontendTemplate($this->navigationTpl ?: 'nav_default');
        $objTemplate->pid = $pid;
        $objTemplate->type = static::class;
        $objTemplate->cssID = $this->cssID; // see #4897
        $objTemplate->level = 'level_'.$level++;
        $objTemplate->module = $this; // see #155

        /*
         * Megamenu (Start)
         */
        $objTemplate->moomenu_pageid = $this->Template->moomenu_id;
        $objTemplate->moomenu_aktiv = $this->Template->moomenu_aktiv;
        $objTemplate->moomenu_activestate = $this->Template->moomenu_activestate;
        $objTemplate->moomenu_fade = $this->Template->moomenu_fade ? 'true' : 'false';
        $objTemplate->moomenu_slide = $this->Template->moomenu_slide ? 'true' : 'false';
        $objTemplate->moomenu_speed = $this->Template->moomenu_speed;
        $objTemplate->moomenu_timeout = $this->Template->moomenu_timeout;
        $objTemplate->moomenu_id = 'mm_'.$this->id;
        $objTemplate->id = $this->id;
        if ($this->Template->moomenu_css) {
            $objCSS = new FrontendTemplate('nav_mm_css');
            $GLOBALS['TL_HEAD'][] = $objCSS->parse();
        }
        /*
         * Megamenu (Ende)
         */

        $db = Database::getInstance();
        $urlGenerator = System::getContainer()->get('contao.routing.content_url_generator');

        // Get page object
        global $objPage;

        // Browse subpages
        foreach ($arrSubpages as ['page' => $objSubpage, 'hasSubpages' => $blnHasSubpages]) {
            $objSubpage->loadDetails();

            // Override the domain (see #3765)
            if (null !== $host) {
                $objSubpage->domain = $host;
            }

            $subitems = '';

            // PageModel->groups is an array after calling loadDetails()
            if (!$objSubpage->protected || $this->showProtected || $security->isGranted(ContaoCorePermissions::MEMBER_IN_GROUPS, $objSubpage->groups)) {
                // Check whether there will be subpages
                if ($blnHasSubpages && (!$this->showLevel || $this->showLevel >= $level || (!$this->hardLimit && ($objPage->id === $objSubpage->id || \in_array($objPage->id, $db->getChildRecords($objSubpage->id, 'tl_page'), true))))) {
                    $subitems = $this->renderNavigation($objSubpage->id, $level, $host, $language);
                }

                if ('forward' === $objSubpage->type) {
                    if ($objSubpage->jumpTo) {
                        $objNext = PageModel::findPublishedById($objSubpage->jumpTo);
                    } else {
                        $objNext = PageModel::findFirstPublishedRegularByPid($objSubpage->id);
                    }

                    // Hide the link if the target page is invisible
                    if (!$objNext instanceof PageModel || (!$objNext->loadDetails()->isPublic && !$blnShowUnpublished)) {
                        continue;
                    }
                }

                try {
                    $href = $urlGenerator->generate($objSubpage);
                } catch (ExceptionInterface) {
                    continue;
                }

                if (str_starts_with((string) $href, 'mailto:')) {
                    $href = StringUtil::encodeEmail($href);
                }

                $items[] = $this->compileNavigationRow($objPage, $objSubpage, $subitems, $href);
            }
        }

        //        // Add classes first and last        if (!empty($items))        { $last
        // = count($items) - 1;             $items[0]['class'] = trim($items[0]['class']
        // . ' first');            $items[$last]['class'] = trim($items[$last]['class'] .
        // ' last');        }

        $objTemplate->items = $items;

        return !empty($items) ? $objTemplate->parse() : '';
    }

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
