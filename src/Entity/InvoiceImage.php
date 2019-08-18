<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\UploadInvoiceController;
/**
 * @Vich\Uploadable()
 * @ApiResource(
 *       attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *     },
 *     normalizationContext={"groups"={"get_image_invoice"}},
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)",
 *          },
 *          "delete"={
 *                  "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)"
 *                   }
 *     },
 *     collectionOperations={
 *       "get"={
 *             "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)",
 *             "normalization_context"={"groups"={"get_image_invoice"}}
 *           },
 *     "post"={
 *            "access_control"="is_granted('ROLE_SUBADMIN')",
 *             "method"="POST",
 *             "path"="/invoices/images",
 *             "controller"=UploadInvoiceController::class,
 *             "defaults"={"_api_receive"=false}
 *            },
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceImageRepository")
 */
class InvoiceImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_image_invoice"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"get_image_invoice"})
     */
    private $fileImageUrl;
    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"},
     *     mimeTypesMessage="Please upload an image."
     * )
     * @Vich\UploadableField(mapping="invoices_images",fileNameProperty="fileImageUrl")
     */
    private $file_image;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime $updatedAt
     */
    protected $updatedAt;


    /**
     * @return mixed
     */
    public function getFileImage()
    {
        return $this->file_image;
    }

    public function setFileImage($file_image): void
    {
        $this->file_image = $file_image;
        if ($file_image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileImageUrl(): ?string
    {
        return '/invoices/images/'.$this->fileImageUrl;
    }

    public function setFileImageUrl(string $fileImageUrl): self
    {
        $this->fileImageUrl = $fileImageUrl;

        return $this;
    }
}
