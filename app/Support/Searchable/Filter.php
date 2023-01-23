<?php

namespace App\Support\Searchable;

use Carbon\Carbon;

class Filter
{
    protected $attribute;

    protected string $filterBy;

    protected $value;

    protected string $operator;

    protected string $likePattern = '%{{value}}%';

    protected bool $endOfDay = false;

    protected bool $startOfDay = false;

    protected bool $isDate = false;

    protected $default;

    public function __construct($attribute, string $operator, ?string $filterBy = null)
    {
        if (is_null($filterBy)) {
            $this->filterBy = $attribute;
        } else {
            $this->filterBy = $filterBy;
        }

        $this->attribute = $attribute;
        $this->operator = $operator;

        $this->setValueFromRequest();
    }

    public static function exact($attribute, ?string $filterBy = null)
    {
        return new self($attribute, '=', $filterBy);
    }

    public static function like($attribute, ?string $filterBy = null)
    {
        return new self($attribute, 'LIKE', $filterBy);
    }

    public static function generic($attribute, string $operator, ?string $filterBy = null)
    {
        return new self($attribute, $operator, $filterBy);
    }

    public static function in($attribute, ?string $filterBy = null)
    {
        return new self($attribute, 'IN', $filterBy);
    }

    public static function gte($attribute, ?string $filterBy = null)
    {
        return new self($attribute, '>=', $filterBy);
    }

    public static function gt($attribute, ?string $filterBy = null)
    {
        return new self($attribute, '>', $filterBy);
    }

    public static function lte($attribute, ?string $filterBy = null)
    {
        return new self($attribute, '<=', $filterBy);
    }

    public static function lt($attribute, ?string $filterBy = null)
    {
        return new self($attribute, '<', $filterBy);
    }

    public function startOfDay()
    {
        $this->startOfDay = true;

        return $this;
    }

    public function castDate()
    {
        $this->isDate = true;

        return $this;
    }

    public function isDate(): bool
    {
        return $this->isDate;
    }

    public function endOfDay()
    {
        $this->endOfDay = true;

        return $this;
    }

    public function likePattern(string $pattern)
    {
        $this->likePattern = $pattern;

        return $this;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    public function filterBy(string $filterBy)
    {
        $this->filterBy = $filterBy;

        return $this;
    }

    public function getFilterBy()
    {
        return $this->filterBy;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        if (!$this->isValid($this->value) && $this->isValid($this->default)) {
            $this->value = $this->default;
        }

        if ($this->endOfDay && $this->value) {
            $this->value = (new Carbon($this->value))->endOfDay();
        }

        if ($this->startOfDay && $this->value) {
            $this->value = (new Carbon($this->value))->startOfDay();
        }

        if ($this->isDate && $this->value) {
            $this->value = new Carbon($this->value);
        }

        return $this->value;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function shouldIgnore(): bool
    {
        return empty($this->value);
    }

    public function isValid($value): bool
    {
        if (is_array($value) && empty($value)) {
            return false;
        }

        return $value != '' || $value !== null;
    }

    public function setValueFromRequest()
    {
        $filters = request()->query('filter', []);

        if (isset($filters[$this->filterBy]) && $this->isValid($filters[$this->filterBy])) {
            $value = $filters[$this->filterBy];

            if ($this->operator === 'LIKE') {
                $value = str_replace('{{value}}', $value, $this->likePattern);
            }

            if ($this->operator === 'IN') {
                $value = explode(',', $value);
            }

            $this->value = $value;
        } else {
            return null;
        }
    }
}
