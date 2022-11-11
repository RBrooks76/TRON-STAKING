$(document).ready(function () {

	// Toggle .headerSticky class to #header when page is scrolled
	$(window).scroll(function () {
		if ($(this).scrollTop() > 150) {
			$('.stickyHead').addClass('headerSticky');
		} else {
			$('.stickyHead').removeClass('headerSticky');
		}
	});

	//Home page Advantage slider 
	if ($('.njtAdvanList').length > 0) {
		$('.njtAdvanList').slick({
			infinite: false,
			slidesToShow: 3,
			slidesToScroll: 1,
			arrows: false,
			dots: true,
			vertical: true,
			verticalSwiping: true,
			responsive: [
				{
					breakpoint: 767,
					settings: {
						vertical: false,
						verticalSwiping: false,
						slidesToShow: 1,
						slidesToScroll: 1,
					}
				}
			]
		});
	}


	//Home page Advantage slider 
	if ($('.homepSliderLR').length > 0) {
		$('.homepSliderLR').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: '.homepSliderTB'
		});
		$('.homepSliderTB').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			asNavFor: '.homepSliderLR',
			fade: true,
			arrows: false,
		});
	}

	$('.tablescrl').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		asNavFor: '.tablescrl',
		fade: true,
		arrows: false,
	});

	$('.popover__wrapper__').click(function () {

		let hid = $(this).attr('data-id');

		let show_head = $('#head_' + hid).text();

		let l_content = $('#l_content_' + hid).val();

		$('#exampleModalLabel').html(show_head);

		let show_content = $('#content_' + hid).text();

		$('#show_modl_content').html(l_content);

		$('#modal1').modal('show');
	})

	/*$('#modal1').mouseleave(function() { 
 
		//console.log('tttttttttttt');
 
		$('#modal1').modal('hide');

	});*/

	/* For Mobile navigation */

	$(document).on('click', '#show_profile .profileTrig .btn,#sideMenu .sideMenu .sideMenuClose .btn', function (e) {
		let classN = e.target.classList.value.split(' ');
		let joinANDback = classN.every((child, index) => {
			if (child == 'hplanAniImgTrig-join' || child == 'hplanAniImgTrig-back') return false;
			else return true;
		})
		if (joinANDback) $('.sideMenu').toggleClass('active');
	})

	/*$(".profileTrig .btn,.sideMenuClose .btn").on('click',function() {	  
	  $('.sideMenu').toggleClass('active');	  
	});*/


	/* For Single window scroll */
	$(".scrollDownContent a").on('click', function (event) {

		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 800, function () {
				//window.location.hash = hash;
			});
		}

	});

	/* For Home Animation plan */
	$('.hplanAniImgTrig-back').on('click', function () {
		if ($(window).width() > 767) {
			$('html, body').animate({ scrollTop: $('.homePlansAnimation').offset().top }, 100)
			$('.homePaniCol').toggleClass('show');
			$('.homePaniRow').toggleClass('homePaniColn2', 300);
			$('.planAniBack').toggle(100);
		}
	});
	$('.hplanAniImgTrig-join').on('click', () => {
		if (window.innerWidth >= 768) {
			let user_wallet = '', defaultWallet = '';
			let user_gmail = localStorage.getItem('user_gmail');
			if (window.tronWeb && 0 != window.tronWeb.defaultAddress.base58) defaultWallet = window.tronWeb.defaultAddress.base58;
			if (localStorage.getItem('userWallet_address')) user_wallet = localStorage.getItem('userWallet_address');
			if (user_gmail) user_gmail = user_gmail.trim();
			var nameMatch = user_gmail ? user_gmail.split('@gmail.com') : [];

			if (user_gmail && nameMatch.length == 2 && nameMatch[0].length > 0 && window.tronWeb && 0 != window.tronWeb.defaultAddress.base58 && user_wallet != '' && user_wallet == defaultWallet) {
				$('html, body').animate({ scrollTop: $('.homePlansAnimation').offset().top }, 100)
				$('.homePaniCol').toggleClass('show');
				$('.homePaniRow').toggleClass('homePaniColn2', 300);
				$('.planAniBack').toggle(100);
			} else $('#Reg_Modal').modal('show');
		}
	})

	$('#reg-btn').on('click', () => {
		let mail = $('#user-mail-info').val();
		if (mail) mail = mail.trim();
		var nameMatch = mail ? mail.split('@gmail.com') : [];
		if (nameMatch.length == 2 && nameMatch[0].length > 0) {
			localStorage.setItem('user_gmail', mail);
			if (window.tronWeb && 0 != window.tronWeb.defaultAddress.base58) {
				localStorage.setItem('userWallet_address', window.tronWeb.defaultAddress.base58);
			}
			$('html, body').animate({ scrollTop: $('.homePlansAnimation').offset().top }, 100)
			$('.homePaniCol').toggleClass('show');
			$('.homePaniRow').toggleClass('homePaniColn2', 300);
			$('.planAniBack').toggle(100);
			$('#Reg_Modal').modal('hide');
		} else {
			toastr.warning('The gmail format is wrong.');
		}
	})


	if ($('[data-aos]').length > 0) {
		$(window).on('load', function () {
			AOS.init();
		});
	}

	$(document).on('click', '.up_referral_link', function () {
		let value = $(this).attr('data-url')
		var tempInput = document.createElement("input");
		tempInput.style = "position: absolute; left: -1000px; top: -1000px";
		tempInput.value = value;
		document.body.appendChild(tempInput);
		tempInput.select();
		document.execCommand("copy");
		document.body.removeChild(tempInput);

		$.growl.notice({ message: (getvalidationmsg("Copied the URL: ") + value) });
	})
	// $('#video-modal-news').modal('show')

});