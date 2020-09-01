<?php

namespace App\Entity;

use App\Repository\SystemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=SystemRepository::class)
 */
class System
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Name cannot be blank")
     */
    private $CompanyName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message= "Address cannot be blank")
     */
    private $CompanyAddress;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(message= "Tax ID cannot be blank")
     */
    private $CompanyTaxID;

    /**
     * @ORM\Column(type="string", length=3)
     * @Assert\NotBlank(message= "Default Currency cannot be blank")
     */
    private $DefaultCurrency;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $CompanyAccount;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message= "Company Account cannot be blank")
     */
    private $DefaultVat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): self
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    public function getCompanyAddress(): ?string
    {
        return $this->CompanyAddress;
    }

    public function setCompanyAddress(string $CompanyAddress): self
    {
        $this->CompanyAddress = $CompanyAddress;

        return $this;
    }

    public function getCompanyTaxID(): ?string
    {
        return $this->CompanyTaxID;
    }

    public function setCompanyTaxID(string $CompanyTaxID): self
    {
        $this->CompanyTaxID = $CompanyTaxID;

        return $this;
    }

    public function getDefaultCurrency(): ?string
    {
        return $this->DefaultCurrency;
    }

    public function setDefaultCurrency(string $DefaultCurrency): self
    {
        $this->DefaultCurrency = $DefaultCurrency;

        return $this;
    }

    public function getCompanyAccount(): ?string
    {
        return $this->CompanyAccount;
    }

    public function setCompanyAccount(string $CompanyAccount): self
    {
        $this->CompanyAccount = $CompanyAccount;

        return $this;
    }

    public function getDefaultVat(): ?int
    {
        return $this->DefaultVat;
    }

    public function setDefaultVat(int $DefaultVat): self
    {
        $this->DefaultVat = $DefaultVat;

        return $this;
    }
}
