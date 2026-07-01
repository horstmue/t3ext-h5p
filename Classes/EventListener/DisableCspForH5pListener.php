<?php

declare(strict_types=1);

namespace MichielRoos\H5p\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\PolicyMutatedEvent;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;

#[AsEventListener(
    identifier: 'h5p-disable-csp-listener'
)]
final readonly class DisableCspForH5pListener
{
    public function __invoke(PolicyMutatedEvent $event): void
    {
        $request = $event->request;

        if ($request === null) {
            return;
        }

        // Ignorieren, wenn wir uns im Frontend befinden
        if ($event->scope->type->isFrontend()) {
            return;
        }

        $path = $request->getUri()->getPath();

        // Wenn das H5P-Backend-Modul geladen wird
        if (str_contains($path, 'h5p') || str_contains($path, 'H5pModule')) {
            $policy = $event->getCurrentPolicy();

            $policy->mutate(
                // 1. Skripte
                new Mutation(
                    MutationMode::Set,
                    Directive::ScriptSrc,
                    SourceKeyword::self,
                    SourceKeyword::unsafeInline,
                    SourceKeyword::unsafeEval
                ),
                new Mutation(
                    MutationMode::Set,
                    Directive::ScriptSrcElem,
                    SourceKeyword::self,
                    SourceKeyword::unsafeInline,
                    SourceKeyword::unsafeEval
                ),
                // 2. Stylesheets
                new Mutation(
                    MutationMode::Set,
                    Directive::StyleSrc,
                    SourceKeyword::self,
                    SourceKeyword::unsafeInline
                ),
                new Mutation(
                    MutationMode::Set,
                    Directive::StyleSrcElem,
                    SourceKeyword::self,
                    SourceKeyword::unsafeInline
                ),
                // 3. Bilder
                new Mutation(
                    MutationMode::Set,
                    Directive::ImgSrc,
                    SourceKeyword::self,
                    SourceScheme::data,
                    new UriValue('https://hub-api.h5p.org'),
                    new UriValue('https://*.h5p.org'),
                    new UriValue('*.ytimg.com'),
                    new UriValue('*.vimeocdn.com')
                ),
                // 4. NEU: Erlaubt das Setzen der Base-URL auf die eigene Domain
                new Mutation(
                    MutationMode::Set,
                    Directive::BaseUri,
                    SourceKeyword::self
                )
            );
        }
    }
}
