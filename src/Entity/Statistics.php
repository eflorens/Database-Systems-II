<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatisticsRepository")
 */
class Statistics
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $travel_count;

    /**
     * @ORM\Column(type="integer")
     */
    private $location_count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTravelCount(): ?int
    {
        return $this->travel_count;
    }

    public function setTravelCount(int $travel_count): self
    {
        $this->travel_count = $travel_count;

        return $this;
    }
}
