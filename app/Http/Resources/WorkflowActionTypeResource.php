<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowActionTypeResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $code
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowActionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'is_default' => $this->is_default,
            'tags' => $this->tags,
            'status' => StatusResource::make($this->status),

            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
