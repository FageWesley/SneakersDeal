<?php

namespace App\Entity;

use App\Repository\ProductLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductLikeRepository::class)]
class ProductLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity:'Product',inversedBy: 'productLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $product ;

    #[ORM\ManyToOne(targetEntity:'User',inversedBy: 'productLikes')]
    #[ORM\JoinColumn(nullable: false)]
    private $user ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
