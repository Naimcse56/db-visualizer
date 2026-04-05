<?php
namespace Naimul\DbVisualizer\Repositories;

use Illuminate\Support\Facades\Schema;

class SchemaRepository
{
    public function columns($table)
    {
        return Schema::getColumnListing($table);
    }
}