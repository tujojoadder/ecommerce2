<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'image',
        'fathers_name',
        'mothers_name',
        'present_address',
        'parmanent_address',
        'date_of_birth',
        'nationality',
        'religion',
        'nid',
        'birth_certificate',
        'blood_group',
        'gender',
        'edu_qualification',
        'experience',
        'staff_id',
        'staff_type',
        'type',
        'department_id',
        'designation_id',
        'office_zone',
        'joining_date',
        'discharge_date',
        'machine_id',
        'description',
        'marital_status',
        'salary',
        'show_password',
        'password',
        'email_verified_at',
        'created_by',
        'updated_by',
        'status',
        'is_deleted',
        'menu',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // staff payment
    public function totalPayment($id)
    {
        $self = self::findOrFail($id);
        $payment = Transaction::where('transaction_type', 'staff_payment')->where('staff_id', $self->id)->sum('amount');
        return $payment;
    }
    // staff due
    public function totalDue($id)
    {
        $self = self::findOrFail($id);
        $payment = Transaction::where('transaction_type', 'staff_payment')->where('staff_id', $self->id)->sum('amount');
        $due = $self->salary - $payment;;
        return $due;
    }
    // staff monthly due
    public function totalMonthlyDue($id, $month, $year)
    {
        $self = self::findOrFail($id);
        $payment = Transaction::where('transaction_type', 'staff_payment')->whereMonth('date', $month)->whereYear('date', $year)->where('staff_id', $self->id)->sum('amount');
        $due = $self->salary - $payment;;
        return $due;
    }

    // staff monthly payment
    public function totalMonthlyPayment($id, $month, $year)
    {
        $self = self::findOrFail($id);
        $payment = Transaction::where('transaction_type', 'staff_payment')->where('staff_id', $self->id)->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
        return $payment;
    }
}
