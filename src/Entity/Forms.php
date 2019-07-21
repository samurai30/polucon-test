<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *     "get"={
 *           "access_control"="is_granted('ROLE_SUPERADMIN')",
 *            "normalization_context"={
 *                                    "groups"={"get"}
 *                                   }
 *           }
 *     },
 *     collectionOperations={
 *     "post" = {
 *              "access_control"="is_granted('ROLE_SUPERADMIN')",
 *            "normalization_context"={
 *                                    "groups"={"get"}
 *                                   },
 *            "denormalization_context"={
 *                                    "groups"={"post"}
 *                                      }
 *              },
 *     "get" = {
 *             "access_control" = "is_granted('ROLE_ADMIN')",
 *              "normalization_context"={
 *                                      "groups"={"get"}
 *                                      }
 *              }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FormsRepository")
 */
class Forms
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"post"})
     */
    private $id;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FormTasks", mappedBy="form", orphanRemoval=true)
     */
    private $tasksForm;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"post","get"})
     */
    private $description;

    /**
     * @ORM\Column(type="json_array")
     * @Assert\NotBlank()
     * @Groups({"post","get"})
     */
    private $formDataJson;

    public function __construct()
    {
        $this->tasksForm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|FormTasks[]
     */
    public function getTasksForm(): Collection
    {
        return $this->tasksForm;
    }

    public function addTasksForm(FormTasks $tasksForm): self
    {
        if (!$this->tasksForm->contains($tasksForm)) {
            $this->tasksForm[] = $tasksForm;
            $tasksForm->setForm($this);
        }

        return $this;
    }

    public function removeTasksForm(FormTasks $tasksForm): self
    {
        if ($this->tasksForm->contains($tasksForm)) {
            $this->tasksForm->removeElement($tasksForm);
            // set the owning side to null (unless already changed)
            if ($tasksForm->getForm() === $this) {
                $tasksForm->setForm(null);
            }
        }

        return $this;
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

    public function getFormDataJson()
    {
        return $this->formDataJson;
    }

    public function setFormDataJson($formDataJson): self
    {
        $this->formDataJson = $formDataJson;

        return $this;
    }
}
