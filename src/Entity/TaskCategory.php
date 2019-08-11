<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *     "get" = {
 *              "access_control" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                                      "groups"= {"getCat"}
 *                                      }
 *              }
 *     },
 *     collectionOperations={
 *     "post" = {
 *              "access_control" = "is_granted('ROLE_ADMIN')",
 *              "denormalization_context"={
 *                                     "groups"= {"post"}
 *                                        },
 *              "validation_groups"={"post"}
 *              },
 *     "get" = {
 *              "access_control" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *               "normalization_context"={
 *                                      "groups"= {"getCat"}
 *                                      }
 *              }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TaskCatagoryRepository")
 * @UniqueEntity(fields={"catagoryName"},message="This Category already exits",groups={"post"})
 */
class TaskCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getCat"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"getCat","post"})
     * @Assert\NotBlank(groups={"post"})
     */
    private $catagoryName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tasks", mappedBy="category", orphanRemoval=true)
     * @Groups({"getCat"})
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatagoryName(): ?string
    {
        return $this->catagoryName;
    }

    public function setCatagoryName(string $catagoryName): self
    {
        $this->catagoryName = $catagoryName;

        return $this;
    }

    /**
     * @return Collection|Tasks[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setCategory($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getCategory() === $this) {
                $task->setCategory(null);
            }
        }

        return $this;
    }
}
