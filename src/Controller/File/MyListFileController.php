<?php

namespace App\Controller\File;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyListFileController extends AbstractController
{
    #[Route('/mylistfile', name: 'app_my_list_file_controler')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $files = $managerRegistry->getRepository(File::class)
            ->findby(
                [
                    'user' => $this->getUser()
                ]
            );

        return $this->render('my_list_file/index.html.twig', [
            'files' => $files,
        ]);
    }
}
