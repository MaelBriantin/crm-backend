<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'full_address' => $this->full_address,
            'visit_frequency' => $this->visitFrequency,
            'visit_day' => $this->visit_day,
            'visit_day_label' => trans("days.{$this->visit_day}"),
            'visit_schedule' => $this->visit_schedule,
            'sector_name' => $this->sector->name ?? trans('sectors.out_of_sector'),
            'sector' => $this->sector,
            'relationship' => $this->relationship,
            'relationship_value' => $this->relationship->value ?? null,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
        ];
    }
}
