<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'paid_price' => $this->paid_price,
            'program' => new ProgramResource($this->whenLoaded('program')),
            'package' => new PackageResource($this->whenLoaded('package')),
        ];
    }
}