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
 *                                      "groups"={"get_form_task"}
 *                                       }
 *              }
 *    },
 *   collectionOperations={
 *     "get" = {
 *               "access_control" = "is_granted('ROLE_SUPERADMIN')",
 *              "normalization_context" = {
 *                                      "groups"={"get_form_task"}
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
     * @Groups({"get_form_task"})
     */
    private $id;



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

    /**
     * @ORM\Column(type="json_array")
     * @Groups({"get_form_task","put"})
     */
    private $formDataJson;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormDataJson()
    {
        return $this->formDataJson;
    }


    public function setFormDataJson($formDataJson): void
    {
        $this->formDataJson = $formDataJson;
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
