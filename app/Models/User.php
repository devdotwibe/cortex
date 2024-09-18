<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Trait\Billable;
use App\Trait\ResourceModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,ResourceModel,Billable;

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
        'schooling_year',
        'password',
        'post_status',
        'is_free_access'
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
    public function privateClass(){
        return $this->belongsTo(PrivateClass::class,'id','user_id');
    }

    public function userProgress(){
        return $this->hasMany(UserProgress::class);
    }
    public function userExamReview(){
        return $this->hasMany(UserExamReview::class);
    }
    public function subscription(){
        return UserSubscription::where('user_id',$this->id)->orderBy('id','DESC')->first();
    } 


    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserEmailVerifyNotification);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserPasswrdResetNotification($token));
    }

}
class UserEmailVerifyNotification extends VerifyEmail{

 
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);
        $name = $notifiable->first_name;
        return (new MailMessage)->view('email.verify',compact('url', 'name'));
    }

}
class UserPasswrdResetNotification extends ResetPassword{
    
   /**
    * Build the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
   public function toMail($notifiable)
   {
        $url=$this->resetUrl($notifiable);
        $name = $notifiable->first_name;
        return (new MailMessage)->view('email.reset',compact('url', 'name'));
    }
    
}