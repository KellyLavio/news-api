<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\ListItem;


/**
 * @ApiResource(
 *  normalizationContext={"groups"={"favoritesCategoriesRead"}},
 *  collectionOperations={
 *      "get",
 *      "list_item"={
 *          "method"="GET",
 *          "path"="/favoriteCategories/listItems",
 *          "normalization_context"={"groups"={"listFavoriteCategories"}},
 *          "output"=ListItem::class
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteCategoriesRepository")
 */
class FavoriteCategories extends Favorite
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Category", inversedBy="favorite", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("favoritesCategoriesRead")
     * @Groups("userData")
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
