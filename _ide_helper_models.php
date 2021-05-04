<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 * @method static \Illuminate\Support\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Support\Collection|static[] get($columns = ['*'])
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
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posts whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Posts withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Posts withoutTrashed()
 */
	class Posts extends \Eloquent {}
}

namespace App\Models{
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
 */
	class PostsStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable {}
}

