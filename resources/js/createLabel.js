const color = document.querySelector('#color');
const colorWheel = document.querySelector('#colorWheel');
color.addEventListener('change', changeColor);
colorWheel.addEventListener('change', changeColor);

function changeColor(e) {
	console.log(e.target, e.target.value);
	if(e.target == color) {
		colorWheel.value = '#' + color.value;
	} else {
		color.value = (colorWheel.value).substring(1, 7);
	}
}
