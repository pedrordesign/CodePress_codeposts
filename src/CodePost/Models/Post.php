<?php

namespace CodePress\CodePost\Models;

use CodePress\CodeCategory\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package CodePress\CodePost\Models
 */
class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'codepress_posts';
    protected $dates = ['deleted_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true
            ]
        ];
    }

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'slug'
    ];

    /**
     * @var
     */
    private $validator;


    /**
     * @param Validator $validator
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return bool
     */
    public function isValid(){
        $validator = $this->validator;
        $validator->setRules([
            'title' => 'required|max:55',
            'content' => 'required'
        ]);
        $validator->setData($this->getAttributes());

        if(!$validator->fails())
            return true;

        $this->errors = $validator->errors();
        return false;
    }

    public function categories(){
        return $this->morphToMany(Category::class, 'categorizable', 'codepress_categorizables');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}