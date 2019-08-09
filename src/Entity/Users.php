<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\AssignSurveyorController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ResetPasswordAction;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ApiResource(
 *     itemOperations={
 *     "get"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                   "groups"={"get-users"}
 *                          }
 *          },
 *     "put"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *           "denormalization_context"={
 *                                      "groups"={"put"}
 *                                      },
 *          "normalization_context"={
 *                                  "groups"={"get-users"}
 *                                  },
 *           "validation_groups" ={"put"}
 *          },
 *     "put-reset-email"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *          "method"="PUT",
 *          "path"="/users/{id}/reset-email",
 *          "denormalization_context"={
 *                                    "groups"={"put-reset-email"}
 *                                    },
 *          "normalization_context"={
 *                                  "groups"={"get-users"}
 *                                  },
 *           "validation_groups" ={"put-reset-email"}
 *          },
 *      "put-reset-password"={
 *                   "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *                   "method"="PUT",
 *                  "path"="/users/{id}/reset-password",
 *                  "controller"=ResetPasswordAction::class,
 *                  "denormalization_context"={
 *                                       "groups" = {"put-reset-password"}
 *                              },
 *                  "validation_groups" ={"put-reset-password"}
 *     },
 *     "delete"={
 *              "access_control" = "is_granted('ROLE_SUPERADMIN')"
 *              },
 *     "assign-users-task"={
 *               "access_control"="is_granted('ROLE_SUPERADMIN')",
 *                "method"="POST",
 *                "path"="/users/{id}/assign-task/{taskId}",
 *                "controller"=AssignSurveyorController::class
 *                      }
 *     },
 *     collectionOperations={
 *     "post"={
 *              "access_control" = "is_granted('ROLE_SUBADMIN')",
 *              "denormalization_context"={
 *                                          "groups"={"post"}
 *                                         },
 *              "normalization_context"={
 *                                         "groups"={"get-users"}
 *                                      },
 *              "validation_groups" ={"post"}
 *            },
 *     "get" ={
 *              "access_control"="is_granted('ROLE_SUBADMIN')",
 *              "normalization_context"={
 *                                         "groups"={"get-users"}
 *                                      }
 *          },
 *     "get-surveyor-list"={
 *                        "access_control"="is_granted('ROLE_SURVEYOR')",
 *                        "method"="POST",
 *                        "path"="/users/surveyors",
 *                        "normalization_context"={
 *                                              "groups"={"get-users"}
 *                                                }
 *
 *                      },
 *     "get-users-dashboard"={
 *                           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                           "method"="GET",
 *                           "path"="/users/all-users",
 *                           "normalization_context"={
 *                                                  "groups"={"get-users"}
 *                                                },
 *                          "pagination_fetch_join_collection"=true
 *                          },
 *     "get-tasks-surveyors"={
 *                           "access_control"="is_granted('ROLE_SUBADMIN')",
 *                           "method"="GET",
 *                           "path"="/users/surveyors",
 *                           "normalization_context"={
 *                                                  "groups"={"get-users"}
 *                                                },
 *                          "pagination_fetch_join_collection"=true
 *                          }
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "firstName": "partial",
 *         "lastName": "partial",
 *         "username": "exact",
 *         "roles" : "exact"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity(fields={"username"},message="This username is already taken",groups={"post"})
 * @UniqueEntity(fields={"email"},message="This email is already taken",groups={"post"})
 */
class Users implements UserInterface,CreatedDateInterface
{
    const ROLE_SURVEYOR = 'ROLE_SURVEYOR';
    const ROLE_CLIENT = 'ROLE_CLIENT';
    const ROLE_SUBADMIN = 'ROLE_SUBADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';

    const DEFAULT = [self::ROLE_SURVEYOR];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-users","getTask"})
     */
    private $id;

    /**
     * @Assert\NotBlank(groups={"post"})
     * @ORM\Column(type="string", length=120)
     * @Groups({"post","put","get-users","getTask"})
     */
    private $firstName;

    /**
     * @Assert\NotBlank(groups={"post"})
     * @ORM\Column(type="string", length=120)
     * @Groups({"post","put","get-users","getTask"})
     */
    private $lastName;

    /**
     * @Assert\NotBlank(groups={"post"})
     * @ORM\Column(type="string", length=60)
     * @Groups({"post","get-users","getTask"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=70)
     * @Groups({"post"})
     * @Assert\NotBlank(message="Enter password please",groups={"post"})
     * @Assert\Regex(
     *    pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}/",
     *    message="Password must be 6 character long and contains at least one digit, one Upper case letter and one Lower case letter",
     *    groups={"post"}
     *
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"post"})
     * @Assert\Expression(
     *     "this.getPassword() === this.getRetypePassword()",
     *     message="Password does not match",
     *     groups={"post"}
     * )
     */
    private $retypePassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(message="input password please",groups={"put-reset-password"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}/",
     *     message="Password must be 6 character long and contains at least one digit, one Upper case letter and one Lower case letter",
     *     groups={"put-reset-password"}
     * )
     */

    private $newPassword;
    /**
     * @Assert\NotBlank(groups={"put-reset-password"})
     * @Groups({"put-reset-password"})
     * @Assert\Expression(
     *     "this.getNewPassword() === this.getNewRetypePassword()",
     *     message="Password does not match",
     *     groups={"put-reset-password"}
     * )
     */

    private $newRetypePassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups={"put-reset-password"})
     * @UserPassword(groups={"put-reset-password"})
     */
    private $oldPassword;

    /**
     * @ORM\Column(type="simple_array",length=100)
     * @Groups({"get-owner","get-admin","post"})
     * @Assert\NotBlank(groups={"post"})
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"post","get-owner","get-admin","put-reset-email"})
     * @Assert\Email(groups={"post","put-reset-email"})
     * @Assert\NotBlank(groups={"post","put-reset-email"})
     */
    private $email;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $passwordChangeDate;
    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get-users"})
     */
    private $enabled;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tasks", mappedBy="Users")
     * @ApiSubresource()
     * @Groups({"get-users"})
     */
    private $Tasks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserCountry", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post","get-users"})
     * @Assert\NotBlank(groups={"post"})
     */
    private $countries;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-users"})
     *
     */
    private $createdDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Images", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Groups({"post","get-users"})
     */
    private $profilePic;

    public function __construct()
    {
        $this->enabled = false;
        $this->confirmationToken = null;
        $this->Tasks = new ArrayCollection();

    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken($confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function getPasswordChangeDate()
    {
        return $this->passwordChangeDate;
    }

    public function setPasswordChangeDate($passwordChangeDate): void
    {
        $this->passwordChangeDate = $passwordChangeDate;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }


    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    public function getNewRetypePassword()
    {
        return $this->newRetypePassword;
    }

    public function setNewRetypePassword($newRetypePassword): void
    {
        $this->newRetypePassword = $newRetypePassword;
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    public function getRetypePassword()
    {
        return $this->retypePassword;
    }

    public function setRetypePassword($retypePassword): void
    {
        $this->retypePassword = $retypePassword;
    }

    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $task->addUser($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): self
    {
        if ($this->Tasks->contains($task)) {
            $this->Tasks->removeElement($task);
            $task->removeUser($this);
        }

        return $this;
    }

    public function getCountries(): ?UserCountry
    {
        return $this->countries;
    }

    public function setCountries(?UserCountry $countries): self
    {
        $this->countries = $countries;

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

    public function getProfilePic(): ?Images
    {
        return $this->profilePic;
    }

    public function setProfilePic(Images $profilePic): self
    {
        $this->profilePic = $profilePic;

        return $this;
    }

}
