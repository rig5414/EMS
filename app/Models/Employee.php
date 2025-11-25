<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'position', 'salary', 'status'];

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
        ];
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'department_employee');
    }

    public function departmentsAsHod(): HasMany
    {
        return $this->hasMany(Department::class, 'hod_id');
    }
}
