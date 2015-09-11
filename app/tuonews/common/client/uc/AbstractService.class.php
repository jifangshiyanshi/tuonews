<?php
namespace api\uc;
use api\tools\HttpClient;
use api\tools\result\JsonResult;
use api\tools\result\XmlResult;

include dirname(__DIR__).'/tools/HttpClient.class.php';
include dirname(__DIR__).'/tools/result/AbstractResult.class.php';
include dirname(__DIR__).'/tools/result/JsonResult.class.php';
include dirname(__DIR__).'/tools/result/XmlResult.class.php';

/**
 * 服务抽象类
 * Class AbstractService
 * @package common\client
 * @author yangjian102621@163.com
 * @since 2015-03-17
 */
abstract class AbstractService{
	
	/**
	 * 开放接口域名
	 * @var string
	 */
	protected $domain = "http://uc.juke123.com";
	
	/**
	 * API返回的结果类型
	 * @var string
	 */
	protected $reusltType = 'json';
	
    /**
     * GET请求通用服务
     * @param string $apiURI 接口uri
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    protected function serviceGet($apiURI, $parameters=array()) {
		$apiURI = str_replace('.', '/', $apiURI);
		if($apiURI[0] == '/'){
			$apiURL = $this->domain . $apiURI;
		} else {
			$apiURL = $this->domain . '/' . $apiURI;
		}
		$httpClient = new HttpClient();
		$result = $httpClient->get($apiURL, $parameters);
		switch($this->reusltType){
			case 'json':
				return JsonResult::fromString($result);
			case 'xml':
				return XmlResult::fromString($result);
			default:
				throw new \Exception("不支持的结果类型:[{$this->reusltType}]");
		}
	}

    /**
     * POST请求通用服务
     * @param string $apiURI 接口uri
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    protected function servicePost($apiURI, $parameters=array()) {
        $apiURI = str_replace('.', '/', $apiURI);
        if($apiURI[0] == '/'){
            $apiURL = $this->domain . $apiURI;
        } else {
            $apiURL = $this->domain . '/' . $apiURI;
        }
        $httpClient = new HttpClient();
        $result = $httpClient->post($apiURL, $parameters);
        switch($this->reusltType){
            case 'json':
                return JsonResult::fromString($result);
            case 'xml':
                return XmlResult::fromString($result);
            default:
                throw new \Exception("不支持的结果类型:[{$this->reusltType}]");
        }
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

}

?>