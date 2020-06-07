<?php


namespace App\Controller;


use App\Entity\Itinerary;
use App\Entity\Location;
use App\Entity\Travel;
use App\Entity\UserTravel;
use App\Form\ItineraryType;
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

        // Get the travel entity associated with the id
        $travel = $this->travelRepository->findOneBy(["id" => $id]);
        $userTravel = $this->userTravelRepository->findOneBy(['travel' => $id]);

        if ($travel === null) {
            return $this->redirectToRoute("profile.index");
        }

        $itineraries = $travel->getItineraries();
        $locations = [];

        foreach ($itineraries as $itinerary) {
            $locations[] = $itinerary->getLocation();
        }

        $data = new Itinerary();
        $data->setTravel($travel);
        $data->setLocation($locations);

        $form = $this->createForm(ItineraryType::class, $data, ['rating' => $userTravel->getRating()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($locations as $location) {
                $this->manager->persist($location);
            }

            $rating = $form->get('rating')->getData();
            $userTravel->setRating($rating);
            $this->manager->persist($userTravel);

            $this->manager->persist($travel);

            $this->manager->flush();
            return $this->redirectToRoute("profile.index");
        }

        return $this->render("profile/edit.html.twig", [
            "travel" => $data,
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

        $data = new Itinerary();

        $location = new Location();
        $locations[] = $location;
        $data->setLocation($locations);

        $form = $this->createForm(ItineraryType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rating = $form->get('rating')->getData();
            $travel = $form->get('travel')->getData();
            $locations = $form->get('location')->getData();

            foreach ($locations as $location) {
                $itinerary = new Itinerary();
                $itinerary->setLocation($location);
                $itinerary->setTravel($travel);

                $this->manager->persist($location);
                $this->manager->persist($itinerary);
            }

            $userTravel = new UserTravel();
            $userTravel
                ->setTravel($travel)
                ->setUser($user)
                ->setRating($rating);

            $this->manager->persist($travel);
            $this->manager->persist($userTravel);

            $this->manager->flush();
            return $this->redirectToRoute("profile.index");
        }

        return $this->render("profile/create.html.twig", [
            "travel" => $data,
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


        dd('Trying to delete travel with id ' . $travel->getId());
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