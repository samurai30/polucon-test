<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {
 *                  "access_control"="is_granted('ROLE_SUBADMIN')",
 *                   "normalization_context" = { "groups"={"get_dept"} }
 *                  },
 *          "delete"={"access_control"="is_granted('ROLE_SUPERADMIN')"},
 *          "put" =  {"access_control"="is_granted('ROLE_SUPERADMIN')"}
 *     },
 *     collectionOperations={
 *         "get" = {"access_control"="is_granted('ROLE_SUBADMIN')",
 *                  "normalization_context" = { "groups"={"get_dept"} }
 *                  },
 *          "post"= {
 *                  "access_control"="is_granted('ROLE_SUPERADMIN')",
 *                  "normalization_context" = { "groups"={"get_dept"} },
 *                  "denormalization_context" = { "groups" = {"post_dept"}}
 *                  }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_dept"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get-surveyor-uid","get_dept","post_dept"})
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