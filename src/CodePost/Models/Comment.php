<?php

namespace CodePress\CodePost\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package CodePress\CodePost\Models
 */
class Comment extends Model{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'codepress_comments';

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'content',
        'post_id'
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
            'content' => 'required'
        ]);
        $validator->setData($this->getAttributes());

        if(!$validator->fails())
            return true;

        $this->errors = $validator->errors();
        return false;
    }

    public function post(){
        return $this->belongsTo(Post::class)->withTrashed();
    }



}