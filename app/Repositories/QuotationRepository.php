<?php

namespace App\Repositories;

use App\Models\Quotation;

class QuotationRepository
{
    public function create(array $data): Quotation
    {
        return Quotation::create($data);
    }

    public function find(int $id): ?Quotation
    {
        return Quotation::find($id);
    }
}
