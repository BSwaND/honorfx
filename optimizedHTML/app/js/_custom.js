document.addEventListener("DOMContentLoaded", function() {

	$(window).scroll(function() {
		var q = $(this);
		var goToUp = document.querySelector(".btn-up");

		if (q.scrollTop() > 800) {
			goToUp.classList.add("btn-up_active");
		} else{
			goToUp.classList.remove("btn-up_active");
		}
	});
	$('.btn-up').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});

	$(function () {
		$('.popup-modal').magnificPopup({
			type: 'inline',
			preloader: false,
			focus: '#username',
			modal: true
		});
		$(document).on('click', '.popup-modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
	});

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});


	var TabsNavigator = function (element) {
		const buttons = document.querySelectorAll(element.buttons);
		const itemsBlock = document.querySelectorAll(element.itemsBlock);
		const activeButton = element.activeButton;
		const displayBlockItem = element.displayBlockItem;

		if(!itemsBlock[0]) return;
		itemsBlock[0].classList.add(displayBlockItem);

		for (let i=0; i <buttons.length;  i++){
			buttons[i].onclick = function(e){
				e.preventDefault();
				remuveClass(buttons,  activeButton);
				remuveClass(itemsBlock, displayBlockItem);
				this.classList.remove('qq');
				this.classList.add(activeButton);
				itemsBlock[i].classList.add(displayBlockItem);
			}
		}
		function remuveClass(el, className) {
			for (let x = 0; x < el.length;  x++){
				el[x].classList.remove(className);
			}
		}
	};


	new TabsNavigator({
		buttons: '.tab_btn',
		itemsBlock: '.tab_window',
		activeButton: 'active',
		displayBlockItem: 'display-block'
	});


});
