<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DayRepository::class)
 */
class Day
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot9h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot10h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot11h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot12h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot14h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot15h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot16h;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $slot17h;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="days")
     */
    private $usersOfTheDay;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="days")
     */
    private $gamesOfTheDay;

    public function __construct()
    {
        $this->usersOfTheDay = new ArrayCollection();
        $this->gamesOfTheDay = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlot9h(): ?int
    {
        return $this->slot9h;
    }

    public function setSlot9h(?int $slot9h): self
    {
        $this->slot9h = $slot9h;

        return $this;
    }

    public function getSlot10h(): ?int
    {
        return $this->slot10h;
    }

    public function setSlot10h(?int $slot10h): self
    {
        $this->slot10h = $slot10h;

        return $this;
    }

    public function getSlot11h(): ?int
    {
        return $this->slot11h;
    }

    public function setSlot11h(?int $slot11h): self
    {
        $this->slot11h = $slot11h;

        return $this;
    }

    public function getSlot12h(): ?int
    {
        return $this->slot12h;
    }

    public function setSlot12h(?int $slot12h): self
    {
        $this->slot12h = $slot12h;

        return $this;
    }

    public function getSlot14h(): ?int
    {
        return $this->slot14h;
    }

    public function setSlot14h(?int $slot14h): self
    {
        $this->slot14h = $slot14h;

        return $this;
    }

    public function getSlot15h(): ?int
    {
        return $this->slot15h;
    }

    public function setSlot15h(?int $slot15h): self
    {
        $this->slot15h = $slot15h;

        return $this;
    }

    public function getSlot16h(): ?int
    {
        return $this->slot16h;
    }

    public function setSlot16h(?int $slot16h): self
    {
        $this->slot16h = $slot16h;

        return $this;
    }

    public function getSlot17h(): ?int
    {
        return $this->slot17h;
    }

    public function setSlot17h(?int $slot17h): self
    {
        $this->slot17h = $slot17h;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersOfTheDay(): Collection
    {
        return $this->usersOfTheDay;
    }

    public function addUsersOfTheDay(User $usersOfTheDay): self
    {
        if (!$this->usersOfTheDay->contains($usersOfTheDay)) {
            $this->usersOfTheDay[] = $usersOfTheDay;
        }

        return $this;
    }

    public function removeUsersOfTheDay(User $usersOfTheDay): self
    {
        $this->usersOfTheDay->removeElement($usersOfTheDay);

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesOfTheDay(): Collection
    {
        return $this->gamesOfTheDay;
    }

    public function addGamesOfTheDay(Game $gamesOfTheDay): self
    {
        if (!$this->gamesOfTheDay->contains($gamesOfTheDay)) {
            $this->gamesOfTheDay[] = $gamesOfTheDay;
        }

        return $this;
    }

    public function removeGamesOfTheDay(Game $gamesOfTheDay): self
    {
        $this->gamesOfTheDay->removeElement($gamesOfTheDay);

        return $this;
    }
}
