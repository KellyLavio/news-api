<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *  normalizationContext={"groups"={"favoritesCategoriesRead"}},
 *  collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteCategoriesRepository")
 */
class FavoriteCategories extends Favorite
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Category", inversedBy="favorite", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("favoritesCategoriesRead")
     */
    private $category;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
