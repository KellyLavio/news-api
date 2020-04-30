<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteSourcesRepository")
 */
class FavoriteSources extends Favorite
{
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Source", inversedBy="favoriteSources", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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
