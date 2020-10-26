<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullName', 'email', 'birthday', 'pedagogical_title', 'address', 'phone',
            'hiring_year', 'experience', 'academic_status', 'academic_status_year', 'scientific_degree',
            'scientific_degree_year'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //User roles
    const ROLE_ADMIN = 1;
    const ROLE_MODERATOR = 10;
    const ROLE_VIEWER = 30;
    const ROLE_USER = 50;

    //Relations
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function commission(){
        return $this->belongsTo(Commission::class);
    }

    public function publications(){
        return $this->belongsToMany(Publication::class, 'users_publications', 'user_id');
    }
//
//    public function internships(){
//        return $this->hasMany(Internship::class);
//    }
//
    public function qualifications(){
        return $this->hasMany(Qualification::class);
    }

    public function honors(){
        return $this->hasMany(Honor::class);
    }

    public function rebukes(){
        return $this->hasMany(Rebuke::class);
    }

    public function rank(){
        return $this->belongsTo(Rank::class);
    }

    public function educations(){
        return $this->hasMany(Education::class);
    }

    //Helper methods
    public static function getPedagogicalTitles(){
        return ['Старший викладач', 'Викладач-методист'];
    }

    public function getBirthdayString(){
        if($this->birthday)
            return $this->birthday;
        else
            return 'Не встановлено';
    }

    public function setDepartment($department){
        $this->department_id = $department;
        $this->save();
    }

    public function getDepartmentID(){
        if($this->department)
            return $this->department->id;
    }

    public function getDepartmentName(){
        if($this->department)
            return $this->department->name;
        else
            return 'Не встановлено';
    }

    public function setCommission($commission){
        $this->commission_id = $commission;
        $this->save();
    }

    public function getCommissionID(){
        if($this->commission)
            return $this->commission->id;
    }

    public function getCommissionName(){
        if($this->commission)
            return $this->commission->name;
        else
            return 'Не встановлено';
    }

    public function setRank($id){
        if($id)
            $this->rank_id = $id;

        $this->save();
    }

    public function getRankID(){
        if($this->rank)
            return $this->rank->id;
    }

    public function getRankName(){
        if(!$this->rank)
            return 'Не встановлено';

        return $this->rank->name;
    }

    public function getRoleString(){
        $roles = self::getRolesArray();

        return $roles[$this->role] ?? null;
    }

    public static function getRolesArray(){
        return [
          self::ROLE_ADMIN => 'Адміністратор',
          self::ROLE_MODERATOR => 'Модератор',
          self::ROLE_VIEWER => 'Переглядач',
          self::ROLE_USER => 'Користувач',
        ];
    }

    public function getShortName(): string {
        list($surname, $name) = explode(' ', $this->fullName);
        return $surname . ' ' . mb_substr($name, 0, 1) . '.';
    }

    public function getAvatar(){
        if($this->avatar)
            return env('APP_URL') . '/storage/avatars/' . $this->avatar;
        else
            return env('APP_URL') . '/storage/avatars/noAva.jpg';
    }

    //generate secret values
    public function generatePassword($password){
        if($password){
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function cryptPassport($passport){
        if(!$passport)
            return;

        $this->passport = encrypt($passport);
        $this->save();
    }

    public function cryptCode($code){
        if(!$code)
            return;

        $this->code = encrypt($code);
        $this->save();
    }

    public function getToken(bool $long = false){
        $token = $this->createToken(config('app.name'));
	    return $token->accessToken;
    }
}
