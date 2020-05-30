<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserTravel
 * @ORM\Entity
 * @ORM\Table(name="user_travel")
 */
class UserTravel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user_travels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Travel", inversedBy="travels_done")
     * @ORM\JoinColumn(nullable=false)
     */
    private $travel;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UserTravel
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return UserTravel
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return UserTravel
     */
    public function setTravel($travel)
    {
        $this->travel = $travel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     * @return UserTravel
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }
}