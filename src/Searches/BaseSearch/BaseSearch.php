<?php

namespace Eerzho\LaravelComponents\Searches\BaseSearch;

use Eerzho\LaravelComponents\Components\DateFormat\DateFormatHelper;
use Eerzho\LaravelComponents\Components\Request\DataTransfer;
use Eerzho\LaravelComponents\Interfaces\Filter\FilterInterface;
use Eerzho\LaravelComponents\Rules\SearchValidateIntegerRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @property Builder     $builder
 * @property array       $searchFields
 * @property string|null $sortField
 * @property string      $filterFolder
 * @property array       $defaultSearchName
 */
abstract class BaseSearch
{
    protected DataTransfer $data;
    private $builder;
    private $searchFields;
    private $sortField;

    protected $filterFolder = 'Filters';
    protected $defaultSearchName = [
        'id',
        'period_created_at',
        'period_updated_at',
    ];

    /**
     * @return string
     */
    abstract protected function getNamespace(): string;

    /**
     * @return string
     */
    abstract protected function getModel(): string;

    /**
     * @return array
     */
    abstract protected function getSorts(): array;

    /**
     * @param DataTransfer $data
     */
    public function __construct(DataTransfer $data)
    {
        $this->data = $data;
    }

    /**
     * @return Builder
     */
    final public function getQuery()
    {
        $builder = $this->getBuilder();

        if ($this->isValidSearch($fields = $this->getSearchFields())) {
            $builder = $this->applySearches($builder, $fields);
        }

        if (in_array(($field = $this->getSortField()), $this->getSorts())) {
            $builder = $this->applySort($builder, $field);
        }

        return $builder;
    }

    /**
     * @param array $fields
     *
     * @return bool
     */
    private function isValidSearch(array $fields): bool
    {
        if (count($fields) && $this->validationRules()) {

            return $this->validateSearchFields($fields);
        }

        return false;
    }

    /**
     * @param array $fields
     *
     * @return bool
     */
    protected function validateSearchFields(array $fields): bool
    {
        $validator = Validator::make($fields, $this->validationRules());

        return !$validator->fails();
    }

    /**
     * @return Builder
     */
    protected function setBuilder()
    {
        return app($this->getModel())->newQuery();
    }

    /**
     * @return Builder
     */
    private function getBuilder()
    {
        return $this->builder ?: $this->builder = $this->setBuilder();
    }

    /**
     * @return array
     */
    protected function setSearchFields(): array
    {
        return $this->data->get('search', []);
    }

    /**
     * @return array
     */
    private function getSearchFields(): array
    {
        return $this->searchFields ?: $this->searchFields = $this->setSearchFields();
    }

    /**
     * @return string|null
     */
    protected function setSortField(): ?string
    {
        return $this->data->get('sort');
    }

    /**
     * @return string|null
     */
    private function getSortField(): ?string
    {
        return $this->sortField ?: $this->sortField = $this->setSortField();
    }

    /**
     * @return string
     */
    protected function getDefaultFilterNamespace(): string
    {
        return __NAMESPACE__;
    }

    /**
     * @param string $queryName
     *
     * @return string
     */
    protected function getFilterFileName(string $queryName): string
    {
        return Str::studly($queryName);
    }

    /**
     * @param Builder $builder
     * @param array   $fields
     *
     * @return Builder
     */
    private function applySearches($builder, array $fields)
    {
        foreach ($fields as $filterName => $value) {

            if (in_array($filterName, $this->defaultSearchName)) {
                $decorator = $this->createFilterDecorator($filterName, true);
            } else {
                $decorator = $this->createFilterDecorator($filterName);
            }

            if (class_exists($decorator)) {
                /** @var FilterInterface $decorator */
                $builder = $decorator::apply($builder, $value);
            }
        }

        return $builder;
    }

    /**
     * @param string $name
     * @param bool   $isDefaultFilter
     *
     * @return string
     */
    private function createFilterDecorator(string $name, bool $isDefaultFilter = false): string
    {
        return ($isDefaultFilter ? $this->getDefaultFilterNamespace() : $this->getNamespace()) . "\\$this->filterFolder\\" . $this->getFilterFileName($name);
    }

    /**
     * @param Builder $builder
     * @param string  $field
     *
     * @return Builder
     */
    private function applySort($builder, string $field)
    {
        if ($isDesc = str_starts_with($field, '-')) {
            $field = substr($field, 1, strlen($field));
        }

        return $this->buildSortQuery($builder, $field, $isDesc);
    }

    /**
     * @param Builder $builder
     * @param string  $field
     * @param bool    $isDesc
     *
     * @return Builder
     */
    protected function buildSortQuery($builder, string $field, bool $isDesc)
    {
        return $builder->orderBy($field, $isDesc ? "desc" : "asc");
    }

    /**
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'id'                         => new SearchValidateIntegerRule(),
            'period_created_at'          => 'array',
            'period_created_at.start_at' => [
                DateFormatHelper::DATETIME_VALIDATOR_FORMAT,
                'before:period_created_at.end_at',
            ],
            'period_created_at.end_at'   => [
                DateFormatHelper::DATETIME_VALIDATOR_FORMAT,
                'after:period_created_at.start_at',
            ],
            'period_updated_at'          => 'array',
            'period_updated_at.start_at' => [
                DateFormatHelper::DATETIME_VALIDATOR_FORMAT,
                'before:period_updated_at.end_at',
            ],
            'period_updated_at.end_at'   => [
                DateFormatHelper::DATETIME_VALIDATOR_FORMAT,
                'after:period_updated_at.start_at',
            ]
        ];
    }
}
