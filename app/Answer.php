<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question() {
        return $this->belongsTo(Question::class);
    }

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

    public static function boot() {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count'); // save method is automatically called when calling increment
        });
    }
}
