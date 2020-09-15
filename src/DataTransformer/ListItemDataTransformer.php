<?php


namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\FavoriteCategories;
use ApiPlatform\Core\Api\IriConverterInterface;
use App\Dto\ListItem;
use App\Entity\FavoriteSources;

final class ListItemDataTransformer implements DataTransformerInterface
{
    private $iriConverter;

    public function __construct(IriConverterInterface $iriConverter)
    {
        $this->iriConverter = $iriConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($data, string $to, array $context = [])
    {
        if (!$data instanceof FavoriteCategories && !$data instanceof FavoriteSources) {
            return null;
        }

        $output = new ListItem();

        if ($data instanceof FavoriteCategories) {
            
            $output->setValue($this->iriConverter->getIriFromItem($data))
                ->setName($data->getCategory()->getName());
            return $output;
        }

        if ($data instanceof FavoriteSources) {
            $output->setValue($this->iriConverter->getIriFromItem($data))
                ->setName($data->getSource()->getName());
            return $output;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ListItem::class === $to && ($data instanceof FavoriteCategories || $data instanceof FavoriteSources);
    }
}
