<?php declare(strict_types=1);

namespace Bogatyrev\translate;

class DummyTranslator implements TranslatorInterface
{
    public function translate(string $source, $destLocale): ?string
    {
        return $source;
    }
}