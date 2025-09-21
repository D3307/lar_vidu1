<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;

class InventoriesExport implements FromCollection
{
    public function collection()
    {
        return Inventory::all(['id', 'product_name', 'quantity', 'updated_at']);
    }
}