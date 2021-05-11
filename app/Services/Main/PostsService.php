<?php

namespace App\Services\Main;

use App\Data\Abstracts\Dto;
use App\Data\Abstracts\DtoInterface;
use App\Models\Posts;
use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Data\DataTransferObjects\Paginator;
use App\Data\DataTransferObjects\Posts as PostsDto;
use App\Services\AutoPostInterface;
use App\Services\Libraries\Generate\TableGenerator;
use Illuminate\Support\Collection;
use JsonMapper_Exception;

/**
 * Posts Service
 */
class PostsService extends Service implements AutoPostInterface
{
    /**
     *
     * @var Posts
     */
    protected Posts $model;

    /**
     * @var PostsDto
     */
    protected PostsDto $dto;

    /**
     * @var MainService
     */
    protected MainService $service;

    /**
     * Undocumented function
     *
     * @param Posts $posts
     * @param PostsDto $dto
     * @param MainService $service
     */
    public function __construct(Posts $posts, PostsDto $dto, MainService $service)
    {
        $this->model = $posts;
        $this->dto = $dto;
        $this->service = $service;
    }

    /**
     * Undocumented function
     *
     * @param integer $count
     *
     * @return Paginator
     * @throws JsonMapper_Exception
     */
    public function paginate(int $count = 10): Paginator
    {
        $model = $this->model->orderByDesc('created_at')->paginate($count);

        return new Paginator($model, $this->entity(), 'posts');
    }

    /**
     * @return Posts
     */
    public function model(): Posts
    {
        return Posts::newModelInstance();
    }

    /**
     * @return PostsDto
     * @throws JsonMapper_Exception
     */
    public function entity(): PostsDto
    {
        return PostsDto::newInstance();
    }

    /**
     * Undocumented function
     *
     * @return Collection|PostsDto[]
     * @throws JsonMapper_Exception
     */
    public function all(): Collection
    {
        return $this->entity()->mapList(Posts::all());
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return Dto
     * @throws JsonMapper_Exception
     */
    public function find(int $id): Dto
    {
        return $this->entity()->map($this->model()->findOrFail($id));
    }

    /**
     * Undocumented function
     *
     * @param array $input
     * @param string $op
     * @return Collection
     */
    public function findByAttribute(array $input, string $op = '='): Collection
    {
        $input = collect($input);

        $where = [];

        $input->each(function ($value, $key) use (&$where, $op) {
            $where[] = [$key, $op, $value];
        });

        return $this->model->where($where)->get();
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @param integer|null $userId
     * @param string|null $createdBy
     *
     * @return int
     * @throws JsonMapper_Exception
     */
    public function autoPost(string $type, int $userId = null, string $createdBy = null): int
    {
        $refine = $this->service->getRefinedData($type);

        $title = __("stock.$type");
        $name = '';
        $date = '';
        $data = '';

        if ($refine->get('type') == 'theme') {
            $code = $refine->get('code');
            $name = config("themes.kospi.themes_raw.{$code}");
            $name = str_replace('_', '', $name);
            $date = $refine->get('date');
            $data = $refine->get('data')->toArray();
        }

        if ($refine->get('type') == 'sector') {
            $code = $refine->get('code');
            $name = config("sectors.kospi.sectors_raw.{$code}");
            $date = $refine->get('date');
            $data = $refine->get('data')->toArray();
        }

        $generator = new TableGenerator($title, $name, $date, $data);

        $data = $generator->generate();

        $now = Carbon::now()->format('[Y-m-d]');

        $this->dto->setType($refine->get('type'));
        $this->dto->setCode($refine->get('code'));
        $this->dto->setTitle("{$now} {$title}: {$name}");
        $this->dto->setSubTitle("$name ({$refine['date']})");
        $this->dto->setContents($data);

        return $this->create($this->dto, $userId, $createdBy);
    }

    /**
     * Undocumented function
     *
     * @param PostsDto $dto
     * @param integer $userId
     * @param string $createdBy
     *
     * @return int
     */
    public function create(PostsDto $dto, int $userId, string $createdBy): int
    {
        $dto->setUserId($userId);
        $dto->setCreatedBy($createdBy);

        $model = $this->model->fill($dto->toArray());
        if ($model->save()) {
            return $model->id;
        }

        $this->throw(ErrorCode::CONFLICT, '포스팅 실패');
    }

    /**
     * @param int $id
     * @param PostsDto $dto
     * @param string $updatedBy
     * @return int
     */
    public function update(int $id, PostsDto $dto, string $updatedBy): int
    {
        $model = $this->model->findOrFail($id);
        $model->updated_by = $updatedBy;
        $model->fill($dto->toArray());
        if ($model->save()) {
            return $id;
        }

        $this->throw(ErrorCode::CONFLICT, '포스트 수정 실패');
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @param string $deletedBy
     *
     * @return bool
     */
    public function delete(int $id, string $deletedBy): bool
    {
        $this->model->findOrFail($id);
        $this->model->deleted_by = $deletedBy;
        $this->model->save();

        return $this->model->delete();
    }
}
