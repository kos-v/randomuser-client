<?php

declare(strict_types=1);

namespace Kosv\RandomUser\Url;

abstract class AbstractBuilder
{
    private const LIST_DELIMITER = ',';

    private string $host = '';
    private string $path = '';
    private array $params = [];
    private string $scheme = '';

    public function build(): string
    {
        $url = $this->scheme ? "{$this->scheme}://" : '';
        $url .= $this->host;
        $url .= $this->path ? "/{$this->path}" : '';

        $params = $this->buildParams($this->params);
        if ($params) {
            if (!$this->path) {
                $url .= '/';
            }
            $url .= '?' . $params;
        }

        return $url;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
        return $this;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    public function setParam(string $name, array $vals)
    {
        if (isset($this->params[$name]) && !count($vals)) {
            unset($this->params[$name]);
        }

        $this->params[$name] = $vals;

        return $this;
    }

    public function setScheme(string $scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    private function buildParams(array $params): string
    {
        $params = array_filter($params, function ($v): bool {
            return !empty($v);
        }, \ARRAY_FILTER_USE_BOTH);

        return implode('&', array_map(function ($k, $v): string {
            return $k . '=' . implode(self::LIST_DELIMITER, $v);
        }, array_keys($params), $params));
    }
}
