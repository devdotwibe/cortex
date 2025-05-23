<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Trait\Billable;
use App\Trait\ResourceModel;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class User extends Authenticatable
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
        'is_free_access',
        'email_verified_at'
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

    public function progress($name,$default=null,$exam_id=null){

        $user_exam =true;

        if (str_contains($name, 'complete-date'))
        {
            $userExamReviews = UserExamReview::where('user_id',$this->id)
            ->where('exam_id',$exam_id)
            ->select('slug','created_at','progress','id','exam_id','ticket')
            ->orderBy('created_at','ASC')->get();

            foreach($userExamReviews as $row)
            {
                $userExam = UserExam::findSlug($row->ticket);

                if (!$userExam) {
                    $user_exam = false;
                    break;
                }

                $exam_questions_count = UserExamQuestion::where('exam_id', $row->exam_id)
                ->where('user_exam_id', $userExam->id)
                ->count();;

                if ($exam_questions_count === 0) {
                    $user_exam = false;
                    break;
                }
            }

        }
            if(!$user_exam)
            {
                return null;
            }

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

    public function userpost(){
        return $this->hasMany(Post::class);
    }

    public function subscription(){
        return UserSubscription::where('user_id',$this->id)
                                ->whereDate('expire_at','>=',Carbon::now())
                                ->orderBy('id','DESC')->first();
    }

    public function subscriptionExpire()
    {
        $subscription = UserSubscription::where('user_id', $this->id)
            ->orderBy('id', 'DESC')
            ->first();
        if ($subscription && $subscription->expire_at > Carbon::now()) {
            return true;
        }
        return false;
    }
    public function userSubscription(){
        return $this->hasMany(UserSubscription::class);
    }


    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new UserEmailVerifyNotification);
    // }

    protected static function booted()
    {
        static::creating(function ($user) {

            $user->email_verified_at = Carbon::now();
        });
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
//    public function toMail($notifiable)
//    {
//         $url=$this->resetUrl($notifiable);
//         $name = $notifiable->first_name;
//         return (new MailMessage)->view('email.reset',compact('url', 'name'));
//     }


public function toMail($notifiable)
{
    $url = $this->resetUrl($notifiable);
    $name = $notifiable->first_name;

    return (new MailMessage)
        ->subject('Reset your Cortex Online password')
        ->view('email.reset', compact('url', 'name'))
        ->salutation('The Cortex Online Team');
}


}
