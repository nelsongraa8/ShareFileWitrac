<?php

namespace App\Controller;

use App\Entity\File;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListFileController extends AbstractController
{
    #[Route('/', name: 'app_list_file')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $files = $doctrine->getRepository(File::class)->findAll();

        return $this->render('list_file/index.html.twig', [
            'files' => $files,
        ]);
    }
}
