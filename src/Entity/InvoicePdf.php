<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\UploadInvoicePdfController;
/**
 * @Vich\Uploadable()
 * @ApiResource(
 *       attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)",
 *          "normalization_context"={"groups"={"get_pdf_invoice"}}
 *          },
 *          "delete"={
 *                  "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)"
 *                   }
 *     },
 *     collectionOperations={
 *       "get"={
 *             "access_control"="is_granted('ROLE_SUBADMIN') or  (is_granted('IS_AUTHENTICATED_FULLY') and object.getUsers() == user)",
 *             "normalization_context"={"groups"={"get_pdf_invoice"}}
 *           },
 *     "post"={
 *            "access_control"="is_granted('ROLE_SUBADMIN')",
 *             "method"="POST",
 *             "path"="/invoices/pdf",
 *             "controller"=UploadInvoicePdfController::class,
 *             "defaults"={"_api_receive"=false}
 *            },
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\InvoicePdfRepository")
 */
class InvoicePdf
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $filePdfUrl;

    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"application/pdf",
     *          "application/x-pdf"},
     *     mimeTypesMessage="Please upload a PDF file"
     * )
     * @Vich\UploadableField(mapping="invoices_pdf",fileNameProperty="filePdfUrl")
     */
    private $file_pdf;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @return mixed
     */
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

    public function getFilePdfUrl(): ?string
    {
        return $this->filePdfUrl;
    }

    public function setFilePdfUrl(string $filePdfUrl): self
    {
        $this->filePdfUrl = $filePdfUrl;

        return $this;
    }
}
