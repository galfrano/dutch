//TODO: REALLY consider abstracting repeated functionality

function langManager(){

	var self = this;

	this.toDelete = this.selected = [];

	this.langCell = document.getElementById('langCell');

	//add functionality to action triggers
	this.mapMethods = function(){
		divList = this.langCell.getElementsByTagName('div');
		divList[0].getElementsByTagName('span')[0].onclick = function(){self.addName();};
		for(var x = 0; ++x<divList.length; this.langActions(divList[x]));
		this.uniqueLanguage();}

	//add language string and selector (both input and select)
	this.addName = function(){
		var newLangDiv = document.getElementById('new').getElementsByTagName('div')[0].cloneNode(true);
		this.langActions(newLangDiv);
		this.langCell.appendChild(newLangDiv);
		this.uniqueLanguage();}

	//remove language string and selector
	this.removeName = function(node){
		var del;
		if(del = node.parentNode.getElementsByTagName('input')[1]){
			this.toDelete.push(del.value);}
		document.getElementById('toDelete').value = this.toDelete;
		this.langCell.removeChild(node.parentNode);
		this.uniqueLanguage();}

	//add functionality to a single language div
	this.langActions = function(div){
		div.getElementsByTagName('span')[0].onclick = function(){self.removeName(this);};
		div.getElementsByTagName('select')[0].onchange = function(){self.uniqueLanguage();}}

	//collect selected languages
	this.uniqueLanguage = function(){
		this.selected = [];
		var selectList = this.langCell.getElementsByTagName('select');
		for(var x = 0; x < selectList.length; this.selected.push(selectList[x++].value));
		for(x = 0; x < selectList.length; this.disableUsedLanguages(selectList[x++]));}

	//disable selected languages
	this.disableUsedLanguages = function(select){
		var x = -1;
		while(++x<select.options.length){
			if(this.selected.indexOf(select.options[x].value) >= 0 && select.value != select.options[x].value){
				select.options[x].disabled = true;}
			else{
				select.options[x].disabled = false;}}}

	this.mapMethods();}

function subDirManager(){

	var self = this;

	this.toDelete = [];

	this.subDirCell = document.getElementById('subDirCell');

	this.mapMethods = function(){
		var divList = this.subDirCell.getElementsByTagName('div');
		divList[0].getElementsByTagName('span')[0].onclick = function(){self.addDir();};
		for(var x = 0; ++x<divList.length; divList[x].getElementsByTagName('span')[0].onclick = function(){self.removeDir(this);});}

	this.addDir = function(){
		var newLangDiv = document.getElementById('new').getElementsByTagName('div')[0].cloneNode(true);
		newLangDiv.getElementsByTagName('span')[0].onclick = function(){self.removeDir(this);};
		this.subDirCell.appendChild(newLangDiv);}

	this.removeDir = function(node){
		var del;
		if(del = node.parentNode.getElementsByTagName('input')[1]){
			this.toDelete.push(del.value);}
		document.getElementById('toDelete').value = this.toDelete;
		this.subDirCell.removeChild(node.parentNode);}

	this.mapMethods();}

function ajax(){

	var self = this;

	this.sizeSelect = document.getElementById('sizeSelect');

	this.mapMethods = function(){
		document.getElementById('productSelect').onchange = function(){self.getSizeFolders(this.value);}}

	this.getSizeFolders = function(product){
		if(!product){
			self.sizeSelect.disabled = 1;}
		else{
			var ajax = new XMLHttpRequest;
			ajax.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					self.sizeSelect.innerHTML = ajax.responseText;
					self.sizeSelect.disabled = 0;}}
			ajax.open('GET', './?section=Ajax&action=getSizeDirs&product='+product, true);
			ajax.send();}}

	this.mapMethods();}

window.onload = function(){
if(document.getElementById('subDirCell')){
	new subDirManager();}
else if(document.getElementById('langCell')){
	new langManager();}
else if(document.getElementById('sizeSelect')){
	new ajax();}}



