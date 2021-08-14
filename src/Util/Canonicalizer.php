<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util;

final class Canonicalizer implements CanonicalizerInterface
{
    public function canonicalize(?string $string): ?string
    {
        if (null !== $string) {
            $encoding = mb_detect_encoding($string);

            return mb_detect_encoding($string)
                ? mb_convert_case($string, MB_CASE_LOWER, $encoding)
                : mb_convert_case($string, MB_CASE_LOWER);
        }

        return null;
    }
}
