<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FormFileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormFileController extends AbstractController
{
    #[Route('/formfile', name: 'app_form_file')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** Presentar el formulario */
        $file = new File();
        $formFile = $this->createForm(FormFileType::class, $file);

        /** Procesar el formulario */
        $formFile->handleRequest($request);
        if ($formFile->isSubmitted() && $formFile->isValid()) {
            $entityManager->persist($file);
            $entityManager->flush();

            return $this->redirectToRoute('app_form_file');
        }

        return $this->render('form_file/index.html.twig', [
            'controller_name' => 'FormFileController',
            'formFile' => $formFile->createView(),
        ]);
    }
}
