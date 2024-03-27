<?php

declare(strict_types=1);

/*
 * This file is part of cgoit\contao-megamenu-bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2024, cgoIT
 * @author     cgoIT <https://cgo-it.de>
 * @license    LGPL-3.0-or-later
 */

namespace Cgoit\MegaMenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CgoitMegaMenuBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
