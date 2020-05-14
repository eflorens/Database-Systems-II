<?php


namespace App\Controller;


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

}