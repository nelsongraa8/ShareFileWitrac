<?php

namespace App\Controller\File;

use App\Entity\File;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListFileController extends AbstractController
{
    #[Route('/', name: 'app_list_file')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $files = $managerRegistry->getRepository(File::class)
            ->findAll();

        return $this->render('list_file/index.html.twig', [
            'files' => $files,
        ]);
    }
}
