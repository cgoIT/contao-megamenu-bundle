<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2025, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\MegaMenuBundle\Tests;

use Cgoit\MegaMenuBundle\CgoitMegaMenuBundle;
use PHPUnit\Framework\TestCase;

class CgoitMegaMenuBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new CgoitMegaMenuBundle();

        $this->assertInstanceOf(CgoitMegaMenuBundle::class, $bundle);
    }
}
