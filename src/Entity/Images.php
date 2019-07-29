<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadUserImageActionController;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 * @ApiResource(
 *     collectionOperations={
 *     "get"={
 *           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *            "normalization_context"={"groups"={"get_images"}}
 *           },
 *     "post"={
 *            "access_control"="is_granted('ROLE_ADMIN')",
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
     * @Vich\UploadableField(mapping="users",fileNameProperty="url")
     */
    private $file;

    /**
     * @ORM\Column(nullable=true)
     * @Groups({"get-users","get_images"})
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", mappedBy="profilePic", cascade={"persist", "remove"})
     */
    private $users;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
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
