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
            'hiring_year', 'experience', 'academic_status_year',
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

    public function internships(){
        return $this->hasMany(Internship::class);
    }

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
    public function getBirthdayString(){
        if($this->birthday)
            return $this->birthday;
        else
            return __('messages.notSetted');
    }

    public function setRole(int $role){
        if(array_search($role, \Constants::$roles) !== false)
            $this->role = $role;
    }

    public function getRoleString(): string {
        return array_search($this->role, \Constants::$roles);
    }

    public function setTitle(int $title){
        if($title >= 0 && $title < sizeof(\Constants::$pedagogicalTitles))
            $this->pedagogical_title = $title;
    }

    public function getTitle(): string {
        return \Constants::$pedagogicalTitles[$this->pedagogical_title];
    }

    public function setAcademicStatus(int $status){
        if($status >= 0 && $status < sizeof(\Constants::$academicStatusList))
            $this->academic_status = $status;
    }

    public function getAcademicStatus(): string {
        return \Constants::$academicStatusList[$this->academic_status];
    }

    public function setScientificDegree(int $scientific){
        if($scientific >= 0 && $scientific < sizeof(\Constants::$scientificDegreeList))
            $this->scientific_degree = $scientific;
    }

    public function getScientificDegree(): string {
        return \Constants::$scientificDegreeList[$this->scientific_degree];
    }

    public function setDepartment($department){
        $this->department_id = $department;
    }

    public function getDepartmentID(){
        if($this->department)
            return $this->department->id;
    }

    public function getDepartmentName(){
        if($this->department)
            return $this->department->name;
        else
            return __('messages.notSetted');
    }

    public function setCommission($commission){
        $this->commission_id = $commission;
    }

    public function getCommissionID(){
        if($this->commission)
            return $this->commission->id;
    }

    public function getCommissionName(){
        if($this->commission)
            return $this->commission->name;
        else
            return __('messages.notSetted');
    }

    public function setRank($id){
        if($id)
            $this->rank_id = $id;
    }

    public function getRankID(){
        if($this->rank)
            return $this->rank->id;
    }

    public function getRankName(){
        if(!$this->rank)
            return __('messages.notSetted');

        return $this->rank->name;
    }

    public function getShortName(): string {
        $fullName = explode(' ', $this->fullName);

        //if we have only one word then return without catting
        if(sizeof($fullName) == 1){
            return $fullName[0];
        }
        else{
            //cat name and return
            list($name, $surname) = $fullName;
            return $surname . ' ' . mb_substr($name, 0, 1) . '.';
        }
    }

    public function getAvatar(){
        if($this->avatar)
            return $this->avatar;
        else
            return env('APP_URL') . '/storage/avatars/noAva.jpg';
    }

    //generate secret values
    public function generatePassword($password){
        if($password){
            $this->password = bcrypt($password);
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
