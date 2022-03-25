<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\CreateUserType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserController extends AbstractController
{
    protected $request;
    private $formUser;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private ?UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('/createuser', name: 'app_create_user')]
    public function index(Request $request): Response
    {
        $this->request = $request;

        $user = new User();

        $this->methodFormView($user);

        if ($this->methodFormSubbmited($user)) {
            return $this->redirectToRoute('app_list_file');
        }

        return $this->render('create_user/index.html.twig', [
            'controller_name' => 'CreateUserController',
            'form_create_user' => $this->formUser->createView()
        ]);
    }

    /**
     * Método con el que se le pasa el formulario a
     * la plantilla en Twig
     *
     * @param User $user
     * @return void
     */
    private function methodFormView($user)
    {
        $this->formUser = $this
            ->createForm(
                CreateUserType::class,
                $user
            );
    }

    /**
     * Método con el que se procesa el Submit del formulario
     * que se carga desde este mismo controladro en la vista
     *
     * @param User $user
     * @return boolean
     */
    private function methodFormSubbmited($user)
    {
        $this->formUser
            ->handleRequest(
                $this->request
            );

        if ($this->formUser->isSubmitted() && $this->formUser->isValid()) {
            $user->setRoles(['ROLE_USER']);

            $plaintextPassword = $this->formUser['password']->getData();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true; // True para submit en el formulario
        }
    }
}
