<?php

namespace App\Repository;

use App\Entity\FavoriteSources;
use App\Entity\Source;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavoriteSources|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteSources|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteSources[]    findAll()
 * @method FavoriteSources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteSourcesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteSources::class);
    }

    public function create(Source $sourceId)
    {
        $favoriteSource = $this->findOneBy($sourceId);

        if ($favoriteSource === null) {
            $favoriteSource = new FavoriteSources();
            $favoriteSource->setSource($sourceId);

            $this->_em->persist($favoriteSource);
            $this->_em->flush();
        }
        return null;
    }
}
