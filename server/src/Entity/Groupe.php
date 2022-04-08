<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="groupes")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=ElementFormation::class, mappedBy="groupes")
     */
    private Collection $elementFormations;

    /**
     * Groupe constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->elementFormations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $elementFormation->addGroupe($this);
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
            $elementFormation->removeGroupe($this);
        }

        return $this;
    }
}
