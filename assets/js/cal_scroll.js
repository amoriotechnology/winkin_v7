$(document).ready(function() {

	var scrollDuration = 300;

	var leftPaddle = document.getElementsByClassName('cal-left-paddle');
	var rightPaddle = document.getElementsByClassName('cal-right-paddle');

	// get items dimensions
	var itemsLength = $('.cal-item').length;
	var itemSize = $('.cal-item').outerWidth(true);
	var paddleMargin = 20;

	var getMenuWrapperSize = function() {
		return $('.cal-menu-wrapper').outerWidth();
	}
	var menuWrapperSize = getMenuWrapperSize();

	$(window).on('resize', function() {
		menuWrapperSize = getMenuWrapperSize();
	});

	var menuVisibleSize = menuWrapperSize;

	var getMenuSize = function() {
		return itemsLength * itemSize;
	};

	var menuSize = getMenuSize();
	var menuInvisibleSize = (menuSize - menuWrapperSize);

	// get how much have we scrolled to the left
	var getMenuPosition = function() {
		return $('.cal-menu').scrollLeft();
	};

	// finally, what happens when we are actually scrolling the menu
	$('.cal-menu').on('scroll', function() {

		menuInvisibleSize = (menuSize - menuWrapperSize);
		var menuPosition = getMenuPosition();
		var menuEndOffset = (menuInvisibleSize - paddleMargin);

		// depending on scroll position
		if (menuPosition <= paddleMargin) {
			$(leftPaddle).addClass('hidden');
			$(rightPaddle).removeClass('hidden');

		} else if (menuPosition < menuEndOffset) {
			// show both paddles in the middle
			$(leftPaddle).removeClass('hidden');
			$(rightPaddle).removeClass('hidden');

		} else if (menuPosition >= menuEndOffset) {
			$(leftPaddle).removeClass('hidden');
			$(rightPaddle).addClass('hidden');
		}

	});


	$(rightPaddle).on('click', function() {
		var scrollLeft = getMenuPosition();
		var scrollWidth = getMenuWrapperSize();
		$('.cal-menu').animate( { scrollLeft: (scrollWidth + scrollLeft)}, scrollDuration);
	});

	$(leftPaddle).on('click', function() {
		var scrollLeft = getMenuPosition();
		var scrollWidth = getMenuWrapperSize();
		$('.cal-menu').animate( { scrollLeft: (scrollLeft - scrollWidth) }, scrollDuration);
	});

});

/* https://codepen.io/mahish/pen/RajmQw | https://codepen.io/KenACollins/pen/ZErBQQo */