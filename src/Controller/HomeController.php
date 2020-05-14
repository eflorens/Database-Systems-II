<?php


namespace App\Controller;


use App\Entity\Travel;
use App\Repository\TravelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route(path="/", name="home.index")
     * @param TravelRepository $repository
     * @return Response
     */
    public function index(TravelRepository $repository): Response
    {
        $entities = $repository->findLatest();

        return $this->render("home/index.html.twig", [
            "travels" => $entities
        ]);
    }

    /**
     * @Route(path="/show/{slug}-{id}", name="home.show", requirements={"slug": "[A-Za-z0-9\-]*"})
     * @param Travel $travel
     * @param string $slug
     * @return Response
     */
    public function show(Travel $travel, string $slug): Response
    {
        if ($travel->getSlug() !== $slug) {
            return $this->redirectToRoute(
                "home.show", [
                'slug' => $travel->getSlug(),
                'id' => $travel->getId()]
            );
        }
        return $this->render("home/show.html.twig", [
            "travel" => $travel
        ]);
    }

}