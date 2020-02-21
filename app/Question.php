<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * Question model
 * @package App
 */
class Question extends Model
{
    /**
     * The attributes on a question that can be filled
     * This prevents, for an example, ID to be filled, since with should be filled automatically
     * @var array
     */
    protected $fillable = ['title', 'body'];

    /**
     * Returns an instance of the user who created the question
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Set title of question, then generate slug from title
     * @param $questionTitle
     */
    public function setTitleAttribute($questionTitle): void {
        $this->attributes['title'] = $questionTitle;
        $this->attributes['slug'] = str_slug($questionTitle);
    }

    /**
     * Returns a full URL to the question
     * @return string
     */
    public function getUrlAttribute() {
        return route('questions.show', $this->slug);
    }

    /**
     * Return the creation date of the question, formatted to be easily readable, ex. "20 minutes ago"
     * @return mixed
     */
    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    /**
     * Return string depending on which status the question currently has
     * Used for styling in CSS
     * @return string
     */
    public function getStatusAttribute() {
        if ($this->answers_count > 0) {

            if($this->best_answer_id) {
                return 'answered-accepted';
            }

            return 'answered';
        }

        return 'unanswered';
    }

    /**
     * Return the body of the question, parsed to HTML
     * @return string
     */
    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
