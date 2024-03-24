<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\PurchaseOrders;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'total_purchase_qty' => $this->total_purchase_qty,
            'total_received_qty' => $this->total_received_qty,
        ];
    }



    /**
     * Add additional data to the resource response.
     *
     * @param  Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'meta' => [
                'key' => ['nested' => 'value'],
                'key' => true,
            ],
        ];
    }


    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
