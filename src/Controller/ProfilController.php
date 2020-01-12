<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{slug}/{id}", name="profil")
     */
    public function index($slug, $id)
    {
        //check if route is consitente with the current user

        $user = $this->getUser();

        if ($user && ($user->getSlug() !== $slug || $user->getId() != $id))
            return $this->redirectToRoute('no-permission');

        $form = $this->createForm(UserType::class, $user, [
            'action' => '/profil/' . $slug . '/' . $id . '/save',
            'method' => 'POST',
        ]);

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/{slug}/{id}/save", name="profil_save")
     */
    public function save(Request $request, $slug, $id, UserPasswordEncoderInterface $passwordEncoder) {
        $user = $this->getUser();

        $roles = $user->getRoles();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles($roles);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $this->addFlash('success', 'Votre profil a bien été enregistré !');
        } else {
            $this->addFlash('error', "Une erreur est survenu lors de l'enregistrement");
        }

       return $this->redirectToRoute('profil', ['slug' => $user->getSlug(), 'id' => $user->getId()]);

    }
}
