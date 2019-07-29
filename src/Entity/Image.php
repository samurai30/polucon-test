<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Controller\UploadUserImageActionController;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 * @ApiResource(
 *     collectionOperations={
 *     "get"={
 *           "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
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
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="users",fileNameProperty="url")
     */
    private $file;

    /**
     * @ORM\Column(nullable=true)
     */
    private $url;

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
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
