<?php

namespace App\Repository\Eloquents;

use App\Repository\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * @param array|string[] $columns
     * @param array $relations
     * @return Collection
     */
    public function allDataTable(array $condition = [], array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->where($condition)->orderBy('id','asc');
    }

    /**
     * @param array|string[] $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->paginate(10,$columns);
    }

    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * @param array $condition
     * @param array $relations
     * @param array|string[] $columns
     * @return Collection
     */

    public function getByCondition(array $condition, array $relations = [], array $columns = ['*']): Collection
    {
        return $this->model->where($condition)->with($relations)->paginate(10,$columns);
    }

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function findById(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);
        $model->update($payload);
        return $model;
    }

    /**
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId, array $relations = []): bool
    {
        $model = $this->findById($modelId);
        if (!$model) {
            return false;
        }
        foreach ($relations as $relation) {
            $this->deleteRelatedModels($model, $relation);
        }
         // Finally, delete the main model
        return $model->delete();
    }

    // Custom Function Start
    public function firstData( array $relations = [], array $conditions = [] , array $columns = ['*'])
    {
        return $this->model->with($relations)->where($conditions)->select($columns)->first();
    }

    public function getByConditionOrder(array $conditions= [], array $relations = [], string $order= null )
    {
        return $this->model->where($conditions)->with($relations)->orderBy($order, 'asc')->get();
    }

    /**
     * Delete related models for a given model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $relation The relationship to delete.
     * @return void
     */
    protected function deleteRelatedModels(Model $model, string $relation): void
    {
        if (!method_exists($model, $relation)) {
            return;
        }

        $relatedQuery = $model->{$relation}();

        // If it's a 'hasMany', 'hasOne', or 'belongsToMany', delete related models
        if ($relatedQuery instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
            $relatedQuery->delete();  // Delete all related records
        } elseif ($relatedQuery instanceof \Illuminate\Database\Eloquent\Relations\HasOne) {
            $relatedQuery->delete();  // Delete the related record
        } elseif ($relatedQuery instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
            $model->{$relation}()->detach();  // Detach many-to-many relationships (doesn't delete pivot data)
        } elseif ($relatedQuery instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
            // For a belongsTo relationship, delete the related model
            $relatedModel = $model->{$relation};
            if ($relatedModel) {
                $relatedModel->delete();
            }
        }
    }

    public function getServerSideDataForSelectOption($search, $conditions = [], $searchColumns = [], $idColumn = 'id', $textColumn = null, $pagination = 10)
    {
        // Dynamically resolve the model using the given model name
        $model = $this->model;
        
        // Start building the query
        $items = $model::query();
    // dd($searchColumns);
        // Apply search filter if provided
        if ($search != '') {
            $items = $items->whereLike($searchColumns, $search);
        }
    
        // Apply dynamic conditions (like bank_id, etc.)
        foreach ($conditions as $column => $value) {
            if ($value) {
                $items = $items->where($column, $value);
            }
        }
    
        // Paginate the results
        $items = $items->paginate($pagination);
    
        // Prepare the response for select options
        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'id'    => $item->{$idColumn}, // Dynamically set the ID
                'text'  => $item->{$textColumn}, // Dynamically set the text
            ];
        }
    
        $data['results'] = $response;
    
        // If there are more results to paginate, add pagination information
        if ($items->hasMorePages()) {
            $data['pagination'] = ['more' => true];
        }
    
        return $data;
    }
    
}
