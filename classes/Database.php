<? 
class Database {
	private $_conn;

	public function __construct()
	{
		try {
			$this->_conn = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			$this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_conn->exec('set names utf8');
		}
		catch (PDOExeption $e) {
			die($e->getMessage());
		}
	}
	
	/*
	*	Gelen sql verileri array olarak döndürür.
	*/
	public function queryDBSecure($sql)
	{
		$result = $this->_conn->query($sql);
		return $result;
	}
	
	public function prepareDBSecure($sql)
	{
		$result = $this->_conn->prepare($sql);
		return $result;
	}

	//* Database bağlantısını sonlandırmak için
	public function logOffDatabase()
	{
		$this->_conn = null;
	}
}
?>