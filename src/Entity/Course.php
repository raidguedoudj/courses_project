<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseProduct::class)]
    private Collection $courseProducts;

    public function __construct()
    {
        $this->courseProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $courseProduct->setCourse($this);
        }

        return $this;
    }

    public function removeCourseProduct(CourseProduct $courseProduct): self
    {
        if ($this->courseProducts->removeElement($courseProduct)) {
            // set the owning side to null (unless already changed)
            if ($courseProduct->getCourse() === $this) {
                $courseProduct->setCourse(null);
            }
        }

        return $this;
    }
}
