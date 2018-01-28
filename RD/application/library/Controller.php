<?php
//公用基类
class Controller extends Yaf\Controller_Abstract {
	protected $db; //定义数据库
	protected $surAuth;

	//数据库初始化函数
	public function init() {
		$this->surAuth = array('allEdit'=>'1801696799','allSelect'=>'1801696790','xlEdit'=>'20162018','xlSelect'=>'20162017');
		//打开数据库（单例）
		$this->db = DatabaseModel::getInstance();
	}
}