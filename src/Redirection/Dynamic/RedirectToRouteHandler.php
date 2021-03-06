<?php

namespace AppBundle\Redirection\Dynamic;

use AppBundle\Repository\ArticleRepository;
use AppBundle\Repository\EventRepository;
use AppBundle\Repository\OrderArticleRepository;
use AppBundle\Repository\ProposalRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class RedirectToRouteHandler extends AbstractRedirectTo implements RedirectToInterface
{
    private $provider;
    private $router;
    private $eventRepository;
    private $articleRepository;
    private $proposalRepository;
    private $orderArticleRepository;

    public function __construct(
        RedirectionsProvider $provider,
        RouterInterface $router,
        EventRepository $eventRepository,
        ArticleRepository $articleRepository,
        ProposalRepository $proposalRepository,
        OrderArticleRepository $orderArticleRepository
    ) {
        $this->provider = $provider;
        $this->router = $router;
        $this->eventRepository = $eventRepository;
        $this->articleRepository = $articleRepository;
        $this->proposalRepository = $proposalRepository;
        $this->orderArticleRepository = $orderArticleRepository;
    }

    public function handle(GetResponseForExceptionEvent $event, string $requestUri, string $redirectCode): bool
    {
        foreach ($this->provider->get(RedirectionsProvider::TO_ROUTE) as $pattern => $route) {
            if (!$this->hasPattern($pattern, $requestUri)) {
                continue;
            }

            $urlToRedirect = null;

            if ($this->hasPattern('/article/', $requestUri)) {
                $articleSlug = substr($requestUri, 9);

                if (!$article = $this->articleRepository->findOnePublishedBySlug($articleSlug)) {
                    continue;
                }

                $urlToRedirect = $this->router->generate($route, [
                    'categorySlug' => $article->getCategory()->getSlug(),
                    'articleSlug' => $article->getSlug(),
                ]);
            }

            if ($this->hasPattern('/amp/article/', $requestUri)) {
                $articleSlug = substr($requestUri, 13);

                if (!$article = $this->articleRepository->findOnePublishedBySlug($articleSlug)) {
                    continue;
                }

                $urlToRedirect = $this->router->generate($route, [
                    'categorySlug' => $article->getCategory()->getSlug(),
                    'articleSlug' => $article->getSlug(),
                ]);
            }

            if ($this->hasPattern('/amp/proposition/', $requestUri)) {
                $proposalSlug = substr($requestUri, 17);

                if (!$proposal = $this->proposalRepository->findPublishedProposal($proposalSlug)) {
                    continue;
                }

                $urlToRedirect = $this->router->generate($route, [
                    'slug' => $proposal->getSlug(),
                ]);
            }

            if ($this->hasPattern('/amp/transformer-la-france/', $requestUri)) {
                $orderArticleSlug = substr($requestUri, 27);

                if (!$orderArticle = $this->orderArticleRepository->findPublishedArticle($orderArticleSlug)) {
                    continue;
                }

                $urlToRedirect = $this->router->generate($route, [
                    'slug' => $orderArticle->getSlug(),
                ]);
            }

            $event->setResponse(new RedirectResponse($urlToRedirect, $redirectCode));

            return true;
        }

        return false;
    }
}
