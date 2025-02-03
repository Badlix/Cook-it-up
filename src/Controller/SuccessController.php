<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SuccessController extends AbstractController
{

    #[Route('/success/{productName}', name: 'success')]
    public function index(string $productName): Response
    {
        return $this->render('success/index.html.twig', [
            'product' => $productName,
        ]);
    }
}
