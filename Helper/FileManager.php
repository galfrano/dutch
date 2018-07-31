<?php /*gabriel.perez@helloprint.com*/
namespace Helper;

class FileManager{

	//open file, correct paths and modify xml files
	function processZip($tmpfn, $fonts){
		$zip = new \ZipArchive;
		$zip->open($tmpfn);
		for($x = 0; $x < $zip->numFiles; $x++) {
			$name = $zip->getNameIndex($x);
			if(strpos($name, 'Assets') !== false && substr($name, -1) != '/'){
				$path = explode('/', $name);
				$zip->renameName($name, 'Assets/Exported/ExtensionTest/metric/'.$path[3]);}}
		$zip->deleteName('Assets/From InDesign/'.$path[2].'/');
		$zip->deleteName('Assets/From InDesign/');
		$assetsXML = str_replace('From InDesign\\'.$path[2], 'Exported\ExtensionTest\metric', $zip->getFromName('assets.xml'));
		$zip->deleteName('assets.xml');
		$zip->addFromString('assets.xml', $assetsXML);
		list($fontsXML, $documentXML) = [$zip->getFromName('fonts.xml'), $zip->getFromName('document.xml')];
		$missing = $this->addFonts($fontsXML, $documentXML, $fonts);
		$zip->deleteName('fonts.xml');
		$zip->deleteName('document.xml');
		$zip->addFromString('document.xml', $documentXML);
		$zip->addFromString('fonts.xml', $fontsXML);
		$zip->close();
		return ['data'=>base64_encode(file_get_contents($tmpfn)), 'missing'=>$missing];}

	//overwrite document.xml & fonts.xml strings and return any missing font matches
	protected function addFonts(&$fontsXML, &$documentXML, $fonts){
		for(list($items, $fontsInXML) = [(new \SimpleXMLElement($fontsXML))->xpath('item'), []]; list($k, $node) = each($items); $fontsInXML[self::matchFile((string)$node['file'])] = (string)$node['id']);
		$document = new \SimpleXMLElement($documentXML);
		$fontItems = $document->xpath('/document/fonts/item');
		while(list($k, $fontItem) = each($fontItems)){
			unset($fontItem[0]);}
		list($fontNode, $fontsXML) = [current($document->xpath('/document/fonts')), '<fonts defaultLocation="General\FromInDesign">'."\n"];
		while(list($match, $font) = each($fonts)){
			$fontsXML .= ' <item id="'.$font['id'].'" file="\Fonts\\'.$font['path'].'" />'."\n";
			$newFontNode = $fontNode->addChild('item');
			$newFontNode->addAttribute('id', $font['id']);
			$newFontNode->addAttribute('name', '');
			$newFontNode->addAttribute('family', '');
			$newFontNode->addAttribute('style', '');
			$newFontNode->addAttribute('swfURL', '');}
		//looping instead of passing arrays in order to collect missing font matches
		for($documentXML = $document->asXML(), $nF = []; list($match, $fontId) = each($fontsInXML); key_exists($match, $fonts) ? str_replace($fontId, $fonts[$match]['id'], $documentXML) : $nF[] = $match);
		$fontsXML .= '</fonts>';
		return $nF;}

	//TODO: consider moving this method somewhere else
	static function matchFile($string){
		$file = explode('.', str_replace(['\Fonts\\', 'From InDesign\\', 'General\\', 'FromInDesign\\'], '', $string));
		$file[0] = preg_replace(['/_\d+$/', '/ \(\d+\)$/'], '', $file[0]);
		return strtolower(implode('.', $file));}}
