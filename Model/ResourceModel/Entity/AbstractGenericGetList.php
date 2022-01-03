<?php
/**
 * LeandroRosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://github.com/leandro-rosa for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2021 Leandro Rosa (https://github.com/leandro-rosa)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
declare(strict_types=1);

namespace LeandroRosa\Framework\Model\ResourceModel\Entity;


use Magento\Framework\Api\Search\DocumentInterface;
use Magento\Framework\App\ObjectManager;
use LeandroRosa\Framework\Api\GenericCommandInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;

abstract class AbstractGenericGetList implements GenericCommandInterface
{
    /** @var CollectionProcessorInterface  */
    protected $collectionProcessor;

    protected $collectionFactory;

    /** @var SearchResultsInterfaceFactory  */
    protected $searchResultsFactory;

    /**
     * GenericGetList constructor.
     *
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param array $subject
     *
     * @return DocumentInterface[]
     */
    public function execute(array $subject = [])
    {
        if (empty($subject['criteria']) || ! $subject['criteria'] instanceof SearchCriteriaInterface) {
            throw new \InvalidArgumentException('criteria is not object from \Magento\Framework\Api\SearchCriteriaInterface');
        }

        $criteria = $subject['criteria'];

        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults->getItems();
    }
}
