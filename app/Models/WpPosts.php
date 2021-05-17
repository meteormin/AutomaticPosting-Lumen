<?php


namespace App\Models;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WpPosts
 *
 * @property int $ID
 * @property int $post_author
 * @property \Illuminate\Support\Carbon $post_date
 * @property string $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $to_ping
 * @property string $pinged
 * @property \Illuminate\Support\Carbon $post_modified
 * @property string $post_modified_gmt
 * @property string $post_content_filtered
 * @property int $post_parent
 * @property string $guid
 * @property int $menu_order
 * @property string $post_type
 * @property string $post_mime_type
 * @property int $comment_count
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts query()
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereCommentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereMenuOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePinged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostContentFiltered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostDateGmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostModifiedGmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WpPosts whereToPing($value)
 * @mixin \Eloquent
 */
class WpPosts extends Model
{
    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'post_modified';

    public $connection = 'wordpress';

    public $timestamps = true;

    protected $primaryKey = 'ID';

    protected $hidden = [];
    protected $table = 'wp_posts';

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

    protected $fillable = [
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_except',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'post_type',
    ];
}
