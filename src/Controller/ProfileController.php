<?php


namespace App\Controller;


use App\Entity\Itinerary;
use App\Entity\Location;
use App\Entity\Travel;
use App\Entity\UserTravel;
use App\Form\ItineraryType;
use App\Form\TravelType;
use App\Repository\ItineraryRepository;
use App\Repository\TravelRepository;
use App\Repository\UserTravelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    private $travelRepository;

    private $userTravelRepository;

    private $manager;

    public function __construct(TravelRepository $travelRepository, UserTravelRepository $userTravelRepository,
                                EntityManagerInterface $manager)
    {
        $this->travelRepository = $travelRepository;
        $this->userTravelRepository = $userTravelRepository;
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

        $user_travels = $user->getUserTravels();
        $travels = [];

        foreach ($user_travels as $user_travel) {
            $travel = $user_travel->getTravel();
            $travels[] = $travel;
        }

        $travels = $this->travelRepository->findSortedTravels($travels);

        return $this->render("profile/index.html.twig", [
            "current_menu" => "profile",
            "travels" => $travels
        ]);
    }

    /**
     * @Route(path="/profile/{id}", name="profile.edit", requirements={"id": "[0-9]*"})
     * @param int $id
     * @param Request $request
     * @param ItineraryRepository $repository
     * @return Response
     */
    public function edit(int $id, Request $request, ItineraryRepository $repository): Response
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->redirectToRoute("home.index");
        }

        $travel = $this->travelRepository->findOneBy(["id" => $id]);

        if ($travel === null) {
            return $this->redirectToRoute("profile.index");
        }

        $itinerary = $repository->findOneBy(['travel' => $id]);

        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($itinerary);

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

        $itinerary = new Itinerary();

        $location = new Location();
        $itinerary->setLocation($location);

        $travel = new Travel();
        $itinerary->setTravel($travel);

        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($location);
            $this->manager->persist($travel);
            $this->manager->persist($itinerary);

            $this->manager->flush();
            return $this->redirectToRoute("profile.index");
        }

        return $this->render("profile/create.html.twig", [
            "travel" => $itinerary,
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
        if ($user === null) {
            $this->redirectToRoute("home.index");
        }

        $user_travel = $this->manager->getRepository("App:UserTravel")->findOneBy([
            'user' => $user,
            'travel' => $travel
        ]);

        $this->manager->remove($user_travel);
        $this->manager->remove($travel);

        $this->manager->flush();

        return $this->redirectToRoute("profile.index");
    }
}