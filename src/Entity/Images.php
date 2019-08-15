<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadUserImageActionController;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 * @ApiResource(
 *   attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)"},
 *          "delete"={
 *                  "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)"
 *                   }
 *     },
 *     collectionOperations={
 *     "get"={
 *             "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)",
 *            "normalization_context"={"groups"={"get_images"}}
 *           },
 *     "post"={
 *            "access_control"="is_granted('ROLE_SUBADMIN')",
 *             "method"="POST",
 *             "path"="/images/user",
 *             "controller"=UploadUserImageActionController::class,
 *             "defaults"={"_api_receive"=false}
 *            }
 *     }
 * )
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_images"})
     */
    private $id;

    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="users",fileNameProperty="url")
     * @Assert\NotNull()
     */
    private $file;

    /**
     * @ORM\Column(nullable=true)
     * @Groups({"get-users","get_images","get_invoice"})
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", mappedBy="profilePic", cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getUrl()
    {
        return '/images/users/'.$this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(Users $users): self
    {
        $this->users = $users;

        // set the owning side of the relation if necessary
        if ($this !== $users->getProfilePic()) {
            $users->setProfilePic($this);
        }

        return $this;
    }
}
