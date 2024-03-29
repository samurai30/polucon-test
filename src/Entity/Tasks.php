<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\AddFormsController;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ApiResource(
 *     itemOperations={
 *     "get"={
 *               "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                                      "groups"= {"getTask"}
 *                                      }
 *          },
 *     "task-add-form"={
 *                  "access_control"="is_granted('ROLE_SUBADMIN')",
 *                  "method"="POST",
 *                  "path"="/tasks/{id}/add-form/{forms_id}",
 *                  "controller"=AddFormsController::class,
 *                  "denormalization_context"={
 *                                     "groups"= {"post_task"}
 *                                        }
 *                  },
 *     "put" = {
 *               "access_control"="is_granted('ROLE_SUBADMIN')",
 *                "denormalization_context"={
 *                                     "groups"= {"put"}
 *                                        }
 *              },
 *     "delete"={
 *              "access_control" = "is_granted('ROLE_SUPERADMIN')"
 *              },
 *     },
 *     collectionOperations={
 *     "get" = {
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                                      "groups"= {"getTask"}
 *                                      }
 *              },
 *     "post" = {
 *              "access_control"="is_granted('ROLE_SUPERADMIN')",
 *              "normalization_context"={
 *                                      "groups"= {"getTask"}
 *                                      },
 *              "denormalization_context"={
 *                                     "groups"= {"post:task"}
 *                                        },
 *              "validation_groups"={"post"}
 *              }
 *     },
 *     subresourceOperations={
 *                  "api_users_tasks_get_subresource"={
 *                       "access_control" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *                       "normalization_context" = {
 *                                              "groups" = {"getTask"}
 *                                                 }
 *                      },
 *                  "api_users_client_tasks_get_subresource"={
 *                       "access_control" = "is_granted('IS_AUTHENTICATED_FULLY')",
 *                       "normalization_context" = {
 *                                              "groups" = {"getTask"}
 *                                                 }
 *                          }
 *      }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "Title": "word_start",
 *         "status": "exact",
 *         "department.DepartmentName":"exact"
 *
 *          }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TasksRepository")
 */
class Tasks implements SuperAdminInterface,CreatedDateInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getTask","get-users-client","get-users-surveyor"})
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     * @Groups({"post:task","getTask","get-users-client","put","get-users-surveyor"})
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Length(max="10000",min="5",groups={"post"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FormTasks", mappedBy="Tasks", orphanRemoval=true)
     */
    private $Forms;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"post:task","getTask","get-users-client","put","get-users-surveyor"})
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Length(max="70",groups={"post"})
     */
    private $Title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"getTask","get-users-client","get-users-surveyor"})
     */
    private $createdDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Users", inversedBy="Tasks")
     * @ORM\JoinTable(name="tasks_surveyors")
     * @Groups({"getTask","put"})
     */
    private $Users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TaskCategory", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:task","getTask","get-users-client","get-users-surveyor"})
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=30,nullable=true)
     * @Groups({"getTask","get-users-client","get-users-surveyor","put"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="Tasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:task","get-users-surveyor","getTask"})
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="clientTasks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post:task","getTask"})
     */
    private $clients;


    public function __construct()
    {
        $this->Forms = new ArrayCollection();
        $this->Users = new ArrayCollection();
     }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getForms(): Collection
    {
        return $this->Forms;
    }

    public function addForm(FormTasks $form): self
    {
        if (!$this->Forms->contains($form)) {
            $this->Forms[] = $form;
            $form->setTasks($this);
        }

        return $this;
    }

    public function removeForm(FormTasks $form): self
    {
        if ($this->Forms->contains($form)) {
            $this->Forms->removeElement($form);
            // set the owning side to null (unless already changed)
            if ($form->getTasks() === $this) {
                $form->setTasks(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): CreatedDateInterface
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(UserInterface $user): SuperAdminInterface
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
        }

        return $this;
    }

    public function removeUser(UserInterface $user): SuperAdminInterface
    {
        if ($this->Users->contains($user)) {
            $this->Users->removeElement($user);
        }

        return $this;
    }

    public function getCategory(): ?TaskCategory
    {
        return $this->category;
    }

    public function setCategory(?TaskCategory $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getClients(): ?Users
    {
        return $this->clients;
    }

    public function setClients(?Users $clients): self
    {
        $this->clients = $clients;

        return $this;
    }





}
