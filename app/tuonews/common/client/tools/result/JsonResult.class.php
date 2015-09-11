<?php
namespace client\tools\result;
/**
 * Json格式返回结果
 * Class JsonResult
 * @package client\tools\result
 */
class JsonResult extends AbstractResult{
	
	public static function fromString($result) {
		
		$resultArray = json_decode($result, true);
		
		$result = new JsonResult();
		$result->setCode($resultArray['code']);
		$result->setMessage($resultArray['message']);
		$result->setCurrentPage($resultArray["datas"]["currentpage"]);
		$result->setPageNum($resultArray["datas"]["pagecount"]);
		$result->setDatas($resultArray['datas']);
		return $result;
	}
}

?>