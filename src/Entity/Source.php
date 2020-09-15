<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"favoritesSourcesRead"}},
 *  collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SourceRepository")
 */
class Source
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"favoritesSourcesRead", "favoritesCategoriesRead", "articleRead", "userData"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="source", orphanRemoval=true)
     * @Groups("favoritesSourcesRead")
     * @Groups("favoritesCategoriesRead")
     */
    private $articles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FavoriteSources", mappedBy="source", cascade={"persist", "remove"})
     */
    private $favorite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="sources")
     * @Groups("articleRead")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setSource($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getSource() === $this) {
                $article->setSource(null);
            }
        }

        return $this;
    }

    public function getFavorite(): ?FavoriteSources
    {
        return $this->favorite;
    }

    public function setFavorite(FavoriteSources $favorite): self
    {
        $this->favorite = $favorite;

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

    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    public function setApiId(string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
