<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ElementFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={
 *         "normalization_context"={"groups"={"read"}}
 *     },
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 *
 * @ORM\Entity(repositoryClass=ElementFormationRepository::class)
 */
class ElementFormation
{
    /**
     * @Groups("read")
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @Groups("read")
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="elementFormation")
     */
    private Collection $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="elementFormations")
     */
    private Collection $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, inversedBy="elementFormations")
     */
    private Collection $reservations;

    /**
     * @Groups("read")
     *
     * @ORM\ManyToOne(targetEntity=ElementFormation::class, inversedBy="sons", fetch="EAGER")
     */
    private ?ElementFormation $father = null;

    /**
     * @Groups("read")
     *
     * @ORM\OneToMany(targetEntity=ElementFormation::class, mappedBy="father", fetch="EAGER")
     */
    private Collection $sons;

    /**
     * ElementFormation constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->sons = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return ElementFormation
     */
    public function setTitle(string $title): ElementFormation
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * @param Note $note
     *
     * @return $this
     */
    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setElementFormation($this);
        }

        return $this;
    }

    /**
     * @param Note $note
     *
     * @return $this
     */
    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getElementFormation() === $this) {
                $note->setElementFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    /**
     * @param Groupe $groupe
     *
     * @return $this
     */
    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
        }

        return $this;
    }

    /**
     * @param Groupe $groupe
     *
     * @return $this
     */
    public function removeGroupe(Groupe $groupe): self
    {
        $this->groupes->removeElement($groupe);

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    /**
     * @param Reservation $reservation
     *
     * @return $this
     */
    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
        }

        return $this;
    }

    /**
     * @param Reservation $reservation
     *
     * @return $this
     */
    public function removeReservation(Reservation $reservation): self
    {
        $this->reservations->removeElement($reservation);

        return $this;
    }

    /**
     * @return ElementFormation|null
     */
    public function getFather(): ?ElementFormation
    {
        return $this->father;
    }

    /**
     * @param ElementFormation|null $father
     *
     * @return ElementFormation
     */
    public function setFather(?ElementFormation $father = null): ElementFormation
    {
        $this->father = $father;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSons(): Collection
    {
        return $this->sons;
    }

    /**
     * @param ElementFormation $son
     *
     * @return $this
     */
    public function addSon(self $son): self
    {
        if (!$this->sons->contains($son)) {
            $this->sons[] = $son;
            $son->setFather($this);
        }

        return $this;
    }

    /**
     * @param ElementFormation $son
     *
     * @return $this
     */
    public function removeSon(self $son): self
    {
        if ($this->sons->removeElement($son)) {
            // set the owning side to null (unless already changed)
            if ($son->getFather() === $this) {
                $son->setFather(null);
            }
        }

        return $this;
    }
}
