<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'hod_id'];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'department_employee');
    }

    public function hod(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'hod_id');
    }
}
