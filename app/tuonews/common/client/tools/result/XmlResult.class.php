<?php
namespace client\tools\result;
/**
 * Xml格式返回结果
 * Class XmlResult
 * @package client\tools\result
 */
class XmlResult extends AbstractResult{
	
	public static function fromString($result) {
		throw new Exception("此操作[fromString]暂不支持");
	}
}

?>