<?php

namespace Core;

/**
 * Class Model
 *
 * This class represents a base model for interacting with the database.
 */
class Model
{
    use Database;

    protected int $limit = 10;
    protected int $offset = 0;
    protected string $order_type = "desc";
    protected string $order_column = "id";
    protected array $fillable = [];
    public array $errors = [];

    /**
     * Retrieve all records from the table.
     *
     * @return array|false An array of records on success, or false on failure.
     */
    public function all(): array|false
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";

        return $this->query($query);
    }

    /**
     * Retrieve records from the table based on the specified conditions.
     *
     * @param array $data An associative array of conditions for matching records.
     * @param array $data_not An associative array of conditions for excluding records.
     * @return array|false An array of matched records on success, or false on failure.
     */
    public function where($data, $data_not = []): array|false
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && ";
        }

        $query = trim($query, " && ");

        $query .= " ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";
        $data = array_merge($data, $data_not);

        return $this->query($query, $data);
    }

    /**
     * Retrieve the first record from the table based on the specified conditions.
     *
     * @param array $data An associative array of conditions for matching records.
     * @param array $data_not An associative array of conditions for excluding records.
     * @return \stdClass|false The first matched record as an object on success, or false on failure.
     */
    public function first($data, $data_not = []): \stdClass|false
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $this->table WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && ";
        }

        $query = trim($query, " && ");

        $query .= " LIMIT 1 OFFSET";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        }

        return false;
    }

    /**
     * Insert a new record into the table.
     *
     * @param array $data An associative array of data to be inserted.
     * @return bool True on success, or false on failure.
     */
    public function insert($data): bool
    {
        if (!empty($this->fillable)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        $this->query($query, $data);

        return false;
    }

    /**
     * Update records in the table based on the specified conditions.
     *
     * @param mixed $id The value of the identifier column for the records to be updated.
     * @param array $data An associative array of data to be updated.
     * @param string $id_column The name of the identifier column (default: 'id').
     * @return bool True on success, or false on failure.
     */
    public function update($id, $data, $id_column = 'id'): bool
    {
        if (!empty($this->fillable)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "UPDATE $this->table SET ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . ", ";
        }

        $query = trim($query, ", ");

        $query .= " WHERE $id_column = :$id_column ";

        $data[$id_column] = $id;

        $this->query($query, $data);
        return false;
    }

    /**
     * Delete records from the table based on the specified conditions.
     *
     * @param mixed $id The value of the identifier column for the records to be deleted.
     * @param string $id_column The name of the identifier column (default: 'id').
     * @return bool True on success, or false on failure.
     */
    public function delete($id, $id_column = 'id'): bool
    {
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column ";
        $this->query($query, $data);

        return false;
    }
}
