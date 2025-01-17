<?php

declare(strict_types=1);

use Akeneo\CouplingDetector\Configuration\Configuration;
use Akeneo\CouplingDetector\Configuration\DefaultFinder;
use Akeneo\CouplingDetector\RuleBuilder;

$finder = new DefaultFinder();
$finder->notPath('tests');
$builder = new RuleBuilder();

$rules = [
    // Domain layer should only use classes from itself and models from the ServiceAPI
    $builder->only(
        [
            'Akeneo\Catalogs\Domain',
            'Akeneo\Catalogs\ServiceAPI\Model',
        ]
    )->in('Akeneo\Catalogs\Domain'),

    // Application layer should only use classes from Domain, ServiceAPI or itself
    $builder->only(
        [
            'Akeneo\Catalogs\Domain',
            'Akeneo\Catalogs\Application',
            'Akeneo\Catalogs\ServiceAPI\Model',
            'Akeneo\Catalogs\ServiceAPI\Command',
            'Akeneo\Catalogs\ServiceAPI\Query',
        ]
    )->in('Akeneo\Catalogs\Application'),

    // Infrastructure layer can use anything, but we track used dependencies anyway to detect changes
    $builder->only(
        [
            'Akeneo\Catalogs\ServiceAPI',
            'Akeneo\Catalogs\Domain',
            'Akeneo\Catalogs\Application',
            'Akeneo\Catalogs\Infrastructure',

            'Symfony\Component\Config',
            'Symfony\Component\Console',
            'Symfony\Component\DependencyInjection',
            'Symfony\Component\EventDispatcher',
            'Symfony\Component\HttpFoundation',
            'Symfony\Component\HttpKernel',
            'Symfony\Component\Messenger',
            'Symfony\Component\Routing',
            'Symfony\Component\Security',
            'Symfony\Component\Serializer',
            'Symfony\Component\Validator',
            'Doctrine\DBAL',
            'Ramsey\Uuid\Uuid',
            'Akeneo\Platform\Bundle\InstallerBundle',
            'Akeneo\Platform\Bundle\FrameworkBundle\Security\SecurityFacadeInterface',
            'Akeneo\Tool\Component\Api',
            'Akeneo\UserManagement\Component\Model\UserInterface',
            'Akeneo\UserManagement\Component\Repository\UserRepositoryInterface',
            'Akeneo\Connectivity\Connection\ServiceApi',

            // @todo replace with the ones from service API when available
            'Akeneo\Channel\Infrastructure\Component\Model\ChannelInterface',
            'Akeneo\Channel\Infrastructure\Component\Model\LocaleInterface',
            'Akeneo\Channel\Infrastructure\Component\Repository\ChannelRepositoryInterface',
            'Akeneo\Channel\Infrastructure\Component\Repository\LocaleRepositoryInterface',

            // @todo remove
            'Akeneo\Connectivity\Connection\Infrastructure\Apps\Security\ScopeMapperInterface',
            'Akeneo\Pim\Enrichment\Component\Product\Query',
            'Akeneo\Pim\Enrichment\Bundle\Elasticsearch',
            'Akeneo\Tool\Bundle\ElasticsearchBundle\Client',
            'Akeneo\Tool\Component\StorageUtils\Cursor\CursorFactoryInterface',
            'Symfony\Component\OptionsResolver',
            'Akeneo\Pim\Structure\Component\Model\FamilyInterface',
            'Akeneo\Tool\Component\StorageUtils\Repository\SearchableRepositoryInterface',
            'Akeneo\Pim\Structure\Component\Model\AttributeInterface',
            'Akeneo\Pim\Structure\Component\Repository\AttributeRepositoryInterface',
            'Akeneo\Pim\Structure\Component\Model\AttributeOptionInterface',

            // @todo replace with the ones from category service API when available
            'Akeneo\Category\Infrastructure\Component\Classification\Repository\CategoryRepositoryInterface',
            'Akeneo\Category\Infrastructure\Component\Model\CategoryInterface',
            'Akeneo\Category\Infrastructure\Component\Model\CategoryTranslationInterface',
            'Doctrine\Common\Collections\Collection',
            'Akeneo\Category\Api\FindCategoryTrees',
            'Akeneo\Category\Api\CategoryTree',
        ]
    )->in('Akeneo\Catalogs\Infrastructure'),

    // ServiceAPI layer should only use classes from itself, constraints annotations or symfony/messenger
    $builder->only(
        [
            'Akeneo\Catalogs\ServiceAPI',

            // Constraints as Attributes
            'Symfony\Component\Validator\Constraints',
            'Akeneo\Catalogs\Infrastructure\Validation',

            // Message Bus
            'Symfony\Component\Messenger',
        ]
    )->in('Akeneo\Catalogs\ServiceAPI'),
];

$config = new Configuration($rules, $finder);

return $config;
