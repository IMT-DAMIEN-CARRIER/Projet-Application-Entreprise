<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $grade;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notes")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=ElementFormation::class, inversedBy="notes")
     */
    private ElementFormation $elementFormation;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getGrade(): float
    {
        return $this->grade;
    }

    /**
     * @param float $grade
     *
     * @return Note
     */
    public function setGrade(float $grade): Note
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Note
     */
    public function setUser(User $user): Note
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ElementFormation
     */
    public function getElementFormation(): ElementFormation
    {
        return $this->elementFormation;
    }

    /**
     * @param ElementFormation $elementFormation
     *
     * @return Note
     */
    public function setElementFormation(ElementFormation $elementFormation): Note
    {
        $this->elementFormation = $elementFormation;

        return $this;
    }
}
