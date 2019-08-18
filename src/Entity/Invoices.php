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
 *     normalizationContext={"groups"={"get_invoice"}},
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
 *             "denormalization_context" = { "groups" = {"post"}},
 *             "validation_groups" = {"post"}
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
     * @Groups({"get_invoice"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_invoice"})
     */
    private $clients;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\InvoicePdf", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $pdfFile;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\InvoiceImage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $imageFile;


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
        return $this->clients;
    }

    public function setClients(?Users $clients): self
    {
        $this->clients = $clients;

        return $this;
    }

    public function getPdfFile(): ?InvoicePdf
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?InvoicePdf $pdfFile): self
    {
        $this->pdfFile = $pdfFile;

        return $this;
    }

    public function getImageFile(): ?InvoiceImage
    {
        return $this->imageFile;
    }

    public function setImageFile(?InvoiceImage $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}
