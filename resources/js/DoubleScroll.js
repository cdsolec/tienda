function DoubleScroll(element) {
	/*
	We start with this:
	<element>
		<firstElementChild>
		.
		</firstElementChild>
	</element>


	We end up with this:
	<element>
		<scroll1>
			<scroll1Inner></scroll1>
		</scroll1>
		<scroll2>
			<firstElementChild>
			.
			</firstElementChild>
		</scroll2>
	</element
	*/

	let scroll1 = document.createElement('div');
	scroll1.classList.add('doublescroll1');
	scroll1.style.overflowX = 'auto';
	scroll1.style.overflowY = 'hidden';
	scroll1.style.marginTop = '-1px';

	let scroll1Inner = document.createElement('div');
	scroll1Inner.classList.add('doublescroll-inner');
	scroll1Inner.style.paddingTop = '1px';
	scroll1Inner.style.width = element.firstElementChild.scrollWidth+'px';

	scroll1.appendChild(scroll1Inner);

	let scroll2 = document.createElement('div');
	scroll2.classList.add('doublescroll2');
	scroll2.style.overflowX = 'auto';

	// Move the element's first node inside the scroll2 div
	scroll2.appendChild(element.firstElementChild);
	
	element.appendChild(scroll1);
	element.appendChild(scroll2);

	let isRunning = false;

	scroll1.onscroll = function() {
		if (isRunning) {
			isRunning = false;
			return;
		}

		isRunning = true;
		scroll2.scrollLeft = scroll1.scrollLeft;
	};

	scroll2.onscroll = function() {
		if (isRunning) {
			isRunning = false;
			return;
		}
		
		isRunning = true;
		scroll1.scrollLeft = scroll2.scrollLeft;
	};
}
