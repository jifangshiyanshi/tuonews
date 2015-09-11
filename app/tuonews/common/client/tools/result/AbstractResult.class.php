<?php
namespace client\tools\result;

/**
 * 抽象返回结果
 * Class AbstractResult
 * @package client\tools\result
 */
abstract class AbstractResult{
	
	static $DATA_KEY_ITEM = "item";// 返回一条
	
	static $DATA_KEY_ITEMS = "items";// 返回多条
	
	static $DATA_KEY_COUNT = "count";// 数量
	
	/**
	 * 返回标记code，小于等于0说明错误(如参数错误等等)
	 * @var string
	 */
	protected $code = "";
	
	/**
	 * 提示message
	 * @var string
	 */
	protected $message = "";
	
	/**
	 * 
	 * 数据分页码
	 * 
	 */
	protected $currentpage=1;
	
	/**
	 * 总页数
	 * 
	 */
	protected $totalPage;
	/**
	 * 返回数据的内容
	 * @var array
	 */
	protected $datas = array();
	
	public function getCode() {
		return $this->code;
	}
	
	public function setCode($code) {
		$this->code = $code;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function getDatas() {
		return $this->datas;
	}
	
	public function setDatas($datas) {
		$this->datas = $datas;
	}
	
	public function putData($key, $value) {
		$this->datas[$key] = $value;
	}
	
	
	public function putItem($value) {
		$this->putData(self::$DATA_KEY_ITEM, $value);
	}
	
	public function getItem(){
		return $this->datas[self::$DATA_KEY_ITEM];
	}
	
	public function putItems($value) {
		$this->putData(self::$DATA_KEY_ITEMS, $value);
	}
	
	public function getItems() {
		return $this->datas[self::$DATA_KEY_ITEMS];
	}
	
	public function putCount($value) {
		$this->putData(self::$DATA_KEY_COUNT, $value);
	}
	
	public function getCount() {
		return $this->datas[self::$DATA_KEY_COUNT];
	}
	
	public function isSuccess() {
		return $this->code == '' || $this->code > 0;
	}
	
	public function setCurrentPage($currentPage){
		$this->currentpage=$currentPage;
	}
	
	public function getCurrentPage(){
		return $this->currentpage;
	}
	
	public function setPageNum($total){
		$this->totalPage=$total;
	}
	
	public function getPageNum(){
		return $this->totalPage;
	}
	
	public static function fromString($result) {
		throw new Exception("此操作[fromString]暂不支持");
	}
}

?>