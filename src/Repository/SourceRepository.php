<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Source;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Source|null find($id, $lockMode = null, $lockVersion = null)
 * @method Source|null findOneBy(array $criteria, array $orderBy = null)
 * @method Source[]    findAll()
 * @method Source[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Source::class);
    }

    /**
     * Create a new Source if there is no source name in the Article table from the database
     *
     * @param string $name
     * @return Source
     */
    public function createOrRetrieve(string $name): Source {
        // Identifies the Source by name
        $source = $this->findOneBy(['name' => $name]);

        // If there is no Source in BDD, creates a new Source
        if ($source === null) {
            $source = new Source();
            $source->setName($name)
                  ->setApiId($name);

            $this->_em->persist($source);
            $this->_em->flush();
        }
        return $source;
    }

    /**
     * Creates a source from given api data
     *
     * @param array $source The source retrieved from the API
     * @param Category $category The category entity previously retrieved from the API data
     * @return integer 0 if source alerady exists, 1 if new source has been persisted
     */
    public function createFromApiData(array $source, Category $category): int
    {
      $sourceEntity = $this->findOneBy(['apiId' => $source['id']]);

      if ($sourceEntity !== null) {
        return 0;
      }

      $sourceEntity = new Source();
      $sourceEntity->setApiId($source['id'])
        ->setLanguage($source['language'])
        ->setCountry($source['country'])
        ->setCategory($category)
        ->setName($source['name']);

      $this->_em->persist($sourceEntity);
      return 1;
    }
}
