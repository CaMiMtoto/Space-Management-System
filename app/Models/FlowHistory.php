<?php

namespace App\Models;

use App\Traits\HasStatusColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $model_id
 * @property string $model_type
 * @property string $status
 * @property string $description
 * @property int $is_comment
 * @property int|null $done_by_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $doneBy
 * @property-read Model|\Eloquent $flowable
 * @property-read string $status_color
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereDoneById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereIsComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FlowHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlowHistory extends Model
{
    use HasStatusColor;
    public function flowable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function doneBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by_id','id');
    }
}
