<?php

namespace App\Services\Main;

use App\Models\Posts;
use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Support\Carbon;
use App\Services\Main\MainService;
use App\DataTransferObjects\Paginator;
use App\DataTransferObjects\Posts as PostsDto;
use App\Services\AutoPostInterface;
use App\Services\Libraries\Generate\TableGenerator;

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
     */
    public function paginate(int $count = 10)
    {
        $model = $this->model->orderByDesc('created_at')->paginate($count);

        return new Paginator($model, 'posts');
    }

    /**
     * Undocumented function
     *
     * @return PostsDto[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Undocumented function
     *
     * @return PostsDto
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Undocumented function
     *
     * @return Collection|PostsDto[]
     */
    public function findByAttribute(array $input, string $op = '=')
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
     * @param string $name
     * @param integer $userId
     * @param string $createdBy
     *
     * @return int
     */
    public function autoPost(string $type, int $userId, string $createdBy)
    {
        $refine = $this->service->getRefinedData($type);

        $title = __("stock.$type");

        if ($refine->get('title') == 'theme') {
            $code = $refine->get('code');
            $theme = collect(config('themes'))->filter(function ($value) use ($code) {
                return $value['code'] == $code;
            })->first();

            $name = str_replace('_', '', $theme['name']);
            $date = $refine->get('date');
            $data = $refine->get('data')->toArray();
        }

        if ($refine->get('title') == 'sector') {
            $name = config('sectors.kospi.sectors_raw.' . $refine->get('code'));
            $date = $refine->get('date');
            $data = $refine->get('data')->toArray();
        }

        $generator = new TableGenerator($title, $name, $date, $data);

        $data = $generator->generate();

        $now = Carbon::now()->format('[Y-m-d]');

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
    public function create(PostsDto $dto, int $userId, string $createdBy)
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
    public function update(int $id, PostsDto $dto, string $updatedBy)
    {
        $model = $this->model->findOrFail($id);
        $model->updated_by = $updatedBy;
        $model->fill($dto);
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
    public function delete(int $id, string $deletedBy)
    {
        $this->model->findOrFail($id);
        $this->model->deleted_by = $deletedBy;
        $this->model->save();

        return $this->model->delete();
    }
}
