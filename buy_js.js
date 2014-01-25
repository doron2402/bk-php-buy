function selected(elementID)
{
	var object = document.getElementById('content' + elementID);	object.style.display = 'block';
	object = document.getElementById('contentm' + elementID);	object.style.display = 'none'

	for (x = 0; x <= 30; x++) {
		if (x.toString() != elementID) {
			var obj2 = document.getElementById('content' + x.toString());
			if (obj2 != null) {
				obj2.style.display = 'none';
				obj2 = document.getElementById('contentm' + x.toString());
				obj2.style.display = 'block'; }	} } return; }

function selected_main(elementID)
{
	var object = document.getElementById('ccc' + elementID);	object.style.display = 'block';
	object = document.getElementById('cccm' + elementID);	object.style.display = 'none'

	for (x = 0; x <= 30; x++) {
		if (x.toString() != elementID) {
			var obj2 = document.getElementById('ccc' + x.toString());
			if (obj2 != null) {
				obj2.style.display = 'none';
				obj2 = document.getElementById('cccm' + x.toString());
				obj2.style.display = 'block'; }	} } return; }

function is_present()
{
  if(document.getElementById('present').checked) selected('1');
  else selected('0');
}
function ch()
{
  if(document.getElementById('shipping').value == "0") selected_main('0');
  else selected_main('1');
}
