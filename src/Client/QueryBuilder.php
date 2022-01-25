<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Client;

use Kosv\RandomUser\Interfaces\QueryBuilderInterface;
use Kosv\RandomUser\Url\AbstractBuilder as AbstractUrlBuilder;
use Kosv\RandomUser\Url\Builder as UrlBuilder;

final class QueryBuilder implements QueryBuilderInterface
{
    private UrlBuilder $url;

    public function __construct()
    {
        $this->url = new UrlBuilder();
    }

    public function build(): AbstractUrlBuilder
    {
        return clone $this->url;
    }

    /**
     * @return $this
     */
    public function setExcludeFields(array $fields)
    {
        $this->url->setParam('exc', $fields);
        return $this;
    }

    /**
     * @return $this
     */
    public function setGenderFilter(string $gender)
    {
        $this->url->setParam('gender', [$gender]);
        return $this;
    }

    /**
     * @return $this
     */
    public function setIncludeFields(array $fields)
    {
        $this->url->setParam('inc', $fields);
        return $this;
    }

    /**
     * @return $this
     */
    public function setNationalityFilter(array $nationalities)
    {
        $this->url->setParam('nat', $nationalities);
        return $this;
    }

    /**
     * @return $this
     */
    public function setMaxResult(int $max)
    {
        $this->url->setParam('results', [$max]);
        return $this;
    }

    /**
     * @return $this
     */
    public function setPage(int $page)
    {
        $this->url->setParam('page', [$page]);
        return $this;
    }

    /**
     * @return $this
     */
    public function setPasswordFormat(array $format)
    {
        $this->url->setParam('password', $format);
        return $this;
    }
}
