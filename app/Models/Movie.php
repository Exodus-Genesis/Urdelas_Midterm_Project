<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','director','release_year','genre_id','photo','rating','description'];
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
