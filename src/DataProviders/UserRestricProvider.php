<?php


namespace App\DataProviders;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use App\Entity\Users;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


class UserRestricProvider implements CollectionDataProviderInterface,RestrictedDataProviderInterface,SerializerAwareDataProviderInterface
{
    use SerializerAwareDataProviderTrait;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;
    /**
     * @var iterable
     */
    private $itemExtensions;


    public function __construct(ManagerRegistry $managerRegistry,iterable $itemExtensions)
    {
        $this->managerRegistry = $managerRegistry;

        $this->itemExtensions = $itemExtensions;
    }

    public function getCollection(string $resourceClass, string $operationName = null,array $context = [])
        {
            $manager = $this->managerRegistry->getManagerForClass($resourceClass);
            $repository = $manager->getRepository($resourceClass);

            $queryBuilder = $repository->createQueryBuilder('o')->andWhere('o.roles != :val')
                ->setParameter('val', 'ROLE_SUPERADMIN' );

            $queryNameGenerator = new QueryNameGenerator();
            foreach ($this->itemExtensions as $extension) {
                $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName);
                if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName)){
                    return $extension->getResult($queryBuilder);
                }
            }
            return $queryBuilder->getQuery()->getResult();

        }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Users::class === $resourceClass and 'get-users-dashboard' === $operationName;
    }




}