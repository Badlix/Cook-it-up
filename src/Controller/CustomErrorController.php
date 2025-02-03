<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class CustomErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        if ($statusCode === 404) {
            return $this->render('error/404.html.twig');
        }

        return $this->render('error/error.html.twig', [
            'status_code' => $statusCode,
            'message' => $exception->getMessage(),
        ]);
    }
}
