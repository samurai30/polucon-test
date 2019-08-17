<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
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
 *                  "denormalization_context" = { "groups" = {"post_dept"}},
 *                  "validation_groups" ={"post_dept"}
 *                  }
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "DepartmentName" : "exact"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 * @UniqueEntity(fields={"DepartmentName"},groups={"post_dept"},message="This Department already exists")
 */
class Department
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_dept","get-users-surveyor","getTask"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get-surveyor-uid","get_dept","post_dept","get-users-surveyor","getTask"})
     */
    private $DepartmentName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SurveyorUID", mappedBy="department", orphanRemoval=true)
     */
    private $surveyorDepartment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="department", orphanRemoval=true)
     */
    private $Tasks;

    public function __construct()
    {
        $this->surveyorDepartment = new ArrayCollection();
        $this->Tasks = new ArrayCollection();
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

    /**
     * @return Collection|Tasks[]
     */
    public function getTasks(): Collection
    {
        return $this->Tasks;
    }

    public function addTask(Tasks $task): self
    {
        if (!$this->Tasks->contains($task)) {
            $this->Tasks[] = $task;
            $task->setDepartment($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): self
    {
        if ($this->Tasks->contains($task)) {
            $this->Tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getDepartment() === $this) {
                $task->setDepartment(null);
            }
        }

        return $this;
    }
}
