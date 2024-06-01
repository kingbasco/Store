<?php


namespace Marvel\Database\Repositories;

use Marvel\Database\Models\Author;
use Marvel\Enums\Permission;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class AuthorRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'        => 'like',
        'is_approved',
        'language',
    ];

    protected $dataArray = [
        'name',
        'slug',
        'is_approved',
        'image',
        'cover_image',
        'bio',
        'quote',
        'born',
        'death',
        'languages',
        'socials',
        'language',
    ];


    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Author::class;
    }

    public function storeAuthor($request)
    {
        $data = $request->only($this->dataArray);
        $data['slug'] = $this->makeSlug($request);
        if ($request->user()->hasPermissionTo(Permission::SUPER_ADMIN)) {
            $data['is_approved'] = true;
        } else {
            $data['is_approved'] = false;
        }
        return $this->create($data);
    }

    public function updateAuthor($request, $author)
    {
        $data = $request->only($this->dataArray);
        if (!$request->user()->hasPermissionTo(Permission::SUPER_ADMIN)) {
            $data['is_approved'] = false;
        }
        $data = $request->only($this->dataArray);
        if (!empty($request->slug) &&  $request->slug != $author['slug']) {
            $data['slug'] = $this->makeSlug($request);
        }
        $author->update($data);
        return $this->findOrFail($author->id);
    }
}
