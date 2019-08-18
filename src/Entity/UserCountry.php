<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"pagination_enabled"=false},
 *     itemOperations={
 *          "get"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *               "normalization_context"={ "groups" = {"get-country"} }
 *                }
 *      },
 *     collectionOperations={
 *                     "post"={
 *                           "access_control"="is_granted('ROLE_SUPERADMIN')",
 *                            "normalization_context"={ "groups" = {"get-country"} },
 *                            "denormalization_context"={"groups"={"post"}},
 *                            "validation_groups"={"post"}
 *
 *                          },
 *                      "get"={
 *                           "access_control"="is_granted('ROLE_SUBADMIN')",
 *                            "normalization_context"={"groups"={"get-only-country-name"}}
 *                              }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserCountryRepository")
 */
class UserCountry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-country","get-only-country-name"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"get-country","post"})
     */
    private $countryCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get-country","get-users","post","get-only-country-name"})
     */
    private $countryName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="countries")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCountries($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCountries() === $this) {
                $user->setCountries(null);
            }
        }

        return $this;
    }
}
