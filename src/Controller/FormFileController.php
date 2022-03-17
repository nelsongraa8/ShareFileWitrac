<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FormFileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\User;

class FormFileController extends AbstractController
{
    #[Route('/formfile', name: 'app_form_file')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        string $fileDir
    ): Response {
        /** Presentar el formulario */
        $file = new File();
        $formFile = $this->createForm(FormFileType::class, $file);

        /** Procesar el formulario */
        $formFile->handleRequest($request);
        if ($formFile->isSubmitted() && $formFile->isValid()) {
            if ($fileForm = $formFile['file']->getData()) {
                $fileFormName = bin2hex(random_bytes(6)) . '.' . $fileForm->guessExtension();

                try {
                    $fileForm->move($fileDir, $fileFormName);
                } catch (FileException $e) {
                    // unable to upload the file
                }

                $file->setfilename($fileFormName);
            }

            $user = $this->getUser();
            $file->setUserId($user);

            $entityManager->persist($file);
            $entityManager->flush();

            return $this->redirectToRoute('app_form_file');
        }

        return $this->render('form_file/index.html.twig', [
            'formFile' => $formFile->createView()
        ]);
    }
}
