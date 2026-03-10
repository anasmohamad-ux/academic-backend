<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'icon', 'price'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }

    // Top 3 most enrolled courses — used on homepage
    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount([
            'packages as enrollment_count' => function ($q) {
                $q->join('enrollments', 'enrollments.package_id', 'packages.id');
            }
        ])->orderByDesc('enrollment_count')->limit(3);
    }
}