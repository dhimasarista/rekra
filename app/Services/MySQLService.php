<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MySQLService
{
    protected $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    // Create a new record
    public function create(array $data)
    {
        return DB::table($this->table)->insert($data);
    }

    // Retrieve records with optional where clause
    public function read(array $conditions = [])
    {
        $query = DB::table($this->table);

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->get();
    }

    // Update records with a where clause
    public function update(array $conditions, array $data)
    {
        $query = DB::table($this->table);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->update($data);
    }

    // Delete records with a where clause
    public function delete(array $conditions)
    {
        $query = DB::table($this->table);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->delete();
    }

    // Retrieve records with a join
    public function join(string $tableToJoin, string $foreignKey, string $localKey, array $conditions = [])
    {
        $query = DB::table($this->table)
                    ->join($tableToJoin, $this->table . '.' . $localKey, '=', $tableToJoin . '.' . $foreignKey);

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->get();
    }

    // Count the number of records with optional where clause
    public function count(array $conditions = [])
    {
        $query = DB::table($this->table);

        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->count();
    }
}
