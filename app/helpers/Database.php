<?php

/**
 * Retrieves data from a database table based on the given parameters.
 *
 * @param string $tableName The name of the table to retrieve data from.
 * @param string|null $where The WHERE clause of the query. Default is null.
 * @param array $bind An array of values to bind to the query. Default is an empty array.
 * @param string|null $limit The LIMIT clause of the query. Default is null.
 * @return array|stdClass|false An array of results, a stdClass object, or false if no results are found.
 * @throws Exception
 * @global Database|ReSQL $db The database connection object.
 * @global string $mode The current database mode ("mysql" or "ReSQL").
 */
function get_table(string $tableName, ?string $where = null, array $bind = [], ?string $limit = null): array|stdClass|false
{
  if (empty($where))
    $sql = "SELECT * FROM $tableName" . (!empty($limit) ? " LIMIT $limit" : null);
  else
    $sql = "SELECT * FROM $tableName WHERE $where" . (!empty($limit) ? " LIMIT $limit" : null);
  db->query($sql);
  if (!empty($rs = db->resultset($bind))) {
    return $rs;
  } else {
    return false;
  }
}

/**
 * Resets the auto-increment value of the specified table.
 *
 * @param string $tableName The name of the table. Default is an empty string.
 * @return bool True if the reset is successful, false otherwise.
 * @throws Exception
 * @global Database $db The MySQL database connection object.
 */
function reset_autoincrement(string $tableName = ""): bool
{
  return db->query("SET @num := 0;UPDATE $tableName SET id = @num := (@num+1);ALTER TABLE $tableName AUTO_INCREMENT=1;")->execute();
}

/**
 * Executes a custom query on the database.
 *
 * @param string $query The query to execute.
 * @param array $bindings
 * @return array|stdClass|false An array of results, a stdClass object, or false if the query fails.
 * @throws Exception
 * @global Database|ReSQL $db The database connection object.
 * @global string $mode The current database mode ("mysql" or "ReSQL").
 */
function query(string $query, array $bindings = []): array|stdClass|bool
{
  if (db->query($query)) {
    if (!empty($r = db->resultset($bindings))) {
      return $r;
    }
    return true;
  }
  return false;
}

/**
 * Inserts a new record into the specified table.
 *
 * @param string $table The name of the table to insert into.
 * @param array $data An associative array of column names and values to insert.
 * @return bool True if the insert is successful, false otherwise.
 * @throws Exception
 * @global Database|ReSQL $db The database connection object.
 * @global string $mode The current database mode ("mysql" or "ReSQL").
 */
function insert_query(string $table, array $data): bool
{
  $columns = implode(', ', array_keys($data));
  $placeholders = implode(', ', array_fill(0, count($data), '?'));
  return query("INSERT INTO $table ($columns) VALUES ($placeholders)", array_values($data));
}

/**
 * Updates a record in the specified table.
 *
 * @param string $table The name of the table to update.
 * @param int $id The ID of the record to update.
 * @param array $data An associative array of column names and values to update.
 * @return bool True if the update is successful, false otherwise.
 * @throws Exception
 * @global Database|ReSQL $db The database connection object.
 * @global string $mode The current database mode ("mysql" or "ReSQL").
 */
function update_query(string $table, int $id, array $data): bool
{
  $set = '';
  foreach ($data as $column => $value) {
    $set .= "$column = ?, ";
  }
  $set = rtrim($set, ', ');

  $bindings = array_values($data);
  $bindings[] = $id;

  return query("UPDATE $table SET $set WHERE id = ?", $bindings);
}

/**
 * Deletes a record from the specified table.
 *
 * @param string $table The name of the table to delete from.
 * @param int $id The ID of the record to delete.
 * @return bool True if the delete is successful, false otherwise.
 * @throws Exception
 * @global Database|ReSQL $db The database connection object.
 * @global string $mode The current database mode ("mysql" or "ReSQL").
 */
function delete_query(string $table, int $id): bool
{
  return db->query('DELETE FROM ' . $table . ' WHERE `id`=' . $id . ';')->execute();
}

/**
 * Returns the last inserted ID.
 * @return int
 */
function get_last_insert_id(): int
{
  return db->lastInsertId();
}

///////////// Implementations /////////////

// --- user ---
function user(int $id = null, string $email = null, int $rank = null, bool $count = false): mixed
{
  if ($count)
    return query("SELECT COUNT(*) as res FROM `user`")[0]->res;
  $where = [];
  if (!empty($id))
    $where["id=?"] = $id;
  if (!empty($email))
    $where["email=?"] = $email;
  if (!empty($rank))
    $where["`rank`=?"] = $rank;
  if (!empty($where))
    return query("SELECT * FROM `user` WHERE " . implode(" AND ", array_keys($where)), array_values($where));
  return query("SELECT * FROM `user`");
}

/**
 * @throws Exception
 */
function createUser(string $email, string $name, string $password, string $method = "ledit", int $rank = 0)
{
  return insert_query("user", ["email" => $email, "name" => $name, "password" => encodePassword($password), "method" => $method, "`rank`" => $rank]);
}

/**
 * @throws Exception
 */
function updateUser(int $id, string $email, string $name, string $password, string $method = "ledit", int $rank = 0)
{
  if (!empty($password))
    return update_query("user", $id, ["email" => $email, "name" => $name, "password" => encodePassword($password), "method" => $method, "`rank`" => $rank]);

  return update_query("user", $id, ["email" => $email, "name" => $name, "method" => $method, "`rank`" => $rank]);
}

/**
 * @throws Exception
 */
function removeUser(int $id)
{
  return delete_query("user", $id);
}

// --- setting ---
function setting(int $id = null, string $name = null, bool $count = false): mixed
{
  if ($count)
    return query("SELECT COUNT(*) as res FROM `settings`")[0]->res;
  $where = [];
  if (!empty($id))
    $where["id=?"] = $id;
  if (!empty($name))
    $where["name=?"] = $name;
  if (!empty($where))
    return query("SELECT * FROM `settings` WHERE " . implode(" AND ", array_keys($where)), array_values($where));
  return query("SELECT * FROM `settings`");
}

/**
 * @throws Exception
 */
function createSetting(string $name, string $value)
{
  return insert_query("settings", ["`name`" => $name, "`value`" => $value]);
}

/**
 * @throws Exception
 */
function updateSetting(int $id, string $value)
{
  return update_query("settings", $id, ["`value`" => $value]);
}

/**
 * @throws Exception
 */
function removeSetting(int $id)
{
  return delete_query("settings", $id);
}
