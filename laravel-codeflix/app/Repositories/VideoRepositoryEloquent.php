<?php

namespace CodeFlix\Repositories;

use CodeFlix\Media\ThumbUploads;
use CodeFlix\Media\Uploads;
use CodeFlix\Media\VideoUploads;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFlix\Repositories\VideoRepository;
use CodeFlix\Models\Video;
use CodeFlix\Validators\VideoValidator;

/**
 * Class VideoRepositoryEloquent
 * @package namespace CodeFlix\Repositories;
 */
class VideoRepositoryEloquent extends BaseRepository implements VideoRepository
{
    use ThumbUploads;
    use VideoUploads;
    use Uploads;

    protected $fieldSearchable = [
        'title' => 'like',
        'description' => 'like',
        'serie.title' => 'like',
        'categories.name' => 'like'
    ];

    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['categories'])){
            $model->categories()->sync($attributes['categories']);
        }
        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Video::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
