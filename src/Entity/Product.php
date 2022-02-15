<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $name;

    #[ORM\Column(type: 'string', length: 45)]
    private $img;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'string', length: 45)]
    private $category;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $height;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $width;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $length;

    #[ORM\ManyToOne(targetEntity: Types::class, inversedBy: 'products')]
    private $types;

    #[ORM\ManyToOne(targetEntity: Size::class, inversedBy: 'products')]
    private $size;

    #[ORM\ManyToOne(targetEntity: Color::class, inversedBy: 'products')]
    private $color;

    #[ORM\ManyToOne(targetEntity: Angle::class, inversedBy: 'products')]
    private $angle;

    #[ORM\ManyToOne(targetEntity: Drilling::class, inversedBy: 'products')]
    private $drilling;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
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

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getTypes(): ?Types
    {
        return $this->types;
    }

    public function setTypes(?Types $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getAngle(): ?Angle
    {
        return $this->angle;
    }

    public function setAngle(?Angle $angle): self
    {
        $this->angle = $angle;

        return $this;
    }

    public function getDrilling(): ?Drilling
    {
        return $this->drilling;
    }

    public function setDrilling(?Drilling $drilling): self
    {
        $this->drilling = $drilling;

        return $this;
    }
}
