<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      attributes={
 *         "order"={"id": "ASC"},
 *         "formats"={"json", "jsonld", "form"={"multipart/form-data"}}
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Clients;


    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"application/pdf",
     *          "application/x-pdf"}
     * )
     * @Vich\UploadableField(mapping="invoices_pdf",fileNameProperty="url_pdf")
     * @Assert\NotNull()
     */
    private $file_pdf;

    /**
     * @Assert\File(
     *     maxSize="4M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="invoices_images",fileNameProperty="url_image")
     * @Assert\NotNull()
     */
    private $file_image;

    /**
     * @ORM\Column(nullable=true)
     */
    private $url_pdf;
    /**
     * @ORM\Column(nullable=true)
     */
    private $url_image;


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
        return $this->url_pdf;
    }

    public function setUrlPdf($url_pdf): void
    {
        $this->url_pdf = $url_pdf;
    }

    public function getUrlImage()
    {
        return $this->url_image;
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
