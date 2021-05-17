<?php

namespace App\Models;

use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use JsonMapper_Exception;

/**
 * App\Models\Posts
 *
 * @property int $user_id
 * @property string     $title
 * @property string     $sub_title
 * @property string     $contents
 * @property int        $created_at
 * @property int        $updated_at
 * @property int        $deleted_at
 * @property string     $created_by
 * @property string     $updated_by
 * @property string     $deleted_by
 * @property int $id
 * @property string $type
 * @property string $code
 * @property bool $published
 * @method static Posts newInstance()
 * @method static Collection|static[] all($columns = ['*'])
 * @method static Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Posts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posts newQuery()
 * @method static \Illuminate\Database\Query\Builder|Posts onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Posts query()
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Posts withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Posts withoutTrashed()
 * @mixin Eloquent
 */
class Posts extends Model
{
    use SoftDeletes;

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function getForAutoPost(string $type, int $postsId = null){
        if (is_null($postsId)) {
            $posts = Posts::where('type', $type)
                ->where('published', false)
                ->orderByDesc('created_at')
                ->first();
        } else {
            $posts = Posts::find($postsId);
        }

        return $posts;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
    protected $fillable = [
        'user_id', 'title', 'sub_title', 'type', 'code', 'contents', 'published', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'
    ];

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
        'user_id' => 'int',
        'title' => 'string',
        'sub_title' => 'string',
        'contents' => 'string',
        'published' => 'boolean',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
        'deleted_at' => 'date:Y-m-d',
        'created_by' => 'string',
        'updated_by' => 'string',
        'deleted_by' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    // Scopes...

    // Functions ...

    // Relations ...
}
