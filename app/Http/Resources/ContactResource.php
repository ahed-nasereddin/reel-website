<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'whatsapp'      => $this->whatsapp,
            'facebook'      => $this->facebook,
            'instagram'     => $this->instagram,
            'mobile_number' => $this->mobile_number,
            'email'         => $this->email,
            'address'       =>null,
          'coordinates'   => $this->coordinates
                                ? [
                                    'latitude'  => \DB::table('contacts')
                                        ->selectRaw('ST_Y(coordinates) as lat')
                                        ->where('id', $this->id)
                                        ->value('lat'),
                                    'longitude' => \DB::table('contacts')
                                        ->selectRaw('ST_X(coordinates) as lng')
                                        ->where('id', $this->id)
                                        ->value('lng'),
                                  ]
                                : null,
        ];
    }

    
}
