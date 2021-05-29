<?php


namespace App\Models;


use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WpTermRelation
 *
 * @property int $object_id
 * @property int $term_taxonomy_id
 * @property int $term_order
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation query()
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation whereTermOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpTermRelation whereTermTaxonomyId($value)
 * @mixin Eloquent
 */
class WpTermRelation extends Model
{
    public $connection = 'wordpress';

    public $timestamps = false;

    protected $primaryKey = 'object_id';

    protected $hidden = [];
    protected $table = 'wp_term_relationships';

    protected $fillable = [
        'object_id',
        'term_taxonomy_id',
        'term_order'
    ];
}
