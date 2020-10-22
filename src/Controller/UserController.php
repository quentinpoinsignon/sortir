<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\User;
use App\Form\UserEditFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class UserController
 * @package App\Controller
 */

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user_index", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/user_show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/{id}/user_edit", name="admin_user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     *
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form= $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}/user_delete", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @author quentin
     * ptite fonction pour consulter le profil d'un autre utilisateur en tant qu'user
     *  @Route("/user_basic_show/{id}", name="user_basic_show", methods={"GET"})
     */
    public function basicShow(int $id, User $user, Event $event, EntityManagerInterface $entityManager)
    {
        $registrationRepository = $entityManager->getRepository(Registration::class);
        $registrations = $registrationRepository->findAll();

        return $this->render('user/basic_show.html.twig', [
            'user' => $user,
            'event' => $event,
            'registrations' => $registrations,
        ]);
    }

    /**
     * @author quentin
     * ptite fonction pour modifier son profil
     *  @Route("/user_edit/{id}", name="simple_user_edit", methods={"GET", "POST"})
     */
    public function userEdit(User $user, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $userEditForm= $this->createForm(UserEditFormType::class, $user);
        $userEditForm->handleRequest($request);
        //sauvegarde dans la base
        if ($userEditForm->isSubmitted() && $userEditForm->isValid()) {
            $pictureFile = $userEditForm->get('pictureFilename')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = 'profile-'.$user->getUsername().'.'.$pictureFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('profile_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPictureFilename($newFilename);
            }

            // ... persist the $product variable or any other work
            //sauvegarde en base
            $entityManager->persist($user);
            $entityManager->flush();
            //retour maison
            return $this->redirectToRoute('home');
        }

        return $this->render('user/user_edit.html.twig', [
            'user' => $user,
            'userEditFormType' => $userEditForm->createView(),
        ]);
    }

}
