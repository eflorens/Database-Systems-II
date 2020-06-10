<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Itinerary
 * @ORM\Entity
 * @ORM\Table(name="itinerary")
 */
class Itinerary
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Travel", inversedBy="itineraries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $travel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Itinerary
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTravel()
    {
        return $this->travel;
    }

    /**
     * @param mixed $travel
     * @return Itinerary
     */
    public function setTravel($travel)
    {
        $this->travel = $travel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return Itinerary
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }
}