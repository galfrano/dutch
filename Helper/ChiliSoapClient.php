<?php /*gabriel.perez@helloprint.com*/
namespace Helper;
//TODO: consider consuming configuration file or using constants
class ChiliSoapClient{

	protected $client, $apiKey, $fonts = [];

	function __construct(){
		$this->client = new \SoapClient('http://chili-pub-lb-164573437.eu-west-1.elb.amazonaws.com/chili/main.asmx?wsdl');
		$apiKey = $this->client->GenerateApiKey(['environmentNameOrURL'=>_CHILI_ENVIRONMENT_, 'userName'=>'hellochili', 'password'=>'hellochili']);
		$this->apiKey = (new \SimpleXMLElement($apiKey->GenerateApiKeyResult))['key'];}

	function uploadTemplate($folder, $name, $data){
		$response = $this->client->DocumentCreateFromChiliPackage(['apiKey'=>$this->apiKey, 'documentName'=>$name, 'folderPath'=>'/design/'.$folder, 'packagePathOrData'=>$data]);
		return (new \SimpleXMLElement($response->DocumentCreateFromChiliPackageResult))['id'];}

	//generate 4 random hexadecimal characters
	private static function hex4(){
		return str_pad(dechex(rand(0, 65535)), 4, '0', STR_PAD_LEFT);}

	//generate new random chili formated hexadecimal id
	private function hexgen($r){
		$hex = self::hex4().self::hex4().'-'.self::hex4().'-'.self::hex4().'-'.self::hex4().'-'.self::hex4().self::hex4().self::hex4();
		return key_exists($hex, $r) ? $this->hexgen($r) : $hex ;}

	//TODO: consider different approach to font storage.
	function getFonts(){
		if(empty($_SESSION['chili']['fonts'])){
			$responseXML = $this->client->ResourceGetTree(['apiKey'=>$this->apiKey, 'includeSubDirectories'=>true, 'includeFiles'=>true, 'resourceName'=>'Fonts'])->ResourceGetTreeResult;
			$fonts = (new \SimpleXMLElement($responseXML))->xpath('/tree/item')[1]->xpath('item/item');
			for(; list($k, $value) = each($fonts); $this->fonts[FileManager::matchFile($value['path'])] = ['id'=>$this->hexgen($this->fonts), 'path'=>(string) $value['path']]);
			$_SESSION['chili']['fonts'] = $this->fonts;}
		return $_SESSION['chili']['fonts'];}}
