<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $date;

    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, inversedBy="reservations")
     */
    private Collection $salles;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="reservations")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=ElementFormation::class, mappedBy="reservations")
     */
    private Collection $elementFormations;

    /**
     * Reservation constructor.
     */
    public function __construct()
    {
        $this->salles = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->elementFormations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return Reservation
     */
    public function setDate(\DateTime $date): Reservation
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    /**
     * @param Salle $salle
     *
     * @return $this
     */
    public function addSalle(Salle $salle): self
    {
        if (!$this->salles->contains($salle)) {
            $this->salles[] = $salle;
        }

        return $this;
    }

    /**
     * @param Salle $salle
     *
     * @return $this
     */
    public function removeSalle(Salle $salle): self
    {
        $this->salles->removeElement($salle);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|ElementFormation[]
     */
    public function getElementFormations(): Collection
    {
        return $this->elementFormations;
    }

    /**
     * @param ElementFormation $elementFormation
     *
     * @return $this
     */
    public function addElementFormation(ElementFormation $elementFormation): self
    {
        if (!$this->elementFormations->contains($elementFormation)) {
            $this->elementFormations[] = $elementFormation;
            $elementFormation->addReservation($this);
        }

        return $this;
    }

    /**
     * @param ElementFormation $elementFormation
     *
     * @return $this
     */
    public function removeElementFormation(ElementFormation $elementFormation): self
    {
        if ($this->elementFormations->removeElement($elementFormation)) {
            $elementFormation->removeReservation($this);
        }

        return $this;
    }
}
