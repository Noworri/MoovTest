<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class AlarmeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        $date = new Carbon($this->created_at);
        $date = $date->isoFormat('LLLL');
        return [
            'id' => $this->id,
            'alarm' => $this->error,
            'num_module' => $this->num_module,
            'date_create' => $date
        ];
    }
}
