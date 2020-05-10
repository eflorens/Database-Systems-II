<?php


namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route(path="/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository): Response
    {
        $entities = $repository->findLatest();

        $user = $this->getUser();
        dump($user);

        return $this->render("home.html.twig", [
            "properties" => $entities
        ]);
    }

}