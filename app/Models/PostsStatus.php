<?php

namespace App\Models;

use App\Data\DataTransferObjects\PostsStatus as Dto;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostsStatus
 *
 * @property string     $type
 * @property string     $code
 * @property int $type_count
 * @property int $code_count
 * @method static \Illuminate\Support\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Support\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus whereCodeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostsStatus whereTypeCount($value)
 * @mixin \Eloquent
 */
class PostsStatus extends Model
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return (new Dto)->mapList($models);
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts_status';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string', 'code' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
}
