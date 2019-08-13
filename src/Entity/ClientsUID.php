<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
 *     },
 *     collectionOperations={
 *      "get"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *          "normalization_context"={"groups"={"get-client-by-uid"}}
 *           }
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ClientsUIDRepository")
 */
class ClientsUID
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-client-by-uid"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"get-client-uid","get-client-by-uid"})
     */
    private $UID;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", inversedBy="clientsUID", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-client-by-uid"})
     */
    private $clients;

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

    public function getClients(): ?Users
    {
        return $this->clients;
    }

    public function setClients(Users $clients): self
    {
        $this->clients = $clients;

        return $this;
    }
}
