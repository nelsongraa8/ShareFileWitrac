<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FormFileType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FormFileController extends AbstractController
{
    private $formFile;
    protected $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private string $fileDir
    ) {
    }

    #[Route('/formfile', name: 'app_form_file')]
    public function index(Request $request): Response
    {
        $this->request = $request;

        $file = new File();

        $this->methodFormView($file);

        if ($this->methodFormSubbmited($file)) {
            return $this->redirectToRoute('app_list_file');
        }

        return $this->render('form_file/index.html.twig', [
            'formFile' => $this->formFile->createView()
        ]);
    }

    /**
     * Método para pasarle el formulario a la plantilla de Twig
     *
     * @param File $file
     * @return void
     */
    private function methodFormView($file): void
    {
        $this->formFile = $this
            ->createForm(
                FormFileType::class,
                $file
            );
    }

    /**
     * Método para resivir el Submit del formulario
     *
     * @param File $file
     * @return boolean
     */
    private function methodFormSubbmited($file)
    {
        $this->formFile->handleRequest(
            $this->request
        );

        if ($this->formFile->isSubmitted() && $this->formFile->isValid()) {
            if ($fileForm = $this->formFile['file']->getData()) {
                $fileFormName = bin2hex(random_bytes(6)) . '.' . $fileForm->guessExtension();

                try {
                    $fileForm->move(
                        $this->fileDir,
                        $fileFormName
                    );
                } catch (FileException $e) {
                    // unable to upload the file
                }

                $file->setfilename($fileFormName);
            }

            $user = $this->getUser();
            $file->setUser($user);

            $this->entityManager->persist($file);
            $this->entityManager->flush();

            return true;
        }
    }
}
