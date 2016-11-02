<?php

namespace CodePress\CodePosts\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Post
 * @package CodePress\CodePosts\Models
 */
class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * @var string
     */
    protected $table = 'codepress_posts';

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

}