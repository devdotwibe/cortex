<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Trait\ResourceModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,ResourceModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
 
    public function progress($name,$default=null){
        return optional($this->userProgress()->where("name",$name)->first())->value??$default;
    }
    public function setProgress($name,$value=null){
        if($value==null){
            UserProgress::where('user_id',$this->id)->where('name',$name)->delete();
        }else{
            $progress=UserProgress::where('user_id',$this->id)->where('name',$name)->first();
            if(empty($progress)){
                $progress=UserProgress::store([
                    'user_id'=>$this->id,
                    'name'=>$name,
                    'value'=>$value,
                ]);
            }else{
                $progress->update([ 
                    'value'=>$value,
                ]);
            }
        }
    }

    public function userProgress(){
        return $this->hasMany(UserProgress::class);
    }
    public function userExamReview(){
        return $this->hasMany(UserExamReview::class);
    }
}
