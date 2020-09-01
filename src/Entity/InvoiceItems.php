<?php

namespace App\Entity;

use App\Repository\InvoiceItemsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InvoiceItemsRepository::class)
  * @ORM\HasLifecycleCallbacks()
 */
class InvoiceItems {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Invoices::class, inversedBy="Item")
     * @ORM\JoinColumn(nullable=false)
     */
    private $invoice_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Product;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $Total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int {
        return $this->id;
    }

    public function getInvoiceId(): ?Invoices {
        return $this->invoice_id;
    }

    public function setInvoiceId(?Invoices $invoice_id): self {
        $this->invoice_id = $invoice_id;

        return $this;
    }

    public function getProduct(): ?string {
        return $this->Product;
    }

    public function setProduct(string $Product): self {
        $this->Product = $Product;

        return $this;
    }

    public function getQuantity(): ?int {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getPrice(): ?int {
        return $this->Price;
    }

    public function setPrice(int $Price): self {
        $this->Price = $Price;

        return $this;
    }

    public function getTotal(): ?int {
        return $this->Total;
    }

    public function setTotal(int $Total): self {
        $this->Total = $Total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(LifecycleEventArgs $event) {
        $nowObj = new \DateTime();
        $this->setCreatedAt($nowObj);
    }

}
