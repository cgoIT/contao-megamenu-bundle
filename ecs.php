<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $year = date('Y');
    $ecsConfig->ruleWithConfiguration(HeaderCommentFixer::class, [
        'header' => <<<EOF
This file is part of cgoit\\contao-megamenu-bundle for Contao Open Source CMS.

@copyright  Copyright (c) $year, cgoIT
@author     cgoIT <https://cgo-it.de>
@license    LGPL-3.0-or-later
EOF
        ,
    ]);
};
