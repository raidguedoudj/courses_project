<?php

namespace App\Entity;

use App\Repository\CourseProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseProductRepository::class)]
class CourseProduct
{
    /* #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?\App\Entity\Customer $customer = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Price::class)]
    #[Groups(groups: ['Customer:read', 'CustomerPrice:read'])]
    private ?\App\Entity\Price $price = null; */

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'courseProducts')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private ?Course $course = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'courseProducts')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?int $quantity = null;

    /* public function getId(): ?int
    {
        return $this->id;
    } */

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
}
