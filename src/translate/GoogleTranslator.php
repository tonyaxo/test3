<?php declare(strict_types=1);

namespace Bogatyrev\translate;

use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslator implements TranslatorInterface
{
    protected $googleService;

    public function __construct()
    {
        $this->googleService = new GoogleTranslate();
        $this->googleService->setSource('en');
    }

    public function translate(string $source, $destLocale): ?string
    {
        $this->googleService->setTarget($destLocale);
        return $this->googleService->translate($source);
    }
}