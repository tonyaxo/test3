<?php declare(strict_types=1);

namespace Bogatyrev\translate;

interface TranslatorInterface
{
    public function translate(string $source, $destLocale): ?string;
}
