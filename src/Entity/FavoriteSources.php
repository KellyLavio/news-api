<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Dto\ListItem;

/**
 * @ApiResource(
 *  normalizationContext={"groups"={"favoritesSourcesRead"}},
 *  collectionOperations={
 *      "get",
 *      "list_item"={
 *          "method"="GET",
 *          "path"="/favoriteSources/listItems",
 *          "normalization_context"={"groups"={"listFavoriteSources"}},
 *          "output"=ListItem::class
 *      }
 * }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteSourcesRepository")
 */
class FavoriteSources extends Favorite
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Source", inversedBy="favorite", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("favoritesSourcesRead")
     * @Groups("userData")
     */
    private $source;

    public function getSource(): ?Source
    {
        return $this->source;
    }

    public function setSource(Source $source): self
    {
        $this->source = $source;

        return $this;
    }
}
