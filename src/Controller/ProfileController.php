<?php


namespace App\Controller;


use App\Entity\Travel;
use App\Entity\User;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    private $travelRepository;

    private $manager;

    public function __construct(TravelRepository $travelRepository, EntityManagerInterface $manager)
    {
        $this->travelRepository = $travelRepository;
        $this->manager = $manager;
    }

    /**
     * @Route(path="/profile", name="profile.index")
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->redirectToRoute("home.index");
        }

        $travels = $this->travelRepository->findLatestByUser($user);

        return $this->render("profile/index.html.twig", [
            "current_menu" => "profile",
            "travels" => $travels
        ]);
    }

    /**
     * @Route(path="/profile/{id}", name="profile.edit", requirements={"id": "[0-9]*"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->redirectToRoute("home.index");
        }

        $travel = $this->travelRepository->findOneBy(["id" => $id, "user" => $user]);

        if ($travel === null) {
            return $this->redirectToRoute("profile.index");
        }

        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute("profile.index");
        }

        return $this->render("profile/edit.html.twig", [
            "travel" => $travel,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route(path="/profile/create", name="profile.create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->redirectToRoute("home.index");
        }

        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travel->setUser($user);
            $this->manager->persist($travel);
            $this->manager->flush();
            return $this->redirectToRoute("profile.index");
        }

        return $this->render("profile/create.html.twig", [
            "travel" => $travel,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route(path="/profile/delete/{id}", name="profile.delete")
     * @param Travel $travel
     * @return Response
     */
    public function delete(Travel $travel): Response
    {
        $user = $this->getUser();
        if ($user === null || $user->getId() !== $travel->getUser()) {
            $this->redirectToRoute("home.index");
        }

        $this->manager->remove($travel);
        $this->manager->flush();

        return $this->redirectToRoute("profile.index");
     }
}