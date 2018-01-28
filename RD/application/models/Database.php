<?php
/*
 *@auther SEVEN
 *@version1.0
 */

class DatabaseModel {
	protected static $_instance = null;
	protected $dbname = '';
	protected $dsn;
	protected $dbh;
	protected $sth; 

	//构造
	public function __construct($db_config) {
		try {
			$this->dbname = $db_config['database'];
			$this->mPrefix = isset($db_config['prefix']) ? $db_config['prefix'] : '';
			if ($db_config['type'] == 'mysql') {
				$this->dsn = 'mysql:host=' . $db_config['host'] . ';dbname=' . $db_config['database'];
			} else if ($db_config['type'] == 'sqlsrv') {
				$this->dsn = 'sqlsrv:Server=' . $db_config['host'] . ';Database=' . $db_config['database'];
			}
			$this->dbh = new PDO($this->dsn, $db_config['username'], $db_config['password']);
			if ($this->dbh) {
				$this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
				$this->dbh->exec('SET character_set_connection=utf8,character_set_results=utf8,character_set_client=binary');
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//防止克隆
	private function __clone() {}

	//单例模式
	public static function getInstance($db_config = null) {
		if (empty($db_config)) {
			$db_config = Yaf\Registry::get('config')->db;
		}
		if (self::$_instance === null) {
			self::$_instance = new self($db_config);
		}
		return self::$_instance;
	}

	//预处理模式
	public function prepare($sql){
		$this->sth = $this->dbh->prepare($sql);
		$this->getPDOError();
		$result = $this->sth;
		$this->sth = null;
		return $result;
	}

	//获取PDO错误信息  
	private function getPDOError() {  
		if($this->dbh->errorCode() != '00000') {  
			$error = $this->dbh->errorInfo();  
			exit($error[2]);  
		}  
	} 

	/**
	 * * destruct 关闭数据库连接
	 * */
	public function destruct() {
		$this->dbh = null;
	}

}