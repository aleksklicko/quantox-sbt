<?php
/* Osnovna Klasa za povezivanje sa bazom i CRUD-om */
class DB {

    private $link;
    public $filter;
    static $inst = null;
    public static $counter = 0;

    /* Slanje email poruke adminu u slučaju neke greške ili baga u radu sa bazom */
	
    public function log_db_errors($error, $query) {
        $message = '<p>Vreme Greške ' . date('Y-m-d H:i:s') . ':</p>';
        $message .= '<p>SQL Upit: ' . htmlentities($query) . '<br />';
        $message .= 'Greška: ' . $error;
        $message .= '</p>';

        if (defined('SEND_ERRORS_TO')) {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'To: Admin <' . SEND_ERRORS_TO . '>' . "\r\n";
            $headers .= 'From: [Quantox Test] <error@quantox.com>' . "\r\n";

            mail(SEND_ERRORS_TO, 'Greška u bazi', $message, $headers);
        }

        if (DISPLAY_DEBUG) {
            echo $message;
        }
    }
	
    public function __construct() {
        global $connection;
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->link->connect_errno) {
            $this->log_db_errors("Greška pri konekciji", $this->link->connect_error);
            exit();
        }
        $this->link->set_charset("utf8");
    }

    public function __destruct() {
        $this->disconnect();
    }

    /* Filter Korisničkog Unosa
     * primer:
     * $user_name = $database->filter( $_POST['user_name'] );
     * 
     * primer za array:
     * $data = array( 'name' => $_POST['name'], 'email' => 'email@address.com' );
     * $data = $database->filter( $data ); */
    public function filter($data) {
        if (!is_array($data)) {
            $data = $this->link->real_escape_string($data);
            $data = trim(htmlentities($data, ENT_QUOTES, 'UTF-8', false));
        } else {
            //Self call function to sanitize array data
            $data = array_map(array($this, 'filter'), $data);
        }
        return $data;
    }

    /* Normalizovanje očišćenih podataka iz baze (obrnuto $database->filter čišćenje)
     * primer:
     * echo $database->clean( $data_from_database ); */
    public function clean($data) {
        $data = stripslashes($data);
        $data = html_entity_decode($data, ENT_QUOTES, 'UTF-8');
        $data = nl2br($data);
        $data = urldecode($data);
        return $data;
    }

    /* Izvršavanje Upita
     * Sve naredne funkcije se nadovezuju na ovu */
	 
    public function query($query) {
        $full_query = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return false;
        } else {
            return true;
        }
    }

    /* Broj redova za zadati upit
     * primer:
     * $rows = $database->num_rows( "SELECT id FROM users WHERE user_id = 44" ); */
    public function num_rows($query) {
        self::$counter++;
        $num_rows = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return $this->link->error;
        } else {
            return $num_rows->num_rows;
        }
    }

    /* Funkcija za dobijanje 1 reda u bazi iz upita
     * Primer:
     * list( $name, $email ) = $database->get_row( "SELECT name, email FROM users WHERE user_id = 44" );
     */
	 
    public function get_row($query) {
        self::$counter++;
        $row = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return false;
        } else {
            $r = $row->fetch_row();
            return $r;
        }
    }

    /* Izvrši upit kako bi dobio određeni array
     * primer:
     * $users = $database->get_results( "SELECT name, email FROM users ORDER BY name ASC" );
     * foreach( $users as $user )
     * {
     *      echo $user['name'] . ': '. $user['email'] .'<br />';
     * } */
	 
    public function get_results($query) {
        self::$counter++;
		
        $row = null;

        $results = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return false;
        } else {
            $row = array();
            while ($r = $results->fetch_assoc()) {
                $row[] = $r;
            }
            return $row;
        }
    }

    /* Upis podataka u tabelu
     * Primer:
     * $user_data = array(
     *      'name' => 'Petar', 
     *      'email' => 'email@adresa.com', 
     *      'active' => 1
     * );
     * $database->insert( 'users_table', $user_data ); */
	 
    public function insert($table, $variables = array()) {
        self::$counter++;
		
        if (empty($variables)) {
            return false;
        }

        $sql = "INSERT INTO " . $table;
        $fields = array();
        $values = array();
        foreach ($variables as $field => $value) {
            $fields[] = $field;
            $values[] = "'" . $value . "'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '(' . implode(', ', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;

        $query = $this->link->query($sql);

        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return true;
        }
    }

    /* Unos Više redova u jednom upitu
     * Primer:
     * $fields = array(
     *      'name', 
     *      'email', 
     *      'active'
     *  );
     *  $records = array(
     *     array(
     *          'Marko', 'marko@markomarko.com', 1
     *      ), 
     *      array(
     *          'Ivana', 'ivanica@google.com', 0
     *      ), 
     *      array(
     *          'Djole', 'djole@sajt.com', 1, 'Ovo nece biti dodato'
     *      )
     * );
     *  $database->insert_multi( 'users_table', $fields, $records ); */
	 
    public function insert_multi($table, $columns = array(), $records = array()) {
        self::$counter++;
        if (empty($columns) || empty($records)) {
            return false;
        }
        $number_columns = count($columns);
        $added = 0;

        $sql = "INSERT INTO " . $table;

        $fields = array();
        foreach ($columns as $field) {
            $fields[] = '`' . $field . '`';
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = array();
        foreach ($records as $record) {
            if (count($record) == $number_columns) {
                $values[] = '(\'' . implode('\', \'', array_values($record)) . '\')';
                $added++;
            }
        }
        $values = implode(', ', $values);

        $sql .= $fields . ' VALUES ' . $values;

        $query = $this->link->query($sql);

        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return $added;
        }
    }

    /* Izmena postojecih podataka u bazi
     * primer:
     * $update = array( 'name' => 'Novi Lik', 'email' => 'noviemail@google.com' );
     * $update_where = array( 'user_id' => 44, 'name' => 'Marko' );
     * $database->update( 'users_table', $update, $update_where, 1 ); */
	 
    public function update($table, $variables = array(), $where = array(), $limit = '') {
        self::$counter++;
        if (empty($variables)) {
            return false;
            exit;
        }
        $sql = "UPDATE " . $table . " SET ";
        foreach ($variables as $field => $value) {

            $updates[] = "`$field` = '$value'";
        }
        $sql .= implode(', ', $updates);
		
        if (!empty($where)) {
            foreach ($where as $field => $value) {
                $value = $value;

                $clause[] = "$field = '$value'";
            }
            $sql .= ' WHERE ' . implode(' AND ', $clause);
        }

        if (!empty($limit)) {
            $sql .= ' LIMIT ' . $limit;
        }

        $query = $this->link->query($sql);

        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return true;
        }
    }

    /* Brisanje podataka iz baze
     * primer:
     * $where = array( 'user_id' => 44, 'email' => 'someotheremail@email.com' );
     * $database->delete( 'users_table', $where, 1 ); */
	 
    public function delete($table, $where = array(), $limit = '') {
        self::$counter++;
		
        if (empty($where)) {
            return false;
            exit;
        }

        $sql = "DELETE FROM " . $table;
        foreach ($where as $field => $value) {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql .= " WHERE " . implode(' AND ', $clause);

        if (!empty($limit)) {
            $sql .= " LIMIT " . $limit;
        }

        $query = $this->link->query($sql);

        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return true;
        }
    }

    /* Dobijanje poslednjeg ID nakon upita
     * primer:
     * $database->insert( 'users_table', $user );
     * $last = $database->lastid(); */
	 
    public function lastid() {
        self::$counter++;
        return $this->link->insert_id;
    }
	
    /* Prikaži ukupan broj izvršenih upita
     * U principu ne služi ničemo sem OCD ljudima
     * Primer:
     * echo 'Izvršeno je ukupno '. $database->total_queries() . ' upita nad bazom'; */
	 
    public function total_queries() {
        return self::$counter;
    }

    /* Singleton funkcija
     * primer:
     * $database = DB::getInstance(); */
	 
    static function getInstance() {
        if (self::$inst == null) {
            self::$inst = new DB();
        }
        return self::$inst;
    }

    /* Diskonektovanje sa servera */
	
    public function disconnect() {
        $this->link->close();
    }

}
