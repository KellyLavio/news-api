<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ListItem 
{
    /**
     * @Groups("listFavoriteCategories")
     * @Groups("listFavoriteSources")
     */
    private $value;

    /**
     * @Groups("listFavoriteCategories")
     * @Groups("listFavoriteSources")
     */
    private $name;

    public function getValue(): ?string
    {
        return $this->value;
    }
    
    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
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
}