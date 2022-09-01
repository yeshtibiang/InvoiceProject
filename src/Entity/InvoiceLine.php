<?php

namespace App\Entity;

use App\Repository\InvoiceLineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceLineRepository::class)]
class InvoiceLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        minMessage: 'The description must be at least {{ limit }} characters long'
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}'
    )]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    #[Assert\Type(
        type: 'numeric',
        message: 'The value {{ value }} is not a valid {{ type }}'
    )]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    #[Assert\Type(
        type: 'numeric',
        message: 'The value {{ value }} is not a valid {{ type }}'
    )]
    #[Assert\Range(
        notInRangeMessage: 'The VAT amount must be between {{ min }} and {{ max }}',
        min: 0,
        max: 100.00
    )]
    private ?string $vatAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    #[Assert\Type(
        type: 'numeric',
        message: 'The value {{ value }} is not a valid {{ type }}'
    )]
    private ?string $totalVat = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    private ?Invoice $invoiceId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getVatAmount(): ?string
    {
        return $this->vatAmount;
    }

    public function setVatAmount(string $vatAmount): self
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getTotalVat(): ?string
    {
        return $this->totalVat;
    }

    public function setTotalVat(string $totalVat): self
    {
        $this->totalVat = $totalVat;

        return $this;
    }

    public function getInvoiceId(): ?Invoice
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(?Invoice $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

}
