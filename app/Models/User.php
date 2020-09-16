<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;


    protected $flag = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // Relationships with other models

    public function social()
    {
        return $this->hasMany('App\Models\Social');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * many to many relationship between User and Role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){

        return $this->belongsToMany('App\Models\Role')->withTimestamps();

    }


    // helper methods
    /**
     * attaches a role to a user
     * @param $role
     * @return bool
     */
    public function attachRole($role){

        if(!$this->getRoles()->contains($role)){

            $this->roles()->attach($role);
            $this->flag = true;

        }

        return $this->flag;
    }

    /**
     * Gets all user roles as a collection
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function getRoles(){

        return (!empty($this->roles()->get())) ? $this->roles()->get() : null;

    }

    /**
     * Removes a role from a user
     * @param $role
     * @return int
     */
    public function detachRole($role){

        return $this->roles()->detach($role);

    }

    /**
     * Removes all roles from a user
     * @return int
     */
    public function detachAllRoles(){

        return $this->roles()->detach();

    }

    /**
     * Checks if user has a role
     * @param $role
     * @return bool
     */
    public function hasRole($role){

        return $this->getRoles()->contains($role);

    }

    /**
     * Checks if user has at least one role
     * @param $role
     * @return bool
     */
    public function isOne($role){

        foreach ($this->getArrayFrom($role) as $role){

            if($this->hasRole($role)){
                return true;
            }

        }

        return false;

    }


    public function homeUrl()
    {
        if ($this->hasRole('user')){

            $url = route('user.home');
        }
        else{

            $url = route('admin.home');
        }

        return $url;
    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     * @return array
     */
    public static function getArrayFrom($argument)
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', $argument) : $argument;
    }

    //relationship with model
    public function product(){
        return $this->hasMany('App\inventory\Product');
    }

    public function warehouse(){
        return $this->hasMany('App\inventory\Warehouse');
    }

    public function customer(){
        return $this->hasMany('App\inventory\Customer');
    }

    public function shop(){
        return $this->hasMany('App\inventory\Shop');
    }

    public function product_line(){
        return $this->hasMany('App\inventory\ProductLine');
    }
    public function order(){
        return $this->hasMany('App\inventory\Order');
    }
}
