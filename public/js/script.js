/****************** HEADER *******************/

$('.achat_resume').hide(100);
$('.achat_container').hide(100);

$('#achat').click(() => {
	$('.achat_container').stop();
	$('.achat_resume').stop();
	$('.achat_resume').css("visibility", "visible");
	$('.achat_container').slideToggle(1300);
	$('.achat_resume').fadeToggle(1300);
});

/*//////////////////////////////// PAGE - HOME ////////////////////////////////*/

/****************** SECTION-1 INTRO *******************/

$('.intro_container h1').animate({
	left: 0
},1500);


$('.btnleft').animate({
	bottom: '50px',
    opacity: "100%",
},1300);

$('.btnright').animate({
	bottom: '50px',
    opacity: "100%",
},1000);


/****************** SECTION-2 CAROUSEL *******************/

const items = document.querySelectorAll('.carousel_item');
const nbSlide = items.length;
const suivant = document.querySelector('.arrow_right');
const precedent = document.querySelector('.arrow_left');
let count = 0;

setTimeout(autoplay, 3000);
function autoplay(){
	items[count].classList.remove('active');

	if(count < nbSlide - 1){
		count++;
	} else {
		count = 0;
	}
	setTimeout(autoplay, 3000);
	items[count].classList.add('active');
}

function slideSuivant(){
	items[count].classList.remove('active');

	if(count < nbSlide - 1){
		count++;
	} else {
		count = 0;
	}
	items[count].classList.add('active');
}
suivant.addEventListener('click', slideSuivant);

function slidePrecedent(){
	items[count].classList.remove('active');

	if(count > 0){
		count--;
	} else {
		count = nbSlide - 1;
	}

	items[count].classList.add('active');
}
precedent.addEventListener('click', slidePrecedent);

