<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'category_id',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to User
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function shared_users(){
        return $this->belongsToMany(User::class, 'todo_user', 'todo_id', 'user_id');
    }

    public function scopeFilter($query, array $filters){        
        if($filters['category'] ?? false){
            $query->where('category_id', $filters['category']);
        }
        if($filters['search'] ?? false){
            $query->where('name', 'like', '%'.$filters['search'].'%')
                  ->orWhere('description', 'like', '%'.$filters['search'].'%');
        }
        if($filters['owner'] ?? false){
            switch($filters['owner']){
                case 'my':
                    $query->where('user_id', auth()->user()->id);
                    break;
                case 'myshared':
                    $query->where('user_id', auth()->user()->id)->has('shared_users');
                    break;
                case 'sharedme':
                    $query->join('todo_user', 'todos.id', '=', 'todo_user.todo_id')
                    ->where('todo_user.user_id', '=', auth()->user()->id);
                    //$query->with('shared_tasks');
                    break;
                default:
            }
            
        }
    }


}
