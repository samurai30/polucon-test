<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "post" = {
 *              "access_control"="is_granted('ROLE_SUPERADMIN')",
 *              }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SurveyorUIDRepository")
 */
class SurveyorUID
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"get-surveyor-uid"})
     */
    private $UID;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", inversedBy="surveyorUID", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $surveyors;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="surveyorDepartment")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-surveyor-uid"})
     */
    private $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUID(): ?string
    {
        return $this->UID;
    }

    public function setUID(string $UID): self
    {
        $this->UID = $UID;

        return $this;
    }

    public function getSurveyors(): ?Users
    {
        return $this->surveyors;
    }

    public function setSurveyors(Users $surveyors): self
    {
        $this->surveyors = $surveyors;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
