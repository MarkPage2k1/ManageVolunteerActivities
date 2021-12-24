<?php 
    class MyModels extends Database 
    {
        public function select_array($data = '*', $where = null) {
            $sql = "SELECT $data FROM $this->table ";
            if ( isset($where) && $where != null) {
                $fields = array_keys($where);
                $fields_list = implode("", $fields);
                $values = array_values($where);
                $isFields = true;
                $strWhere = 'where';
                // where id = ? and id = ?
                for ($i=0; $i < count($fields); $i++) { 
                    if (!$isFields) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields = false;
                    $sql .= " ".$strWhere." ".$fields[$i]." = ?";
                }            
                $query = $this->conn->prepare($sql);
                $query->execute($values);
            }
            else {
                $query = $this->conn->prepare($sql);
                $query->execute();
            }
           
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function select_array_where_not_status($data = '*', $where_not = null) {
            $sql = "SELECT $data FROM $this->table ";
            if ( isset($where_not) && $where_not != null) {
                $fields = array_keys($where_not);
                $fields_list = implode("", $fields);
                $values = array_values($where_not);
                $isFields = true;
                $strWhere_not = 'where not';
                // where id = ? and id = ?
                for ($i=0; $i < count($fields); $i++) { 
                    if (!$isFields) {
                        $sql .= " AND ";
                        $strWhere_not = ' not ';
                    }
                    $isFields = false;
                    $sql .= " ".$strWhere_not." status = ?";
                }           
                $query = $this->conn->prepare($sql);
                $query->execute($values);
            }
            else {
                $query = $this->conn->prepare($sql);
                $query->execute();
            }
           
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function add($data = null) {
            $fields = array_keys($data);
            $fields_list = implode(",", $fields);
            $values = array_values($data);
            $qr = str_repeat("?, ", count($fields) - 1);
            $sql = "INSERT INTO `".$this->table."`(".$fields_list.") VALUES(${qr}?)";
            $query = $this->conn->prepare($sql);
            if ($query->execute($values)) {
                return json_encode(
                    array(
                        'type'      => 'successfully',
                        'message'   => 'Inserted successfully',
                        'username'  => $this->conn->lastInsertId()
                    )
                );
            } else {
                return json_encode(
                    array(
                        'type'      => 'fails',
                        'message'   => 'Inserted fails',
                    )
                );
            }
        }

        public function update($data = null, $where = null) {
            if ($data != null) {
                $fields = array_keys($data);
                $values = array_values($data);
                $where_array = array_keys($where);
                $values_where = array_values($where);
                $sql = "UPDATE $this->table SET ";
                $isFields = true;
                $isFields_where = true;
                $strWhere = 'where';
                for ($i=0; $i < count($fields); $i++) { 
                    if (!$isFields) {
                        $sql .= ", ";
                    }
                    $isFields = false;
                    $sql .= "".$fields[$i]." = ?";
                } 
                for ($i=0; $i < count($where_array); $i++) { 
                    if (!$isFields_where) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields_where = false;
                    $sql .= " ".$strWhere." ".$where_array[$i]." = '".$values_where[$i]."'";
                } 
                $query = $this->conn->prepare($sql);
                if ($query->execute($values)) {
                    return json_encode(
                        array(
                            'type'      => 'successfully',
                            'message'   => 'Updated successfully',
                            'username'  => $this->conn->lastInsertId()
                        )
                    );
                } else {
                    return json_encode(
                        array(
                            'type'      => 'fails',
                            'message'   => 'Updated fails',
                        )
                    );
                }
            }
        }

        public function delete($where = null) {
            $sql = "DELETE FROM $this->table ";
            if ($where != null) {
                $where_array = array_keys($where);
                $values_where = array_values($where);
                $isFields_where = true;
                $strWhere = 'where';
                for ($i=0; $i < count($where_array); $i++) { 
                    if (!$isFields_where) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields_where = false;
                    $sql .= " ".$strWhere." ".$where_array[$i]." = '".$values_where[$i]."'";
                } 
                $query = $this->conn->prepare($sql);
                if ($query->execute()) {
                    return json_encode(
                        array(
                            'type'      => 'successfully',
                            'message'   => 'Deleted successfully',
                            'username'  => $this->conn->lastInsertId()
                        )
                    );
                } else {
                    return json_encode(
                        array(
                            'type'      => 'fails',
                            'message'   => 'Deleted fails',
                        )
                    );
                }
            }
        }

        public function select_row($data='*', $where=null) {
            $sql = "SELECT $data FROM $this->table ";
            if ($where != null) {
                $where_array = array_keys($where);
                $values_where = array_values($where);
                $isFields_where = true;
                $strWhere = 'where';
                for ($i=0; $i < count($where_array); $i++) { 
                    if (!$isFields_where) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields_where = false;
                    $sql .= " ".$strWhere." ".$where_array[$i]." = '".$values_where[$i]."'";
                } 
                $query = $this->conn->prepare($sql);
                $query->execute();
                return $query->fetch(PDO::FETCH_ASSOC);
            }
        }

        public function select_row_where_not($data='*', $where=null) {
            $sql = "SELECT $data FROM $this->table ";
            if ($where != null) {
                $where_array = array_keys($where);
                $values_where = array_values($where);
                $isFields_where = true;
                $strWhere = 'where not';
                for ($i=0; $i < count($where_array); $i++) { 
                    if (!$isFields_where) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields_where = false;
                    $sql .= " ".$strWhere." ".$where_array[$i]." = '".$values_where[$i]."'";
                } 
                $query = $this->conn->prepare($sql);
                $query->execute();
                return $query->fetch(PDO::FETCH_ASSOC);
            }
        }

        public function select_max_fields($data = '', $where = null) {
            if ($data != '') {
                $sql = "SELECT MAX(".$data.") as sort FROM $this->table";
            }
            if ($where != null) {
                $where_array = array_keys($where);
                $values_where = array_values($where);
                $isFields_where = true;
                $strWhere = 'where';
                for ($i=0; $i < count($where_array); $i++) { 
                    if (!$isFields_where) {
                        $sql .= " AND ";
                        $strWhere = '';
                    }
                    $isFields_where = false;
                    $sql .= " ".$strWhere." ".$where_array[$i]." = ?";
                } 
            }
            $query = $this->conn->prepare($sql);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }

?>