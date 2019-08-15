<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\UploadInvoiceController;
/**
 * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getClients() == user)",
 *                "normalization_context" ={"groups"={"get_invoice"}}
 *               },
 *          "delete"={
 *                  "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getClients() == user)"
 *                   }
 *     },
 *     collectionOperations={
 *     "get"={
 *            "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getClients() == user)",
 *             "normalization_context" ={"groups"={"get_invoice"}}
 *           },
 *     "post"={
 *            "access_control"="is_granted('ROLE_SUBADMIN')",
 *             "method"="POST",
 *             "path"="/invoices/pdf",
 *             "controller"=UploadInvoiceController::class,
 *             "defaults"={"_api_receive"=false}
 *            },
 *     "post_image"={
 *            "access_control"="is_granted('ROLE_SUBADMIN')",
 *             "method"="POST",
 *             "path"="/invoices/image",
 *             "controller"=UploadInvoiceController::class,
 *             "defaults"={"_api_receive"=false}
 *            }
 *     },
 *     subresourceOperations={
 *              "api_users_invoices_get_subresource"={
 *                      "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getClients() == user)"
 *                                                  }
 *     }
 * )
 * @Vich\Uploadable()
 * @ORM\Entity(repositoryClass="App\Repository\InvoicesRepository")
 */
class Invoices
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_invoice"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     * @Groups({"get_invoice","get-users-client"})
     */
    private $status;
    /**
     * @ORM\Column(nullable=true)
     * @Groups({"get_invoice","get-users-client"})
     */
    private $url_pdf;
    /**
     * @ORM\Column(nullable=true)
     * @Groups({"get_invoice","get-users-client"})
     */
    private $url_image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_invoice"})
     */
    private $Clients;

    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"application/pdf",
     *          "application/x-pdf"},
     *     mimeTypesMessage="Please upload a PDF file"
     * )
     * @Vich\UploadableField(mapping="invoices_pdf",fileNameProperty="url_pdf")
     * @var File $file_pdf
     */
    private $file_pdf;

    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"},
     *     mimeTypesMessage="Please upload an image."
     * )
     * @Vich\UploadableField(mapping="invoices_images",fileNameProperty="url_image")
     * @var File $file_image
     */
    private $file_image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime $updatedAt
     */
    protected $updatedAt;


    public function getFilePdf()
    {
        return $this->file_pdf;
    }

    public function setFilePdf($file_pdf): void
    {
        $this->file_pdf = $file_pdf;
        if ($file_pdf) {
            $this->updatedAt = new \DateTime('now');
        }
    }

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

    public function getUrlPdf()
    {
        if($this->url_pdf){
            return '/clients/invoices/pdf/'.$this->url_pdf;
        }
        return null;
    }

    public function setUrlPdf($url_pdf): void
    {
        $this->url_pdf = $url_pdf;
    }

    public function getUrlImage()
    {
        if ($this->url_image){
            return '/clients/invoices/images/'.$this->url_image;
        }
        return null;
    }

    public function setUrlImage($url_image): void
    {
        $this->url_image = $url_image;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getClients(): ?Users
    {
        return $this->Clients;
    }

    public function setClients(?Users $Clients): self
    {
        $this->Clients = $Clients;

        return $this;
    }

}
