<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Classify;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search", name="search", methods={"GET"})
 */
final class SearchController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse((new Classify())->getSearch(['cifdegera', 'pumgorgo']));
    }
}
