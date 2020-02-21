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
     * Return the body of the question, parsed to HTML
     * @return string
     */
    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }
}
