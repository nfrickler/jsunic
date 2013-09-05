<?php
/** MySQL database class
 *
 * This class handles the access to a MySQL database and will be used from 
 * Database object
 */
class Mysql {

    /** MySQL host
     * @var string $host
     */
    private $host;

    /** MySQL user
     * @var string $user
     */
    private $user;

    /** MySQL password
     * @var string $password
     */
    private $password;

    /** MySQL database
     * @var string $database
     */
    private $database;

    /** Current connection
     */
    private $con;

    /** Constructor
     *
     * @param string $host
     *	MySQL host
     * @param string $user
     *	MySQL user
     * @param string $password
     *	MySQL password
     * @param string $database
     *	MySQL database
     */
    public function __construct ($host, $user, $password, $database) {

	// save parameters
	$this->host = $host;
	$this->user = $user;
	$this->password = $password;
	$this->database = $database;

	// connect to database
	$this->doConnect();

	return;
    }

    /** Make sure, we have a connection to the database
     *
     * @return bool
     */
    private function doConnect () {

	// already connected?
	if (!empty($this->con) AND @mysql_ping($this->con)) return true;

	// connect to database
	$this->con = @mysql_connect($this->host, $this->user, $this->password);
	if ($this->con) $db = @mysql_select_db($this->database);

	// handle errors
	if (!$this->con OR !$db) return false;

	return true;
    }

    /** Send query to database
     *
     * @param string $sql
     *	SQL query
     *
     * @return MySQL result
     */
    private function _sendQuery ($sql) {

	// connect to database
	if (!$this->doConnect()) return false;

	// send query
	$result = @mysql_query($sql);

	return $result;
    }

    /** Fetch data from database
     *
     * @param string $sql
     *	SQL query
     *
     * @return array|bool
     */
    public function doSelect ($sql) {

	// fetch data from database via query
	$result = $this->_sendQuery($sql);
	if (!$result) return false;

	// sum output in array
	$output = array();
	while ($row = mysql_fetch_assoc($result)) $output[] = $row;

	return $output;
    }

    /** Update database
     *
     * @param string $sql
     *	SQL query
     *
     * @return bool
     */
    public function doUpdate ($sql) {
	return ($this->_sendQuery($sql)) ? true : false;
    }

    /** Insert a new row/several new rows
     *
     * @param string $sql
     *	SQL query
     *
     * @return bool
     */
    public function doInsert ($sql) {
	return ($this->_sendQuery($sql)) ? true : false;
    }

    /** Get id of last inserted row
     *
     * @return int
     */
    public function lastId () {
	return mysql_insert_id();
    }

    /** Delete rows in database
     *
     * @param string $sql
     *	SQL query
     *
     * @return bool
     */
    public function doDelete ($sql) {
	return ($this->_sendQuery($sql)) ? true : false;
    }

    /** Just send query as is and return result
     *
     * @param string $sql
     *	SQL query
     *
     * @return bool
     */
    public function doQuery ($sql) {
	return $this->_sendQuery($sql);
    }

    /** Get names of columns of a table
     *
     * @param string $table
     *	Name of table to get columns from
     *
     * @return array|bool
     */
    public function getColumns ($table) {

	// get columns
	$sql = "SHOW COLUMNS FROM ".mysql_real_escape_string($table).";";
	$result = $this->_sendQuery($sql);
	if (!$result) return false;

	// put return in array
	$columns = array();
	while ($arr = mysql_fetch_assoc($result)) $columns[] = $arr['Field'];

	return $columns;
    }

    /** Create a new table
     *
     * @param string $sql
     *	SQL query
     *
     * @return bool
     */
    public function createTable ($sql) {
	return ($this->_sendQuery($sql)) ? true : false;
    }

    /** Check, if table exists
     *
     * @param string $table
     *	Name of table
     *
     * @return bool
     */
    public function isTable ($table) {

	// get and send query
	$sql = "SHOW TABLES LIKE '".mysql_real_escape_string($table)."';";
	$result = $this->_sendQuery($sql);

	// check, if table exists
	if ($result AND mysql_num_rows($result) > 0)
	    //table exists
	    return true;
	else
	    //table doesn't exist
	    return false;
    }

    /** Check, if database object is operating correctly
     *
     * @return bool
     */
    public function isValid () {
	if ($this->doConnect()) return true;
	return false;
    }

    /** Get MySQL errors
     *
     * @return bool|array
     */
    public function getError () {

	// try to get error
	$output = @mysql_error();

	if (empty($output)) return false;
	return $output;
    }
}
?>
