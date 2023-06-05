<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    // Timestampable trait
    use Timestampable;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CourseProduct::class)]
    private Collection $courseProducts;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Panier::class)]
    private Collection $paniers;

    public function __construct()
    {
        $this->courseProducts = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, CourseProduct>
     */
    public function getCourseProducts(): Collection
    {
        return $this->courseProducts;
    }

    public function addCourseProduct(CourseProduct $courseProduct): self
    {
        if (!$this->courseProducts->contains($courseProduct)) {
            $this->courseProducts->add($courseProduct);
            $courseProduct->setProduct($this);
        }

        return $this;
    }

    public function removeCourseProduct(CourseProduct $courseProduct): self
    {
        if ($this->courseProducts->removeElement($courseProduct)) {
            // set the owning side to null (unless already changed)
            if ($courseProduct->getProduct() === $this) {
                $courseProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduct($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduct() === $this) {
                $panier->setProduct(null);
            }
        }

        return $this;
    }
}
