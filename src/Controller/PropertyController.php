<?php


namespace App\Controller;


use App\Entity\PropertyEntity;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * PropertyController constructor.
     * @param PropertyRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route(path="/property", name="property")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render("property/index.html.twig", [
            "current_menu" => "property"
        ]);
    }

    /**
     * @Route(path="/property/{slug}-{id}", name="property.show", requirements={"slug": "[A-Za-z0-9\-]*"})
     * @param PropertyEntity $property
     * @param string $slug
     * @return Response
     */
    public function show(PropertyEntity $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute(
                "property.show", [
                    'slug' => $property->getSlug(),
                    'id' => $property->getId()
                ], 301);
        }
        return $this->render("property/show.html.twig", [
            "current_menu" => "property",
            "property" => $property
        ]);
    }
}