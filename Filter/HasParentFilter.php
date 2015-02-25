<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch has_parent filter.
 */
class HasParentFilter implements BuilderInterface
{
    use ParametersTrait;

    const USE_QUERY = 'query';
    const USE_FILTER = 'filter';

    /**
     * @var string
     */
    private $parentType;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param string           $parentType
     * @param BuilderInterface $query
     * @param array            $parameters
     * @param string           $dslType
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        $parentType,
        BuilderInterface $query,
        array $parameters = [],
        $dslType = self::USE_FILTER
    ) {
        $this->parentType = $parentType;
        $this->dslType = $dslType;
        $this->query = $query;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'has_parent';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'parent_type' => $this->parentType,
            $this->dslType => [$this->query->getType() => $this->query->toArray()],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}