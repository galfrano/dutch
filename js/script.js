//RULES: what should be a div whose first span will become a remover.
function cloner(what, where, who){
	this.what = what, this.where = where, this.toDelete = [];
	var self = this;
	who.onclick = function(){self.clone();}
	for(var minus = this.where.getElementsByTagName('span'), x = 0; x<minus.length; minus[x++].onclick = function(){self.remove(this);});

	this.clone = function(){
		var clonedNode = this.what.cloneNode(true);
		this.where.appendChild(clonedNode);
		clonedNode.getElementsByTagName('span')[0].onclick = function(){self.remove(this);};}

	this.remove = function(node){
		if(del = node.parentNode.getElementsByTagName('input')[0]){
			this.toDelete.push(del.value);}
		document.getElementById('toDelete').value = this.toDelete;
		this.where.removeChild(node.parentNode);}}

//TODO: consider taking names into account to support multiple selects
function distinctValues(where){

	this.selectList = where.getElementsByTagName('select');
	this.minus = where.getElementsByTagName('span');
	var self = this;

	this.collectDisable = function(){
		for(var x = 0, selected = []; x < this.selectList.length; this.mapAndCollect(selected, x++));
		for(var i = 0; i < this.selectList.length; this.disableUsed(this.selectList[i++], selected));}

	this.mapAndCollect = function(selected, x){
		this.selectList[x].onchange = function(){self.collectDisable();}
		this.minus[x].addEventListener('click', function(){self.collectDisable();});
		selected.push(this.selectList[x].value);}

	this.disableUsed = function(select, selected){
		for(var x = -1; ++x<select.options.length; select.options[x].disabled = (selected.indexOf(select.options[x].value) >= 0 && select.value != select.options[x].value));}

	this.collectDisable();}


window.onload = function(){
	var what, where, who, button, test;
	if((what = document.getElementById('newTag')) && (where = document.getElementById('tags')) && (who = document.getElementById('plus'))){
		var dv = new distinctValues(where);
		var clonerObj = new cloner(what.getElementsByTagName('div')[0], where, plus);
		who.addEventListener('click', function(){dv.collectDisable();});
		document.body.onkeydown = function(e){
			if(e.keyCode == 107){
				clonerObj.clone();}};}
	else if(button = document.getElementById('action-new')){
		document.body.onkeydown = function(e){
			if(e.keyCode == 78){
				button.click();}};}
	else if(test = document.getElementById('dutch-test')){
		for(var x = 0, buttons = test.getElementsByTagName('button'); x<buttons.length; buttons[x++].onclick = function(){
			var input = this.parentNode.getElementsByTagName('input')[0];
			input.disabled = 1;
			if(input.value == this.value){
				this.className = 'btn btn-xs btn-success';
				this.innerHTML = 'Correct';}
			else{
				input.value += '/'+this.value;
				this.className = 'btn btn-xs btn-danger';
				this.innerHTML = 'Incorrect';}});}}


function ajax(url){
	var xmlhttp = new XMLHttpRequest();
	}
