<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *  normalizationContext={"groups"={"favoritesCategoriesRead"}},
 *  collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("articleRead")
     * @Groups("favoritesCategoriesRead")
     * @Groups("userData")
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FavoriteCategories", mappedBy="category", cascade={"persist", "remove"})
     */
    private $favorite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Source", mappedBy="category")
     * @Groups("favoritesCategoriesRead")
     */
    private $sources;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->sources = new ArrayCollection();
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

    public function getFavorite(): ?FavoriteCategories
    {
        return $this->favorite;
    }

    public function setFavorite(FavoriteCategories $favorite): self
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * @return Collection|Source[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(Source $source): self
    {
        if (!$this->sources->contains($source)) {
            $this->sources[] = $source;
            $source->setCategory($this);
        }

        return $this;
    }

    public function removeSource(Source $source): self
    {
        if ($this->sources->contains($source)) {
            $this->sources->removeElement($source);
            // set the owning side to null (unless already changed)
            if ($source->getCategory() === $this) {
                $source->setCategory(null);
            }
        }

        return $this;
    }
}
