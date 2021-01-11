<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Classify;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="index", methods={"GET"})
 */
final class TrainController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse((new Classify())->getScore());
    }
}
