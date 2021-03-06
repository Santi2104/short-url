<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Clasess\CodeGenerator;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'user_id'];

    public $timestamps = false;

    /**
     * Get the user that owns the Url
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function short_url($long_url){
        $url = self::create([
            'url' => $long_url,
            'user_id' => Auth()->user()->id
        ]);

        $code = (new CodeGenerator())->get_code($url->id);

        $url->code = $code;
        $url->save();
        
        return $url->code;
    }
}
