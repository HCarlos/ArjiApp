<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UserAttributes;
use App\Traits\UserImport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPermissions, LaravelPermissionToVueJS;

//    use HasApiTokens, HasFactory, Notifiable

    use UserImport, UserAttributes, SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard_name = 'web';
    protected $table = 'users';

    protected $appends = [
        'full_name','full_name_with_username','path_image_profile','path_image_thumb_profile',
        'path_image_p_n_g_profile'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'username', 'email', 'password',
        'nombre','ap_paterno','ap_materno',
        'curp','emails','celulares','telefonos',
        'fecha_nacimiento','genero', 'lugar_nacimiento',
        'root','filename','filename_png','filename_thumb',
        'empresa_id','status_user','ip','host','searchtext_user',
        'logged','logged_at','logout_at', 'user_mig_id','email_verified_at',
        'creadopor_id','created_at','modipor_id','updated_at',
        'ubicacion_id','imagen_id','session_id',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        return $query->whereRaw("searchtext_user @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("ts_rank(searchtext_user, to_tsquery('spanish', ?)) DESC", [$search]);
    }

//    public function scopeFilterBy($query, $filters){
//        return (new UserFilter())->applyTo($query, $filters);
//    }

    public function permisos() {
        return $this->belongsToMany(Permission::class);
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

//    public function Imagen(){
//        return $this->hasOne(Imagene::class,'id','imagene_id');
//    }

//    public function imagenes(){
//        return $this->belongsToMany(Imagene::class,'imagene_user','imagene_id','user_id');
//    }


    public function user_adress(){
        return $this->hasOne(UserAdress::class);
    }

    public function user_data_extend(){
        return $this->hasOne(UserDataExtend::class);
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function IsFemale(){
        return $this->genero == 0 ? true : false;
    }

    public function scopeMyID(){
        return $this->id;
    }

//    public function scopeRole(){
//        return $this->roles()->first();
//    }

//    public function sendPasswordResetNotification($token){
//        $this->notify(new MyResetPassword($token));
//    }

//    public function sendEmailVerificationNotification(){
//        $this->notify(new SendEmailAPIVerificationNotification());
//    }

//    public function arrayRoles(){
//        $roles = [];
//        foreach($this->roles()->get() as $r){
//            $roles[] = ["id" => $r->id, 'name' => $r->name ];
//        }
//        return $roles;
//    }



}
