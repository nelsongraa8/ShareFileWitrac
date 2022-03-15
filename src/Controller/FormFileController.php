<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FormFileType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormFileController extends AbstractController
{
    #[Route('/formfile', name: 'app_form_file')]
    public function index(): Response
    {
        $file = new File();
        $formFile = $this->createForm(FormFileType::class, $file);

        return $this->render('form_file/index.html.twig', [
            'controller_name' => 'FormFileController',
            'formFile' => $formFile->createView(),
        ]);
    }
}
