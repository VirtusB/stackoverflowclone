<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * Returns the question that the answer belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question() {
        return $this->belongsTo(Question::class);
    }

    /**
     * Returns the user who created the answer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the creation date of the question, formatted to be easily readable, ex. "20 minutes ago"
     * @return mixed
     */
    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    /**
     * Return the body of the question, parsed to HTML
     * @return string
     */
    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }

    /**
     * boot method is used to override default behaviour of an eloquent model
     */
    public static function boot() {
        parent::boot();

        // each time an answer is created, update the answers_count on the question. "created" is an event
        static::created(function ($answer) {
            $answer->question->increment('answers_count'); // save method is automatically called when calling increment
        });
    }
}
