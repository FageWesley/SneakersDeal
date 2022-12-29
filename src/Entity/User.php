<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'customers')]
    private Collection $buyedProducts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProductLike::class, orphanRemoval: true)]
    private Collection $productLikes;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->buyedProducts = new ArrayCollection();
        $this->productLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $this->passwordHasher->hashPassword($this, $password);
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getBuyedProducts(): Collection
    {
        return $this->buyedProducts;
    }

    public function addBuyedProduct(Product $buyedProduct): self
    {
        if (!$this->buyedProducts->contains($buyedProduct)) {
            $this->buyedProducts->add($buyedProduct);
            $buyedProduct->addCustomer($this);
        }

        return $this;
    }

    public function removeBuyedProduct(Product $buyedProduct): self
    {
        if ($this->buyedProducts->removeElement($buyedProduct)) {
            $buyedProduct->removeCustomer($this);
        }

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
            $productLike->setUser($this);
        }

        return $this;
    }

    public function removeProductLike(ProductLike $productLike): self
    {
        if ($this->productLikes->removeElement($productLike)) {
            // set the owning side to null (unless already changed)
            if ($productLike->getUser() === $this) {
                $productLike->setUser(null);
            }
        }

        return $this;
    }
}
