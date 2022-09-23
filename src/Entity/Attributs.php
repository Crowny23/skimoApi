<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AttributsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributsRepository::class)]
#[ApiResource]
class Attributs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $attributs_name = null;

    #[ORM\OneToMany(mappedBy: 'attributs', targetEntity: AttProds::class)]
    private Collection $attProds;

    public function __construct()
    {
        $this->attProds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttributsName(): ?string
    {
        return $this->attributs_name;
    }

    public function setAttributsName(string $attributs_name): self
    {
        $this->attributs_name = $attributs_name;

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
            $attProd->setAttributs($this);
        }

        return $this;
    }

    public function removeAttProd(AttProds $attProd): self
    {
        if ($this->attProds->removeElement($attProd)) {
            // set the owning side to null (unless already changed)
            if ($attProd->getAttributs() === $this) {
                $attProd->setAttributs(null);
            }
        }

        return $this;
    }
}
