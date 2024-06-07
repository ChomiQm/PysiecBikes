<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class DocumentAccess extends Model
{
    use HasFactory;

    protected $table = 'document_access';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'document_id',
        'role_id',
    ];

    public function document(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
