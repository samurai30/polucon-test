<?php


namespace App\DataProviders;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\ContextAwareQueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterEagerLoadingExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use App\Entity\Users;
use Doctrine\Common\Persistence\ManagerRegistry;


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

            if ('get-tasks-surveyors' === $operationName){
                $queryBuilder = $repository->createQueryBuilder('o')->andWhere('o.roles = :val')
                    ->setParameter('val', 'ROLE_SURVEYOR' );
            }else{
                $queryBuilder = $repository->createQueryBuilder('o')->andWhere('o.roles != :val')
                    ->setParameter('val', 'ROLE_SUPERADMIN' );
            }

            $queryNameGenerator = new QueryNameGenerator();

            foreach ($this->itemExtensions as $extension) {
                $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName,$context);
                if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName)){
                    return $extension->getResult($queryBuilder);
                }
                if ($extension instanceof PaginationExtension && $extension->supportsResult($resourceClass, $operationName,$context)){
                    return $extension->getResult($queryBuilder,$resourceClass,$operationName,$context);
                }
                if ($extension instanceof FilterExtension){
                    $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName,$context);
                }
                if ($extension instanceof ContextAwareQueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName,$context)){
                    return $extension->getResult($queryBuilder,$resourceClass,$operationName,$context);
                }
                if ($extension instanceof FilterEagerLoadingExtension){
                    $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName,$context);
                }
            }
            return $queryBuilder->getQuery()->getResult();

        }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Users::class === $resourceClass and 'get-users-dashboard' === $operationName or Users::class and 'get-tasks-surveyors' === $operationName;
    }




}