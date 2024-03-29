jQuery(document).ready(function($) {
	"user strict";

	// Preloader
	$(window).on("load", function () {
		$(".preloader").fadeOut(1000);
	});

	// Menu Click Event
	let trigger = $(".header-trigger");
	let dropdown = $(".menu");
	if (trigger || dropdown) {
		trigger.each(function () {
			$(this).on("click", function (e) {
				e.stopPropagation();
				dropdown.slideToggle();
				trigger.toggleClass("active");
			});
		});
		dropdown.each(function () {
			$(this).on("click", function (e) {
				e.stopPropagation();
			});
		});
		$(document).on("click", function () {
			if (parseInt(screenSize) < parseInt(991)) {
				dropdown.slideUp();
				trigger.removeClass("active");
			}
		});
	}

	$(".menu-close").on("click", function () {
		$(".menu").slideUp();
	});

	//Menu Dropdown
	$("ul>li>.sub-menu").parent("li").addClass("has-sub-menu");

	let screenSize = window.innerWidth;
	window.addEventListener("resize", function (e) {
		screenSize = window.innerWidth;
	});

	$(".menu li a").on("click", function (e) {
		if (parseInt(screenSize) < parseInt(991)) {
			$(this).siblings(".sub-menu").slideToggle();
		}
	});

	// Sticky Menu
	var header = document.querySelector(".header");
	if (header) {
		window.addEventListener("scroll", function () {
			header.classList.toggle("sticky", window.scrollY > 0);
		});
	}

	// Scroll To Top
	var scrollTop = $(".scrollToTop");
	$(window).on("scroll", function () {
		if ($(this).scrollTop() < 500) {
			scrollTop.removeClass("active");
		} else {
			scrollTop.addClass("active");
		}
	});

	//Click event to scroll to top
	$(".scrollToTop").on("click", function () {
		$("html, body").animate({
				scrollTop: 0,
			},
			300
		);
		return false;
	});

	$(".single-slide").parent("div").addClass("single-slide-wrapper");

	//Faq
	$(".faq-item__title").on("click", function (e) {
		var element = $(this).parent(".faq-item");
		if (element.hasClass("open")) {
			element.removeClass("open");
			element.find(".faq-item__content").removeClass("open");
			element.find(".faq-item__content").slideUp(300, "swing");
		} else {
			element.addClass("open");
			element.children(".faq-item__content").slideDown(300, "swing");
			element.siblings(".faq-item").children(".faq-item__content").slideUp(300, "swing");
			element.siblings(".faq-item").removeClass("open");
			element.siblings(".faq-item").find(".faq-item__content").slideUp(300, "swing");
		}
	});

	var path = location.pathname.split("/");
	var current = location.pathname.split("/")[path.length - 1];
	$(".menu li a").each(function () {
		if ($(this).attr("href").indexOf(current) !== -1 && current != "") {
			// $(this).addClass("active");
		}
	});

	var count = $(".item-wrapper").children().length;
	if (count >= 7) {
		$(".item-wrapper .single-item:nth-child(5)").addClass("item-five");
		$(".item-wrapper .single-item:nth-child(6)").addClass("item-six");
	}

	Array.from(document.querySelectorAll('table')).forEach(table => {
		let heading = table.querySelectorAll('thead tr th');
		Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
			Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
				if (colum.hasAttribute('colspan') && i == 0) {
					return false;
				}
				colum.setAttribute('data-label', heading[i].innerText)
			});
		});
	});
});