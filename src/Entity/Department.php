<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $DepartmentName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SurveyorUID", mappedBy="department", orphanRemoval=true)
     */
    private $surveyorDepartment;

    public function __construct()
    {
        $this->surveyorDepartment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentName(): ?string
    {
        return $this->DepartmentName;
    }

    public function setDepartmentName(string $DepartmentName): self
    {
        $this->DepartmentName = $DepartmentName;

        return $this;
    }

    /**
     * @return Collection|SurveyorUID[]
     */
    public function getSurveyorDepartment(): Collection
    {
        return $this->surveyorDepartment;
    }

    public function addSurveyorDepartment(SurveyorUID $surveyorDepartment): self
    {
        if (!$this->surveyorDepartment->contains($surveyorDepartment)) {
            $this->surveyorDepartment[] = $surveyorDepartment;
            $surveyorDepartment->setDepartment($this);
        }

        return $this;
    }

    public function removeSurveyorDepartment(SurveyorUID $surveyorDepartment): self
    {
        if ($this->surveyorDepartment->contains($surveyorDepartment)) {
            $this->surveyorDepartment->removeElement($surveyorDepartment);
            // set the owning side to null (unless already changed)
            if ($surveyorDepartment->getDepartment() === $this) {
                $surveyorDepartment->setDepartment(null);
            }
        }

        return $this;
    }
}
