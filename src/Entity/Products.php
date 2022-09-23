<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product:read']]
)]
#[Get()]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read'])]
    private ?string $product_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $product_desc = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $product_comp = null;

    #[ORM\ManyToMany(targetEntity: SubCategories::class, inversedBy: 'products')]
    #[Groups(['product:read'])]
    private Collection $subcategories;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Stocks $stocks = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Histories $histories = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: RatingComs::class)]
    private Collection $ratingComs;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: AttProds::class)]
    private Collection $attProds;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Images::class)]
    #[Groups(['product:read'])]
    private Collection $images;

    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->ratingComs = new ArrayCollection();
        $this->attProds = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductDesc(): ?string
    {
        return $this->product_desc;
    }

    public function setProductDesc(string $product_desc): self
    {
        $this->product_desc = $product_desc;

        return $this;
    }

    public function getProductComp(): ?string
    {
        return $this->product_comp;
    }

    public function setProductComp(string $product_comp): self
    {
        $this->product_comp = $product_comp;

        return $this;
    }

    /**
     * @return Collection<int, SubCategories>
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(SubCategories $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories->add($subcategory);
        }

        return $this;
    }

    public function removeSubcategory(SubCategories $subcategory): self
    {
        $this->subcategories->removeElement($subcategory);

        return $this;
    }

    public function getStocks(): ?Stocks
    {
        return $this->stocks;
    }

    public function setStocks(?Stocks $stocks): self
    {
        $this->stocks = $stocks;

        return $this;
    }

    public function getHistories(): ?Histories
    {
        return $this->histories;
    }

    public function setHistories(?Histories $histories): self
    {
        $this->histories = $histories;

        return $this;
    }

    /**
     * @return Collection<int, RatingComs>
     */
    public function getRatingComs(): Collection
    {
        return $this->ratingComs;
    }

    public function addRatingCom(RatingComs $ratingCom): self
    {
        if (!$this->ratingComs->contains($ratingCom)) {
            $this->ratingComs->add($ratingCom);
            $ratingCom->setProducts($this);
        }

        return $this;
    }

    public function removeRatingCom(RatingComs $ratingCom): self
    {
        if ($this->ratingComs->removeElement($ratingCom)) {
            // set the owning side to null (unless already changed)
            if ($ratingCom->getProducts() === $this) {
                $ratingCom->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttProds>
     */
    public function getAttProds(): Collection
    {
        return $this->attProds;
    }

    public function addAttProd(AttProds $attProd): self
    {
        if (!$this->attProds->contains($attProd)) {
            $this->attProds->add($attProd);
            $attProd->setProducts($this);
        }

        return $this;
    }

    public function removeAttProd(AttProds $attProd): self
    {
        if ($this->attProds->removeElement($attProd)) {
            // set the owning side to null (unless already changed)
            if ($attProd->getProducts() === $this) {
                $attProd->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProducts($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProducts() === $this) {
                $image->setProducts(null);
            }
        }

        return $this;
    }
}
