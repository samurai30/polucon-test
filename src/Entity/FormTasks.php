<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *     "get" = {
 *              "access_control" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context" = {
 *                                      "groups"={"get"}
 *                                       }
 *              }
 *    },
 *   collectionOperations={
 *     "get" = {
 *               "access_control" = "is_granted('ROLE_SUPERADMIN')",
 *              "normalization_context" = {
 *                                      "groups"={"get"}
 *                                       }
 *              }
 *   }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FormTasksRepository")
 */
class FormTasks
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"get"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tasks", inversedBy="Forms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Tasks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Forms", inversedBy="tasksForm")
     * @ORM\JoinColumn(nullable=false)
     */
    private $form;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTasks(): ?Tasks
    {
        return $this->Tasks;
    }

    public function setTasks(?Tasks $Tasks): self
    {
        $this->Tasks = $Tasks;

        return $this;
    }

    public function getForm(): ?Forms
    {
        return $this->form;
    }

    public function setForm(?Forms $form): self
    {
        $this->form = $form;

        return $this;
    }
}
