<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'buyedProducts')]
    private Collection $customers;

    #[ORM\Column]
    private ?bool $isReleased = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ReleaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductLike::class, orphanRemoval: true)]
    private Collection $productLikes;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->productLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
    
    /**
     * @return Collection<int, User>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(User $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
        }

        return $this;
    }

    public function removeCustomer(User $customer): self
    {
        $this->customers->removeElement($customer);

        return $this;
    }

    public function isIsReleased(): ?bool
    {
        return $this->isReleased;
    }

    public function setIsReleased(bool $isReleased): self
    {
        
        $this->isReleased = $isReleased;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->ReleaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $ReleaseDate): self
    { 
        $this->ReleaseDate = $ReleaseDate;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, ProductLike>
     */
    public function getProductLikes(): Collection
    {
        return $this->productLikes;
    }

    public function addProductLike(ProductLike $productLike): self
    {
        if (!$this->productLikes->contains($productLike)) {
            $this->productLikes->add($productLike);
            $productLike->setProduct($this);
        }

        return $this;
    }

    public function removeProductLike(ProductLike $productLike): self
    {
        if ($this->productLikes->removeElement($productLike)) {
            // set the owning side to null (unless already changed)
            if ($productLike->getProduct() === $this) {
                $productLike->setProduct(null);
            }
        }

        return $this;
    }
}
