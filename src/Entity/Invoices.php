<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InvoicesRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("Number",  message="Invoice number already exists")
 */
class Invoices {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $Number;

    /**
     * @ORM\Column(type="date")
     */
    private $IssueDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Name cannot be blank.")
     */
    private $BuyerName;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(message= "Tax ID cannot be blank.")
     * @Assert\Regex(pattern ="^[0-9-]+$",  message="Only number or dashes are allowed")
     */
    private $BuyerTaxID;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Address cannot be blank.")
     */
    private $BuyerAddress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=InvoiceItems::class, mappedBy="invoice_id", orphanRemoval=true)
     */
    private $Item;

    /**
     * @ORM\Column(type="date")
     */
    private $DueDate;

    public function __construct() {
        $this->Item = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNumber(): ?string {
        return $this->Number;
    }

    public function setNumber(string $Number): self {
        $this->Number = $Number;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface {
        return $this->IssueDate;
    }

    public function setIssueDate(\DateTimeInterface $IssueDate): self {
        $this->IssueDate = $IssueDate;

        return $this;
    }

    public function getBuyerName(): ?string {
        return $this->BuyerName;
    }

    public function setBuyerName(string $BuyerName): self {
        $this->BuyerName = $BuyerName;

        return $this;
    }

    public function getBuyerTaxID(): ?string {
        return $this->BuyerTaxID;
    }

    public function setBuyerTaxID(string $BuyerTaxID): self {
        $this->BuyerTaxID = $BuyerTaxID;

        return $this;
    }

    public function getBuyerAddress(): ?string {
        return $this->BuyerAddress;
    }

    public function setBuyerAddress(string $BuyerAddress): self {
        $this->BuyerAddress = $BuyerAddress;

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
    public function prePersist(LifecycleEventArgs $event) {  // run for new objects
        $nowObj = new \DateTime();
        $this->setCreatedAt($nowObj);
        
        if ($this->getIssueDate() == null) { // for loading fixture purpose only
            $this->setIssueDate($nowObj);
        }
        $entityManager = $event->getEntityManager();
        if ($this->getNumber() == null) { // for loading fixture purpose only
            $this->setNumber($this->getNewInvoiceNumber($entityManager));
        }
    }

    private function getNewInvoiceNumber($entityManager): string {
        /* invoice number is auto-generated based on "YYYY/NNNN" format
         * where YYYY is current year and NNNN is running number
         * NNNN is computed based on the last number in the database + 1
        */
        $repo = $entityManager->getRepository(Invoices::class);
        $lastNumberInvoiceObj = $repo->getXLatestRecords(0, 1);
        $thisYear = date("Y");
        $isFirstInvoceOfTheYear = false;

        if (empty($lastNumberInvoiceObj)) { // no data in the database -  in that case use 0001 of the current year
            $isFirstInvoceOfTheYear = true;
        } else {
            $lastNumber = $lastNumberInvoiceObj[0]->getNumber();
            $lastNumberArr = explode("/", $lastNumber);
            if ($lastNumberArr[0] == $thisYear) {
                $runningNumberStr = ltrim($lastNumberArr[1], '0') + 1;  //this is for the same year then assign a next number 
                $newNumberStr = $thisYear . '/' . str_pad($runningNumberStr, 4, '0', STR_PAD_LEFT); // make 4 digit numbe by padding 0 
            } else {//first invoice of the year
                $isFirstInvoceOfTheYear = true;
       
            }
        }
        if($isFirstInvoceOfTheYear) {
            $newNumberStr = $thisYear . '/0001';
        }
        
        return $newNumberStr;
    }

    /**
     * @return Collection|InvoiceItems[]
     */
    public function getItems(): Collection {
        return $this->Item;
    }

    public function addItem(InvoiceItems $item): self {
        if (!$this->Item->contains($item)) {
            $this->Item[] = $item;
            $item > setInvoiceId($this);
        }

        return $this;
    }

    public function removeItem(InvoiceItems $item): self {
        if ($this->Item > contains($item)) {
            $this->Item->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getInvoiceId() === $this) {
                $item->setInvoiceId(null);
            }
        }

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->DueDate;
    }

    public function setDueDate(\DateTimeInterface $DueDate): self
    {
        $this->DueDate = $DueDate;

        return $this;
    }

}