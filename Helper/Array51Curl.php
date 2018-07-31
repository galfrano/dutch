<?php /*gabriel.perez@helloprint.com*/
namespace Helper;

class Array51Curl{

	protected $token, $array51URL = _CHILI_ARRAY51_API_URL_, $credentials = ['user'=>'admin', 'password'=>_CHILI_ARRAY51_API_PASS_];
	
	function __construct(){
		$curl = curl_init($this->array51URL.'sessions');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->credentials);
		($curl_response = curl_exec($curl)) !== false or self::kill(curl_getinfo($curl));
		curl_close($curl);
		$this->token = json_decode($curl_response)->data->token;}

	private static function kill($message){
		throw new \Exception($message);}

	function update($templateName, $templateId){
		$header = ['authorization: '.$this->token, 'cache-control: no-cache', 'content-type: application/json'];
		$post = json_encode(['template'=>['notes'=>'bla bla.', 'referenceName'=>$templateName, 'chiliDocumentId'=>$templateId, 'chiliWorkspaceId'=>_CHILI_WORKSPACE_, 'sortingPriority'=>0, 'type'=>'designing', 'locale'=>'en_US']]);
		$curl = curl_init($this->array51URL.'templates');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, ($post));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		$curl_response = curl_exec($curl);
		curl_close($curl);
		$decoded = json_decode($curl_response, 1);
		empty($decoded['error']) or self::kill('Error occured: '.$decoded['error']['message']);}}
