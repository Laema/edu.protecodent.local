const activeClass = "active";

// data-active
const dataActiveControl = document.querySelectorAll("[data-active-control]");
if (dataActiveControl) {
	for (const activeControl of dataActiveControl) {
		const activeBlock = document.querySelector(`[data-active-block="${activeControl.dataset.activeControl}"]`);
		const activeControlList = document.querySelectorAll(`[data-active-control="${activeControl.dataset.activeControl}"]`);

		activeControl.addEventListener("click", () => {
			for (const activeControlItem of activeControlList) {
				activeControlItem.classList.toggle(activeClass);
			}
			if (activeBlock) {
				activeBlock.classList.toggle(activeClass);
			}
		});
	}
}

// collapse-control
const collapseControlAll = document.querySelectorAll("[data-collapse-control]");
if (collapseControlAll) {
	for (const collapseControl of collapseControlAll) {
		const collapseBlock = document.querySelector(`[data-collapse-block="${collapseControl.dataset.collapseControl}"]`);
		const collapseName = collapseControl.dataset.collapseName;

		function collapse(collapseControl, collapseBlock) {
			if (collapseControl.dataset.collapse === "true") {
				collapseBlock.style.height = collapseBlock.scrollHeight + "px";
				collapseBlock.classList.add(activeClass);
				collapseControl.classList.add(activeClass);
				collapseControl.dataset.collapse = "false";
			} else if (collapseControl.dataset.collapse === "false") {
				collapseBlock.style.height = 0;
				collapseBlock.classList.remove(activeClass);
				collapseControl.classList.remove(activeClass);
				collapseControl.dataset.collapse = "true";
			}
		}

		if (collapseName) {
			collapseControl.insertAdjacentText("afterbegin", collapseBlock.querySelector(collapseName).innerHTML);
		}

		collapse(collapseControl, collapseBlock);

		collapseControl.addEventListener("click", () => {
			collapse(collapseControl, collapseBlock);
		});
	}
}

const lkNavButtonList = document.querySelectorAll(".collapse-on-768");
if (lkNavButtonList && document.documentElement.clientWidth <= 768) {
	for (const lkNavButton of lkNavButtonList) {
		lkNavButton.click();
	}
}

// Слайдер
// https://swiperjs.com/api
if (document.querySelectorAll(".main-slider .swiper-slide").length > 1) {
	let mainSlider = new Swiper(".main-slider", {
		speed: 500,
		loop: true,
	});
}

let navSlider = new Swiper(".slider_nav", {
	speed: 300,
	pagination: {
		el: ".slider_nav__el",
		type: "fraction",
	},
	spaceBetween: 30,
	// loop: true,
	navigation: {
		nextEl: ".reviews-slider__next",
		prevEl: ".reviews-slider__prev",
	},
});

let reviewsSlider = new Swiper(".reviews-slider", {
	speed: 400,
	loop: true,
	pagination: {
		el: ".reviews-slider__pagination",
		clickable: true,
	},
	navigation: {
		nextEl: ".reviews-slider__next",
		prevEl: ".reviews-slider__prev",
	},
	breakpoints: {
		1024: {
			slidesPerView: 3,
			spaceBetween: 22,
		},
		768: {
			slidesPerView: 2,
		},
		280: {
			slidesPerView: 1.1,
			spaceBetween: 15,
		},
	},
});

let eventSlider = new Swiper(".event-page-slider", {
	speed: 400,
	loop: true,
	pagination: {
		el: ".reviews-slider__pagination",
		clickable: true,
	},
	navigation: {
		nextEl: ".reviews-slider__next",
		prevEl: ".reviews-slider__prev",
	},
	breakpoints: {
		1024: {
			slidesPerView: 3,
			spaceBetween: 22,
		},
		768: {
			slidesPerView: 2,
		},
		280: {
			slidesPerView: 1.1,
			spaceBetween: 15,
		},
	},
});

let articlePageSlider = new Swiper(".article-page__slider", {
	speed: 300,
	loop: true,
	slidesPerView: 1,
	spaceBetween: 30,
	pagination: {
		el: ".article-page__slider-pagination ",
		type: "fraction",
	},
	navigation: {
		nextEl: ".reviews-slider__next",
		prevEl: ".reviews-slider__prev",
	},
});

// https://flatpickr.js.org/
(function (global, factory) {
	typeof exports === "object" && typeof module !== "undefined"
		? factory(exports)
		: typeof define === "function" && define.amd
		? define(["exports"], factory)
		: ((global = typeof globalThis !== "undefined" ? globalThis : global || self), factory((global.ru = {})));
})(this, function (exports) {
	"use strict";

	var fp =
		typeof window !== "undefined" && window.flatpickr !== undefined
			? window.flatpickr
			: {
					l10ns: {},
			  };
	var Russian = {
		weekdays: {
			shorthand: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
			longhand: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
		},
		months: {
			shorthand: ["Янв", "Фев", "Март", "Апр", "Май", "Июнь", "Июль", "Авг", "Сен", "Окт", "Ноя", "Дек"],
			longhand: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
		},
		firstDayOfWeek: 1,
		ordinal: function () {
			return "";
		},
		rangeSeparator: " — ",
		weekAbbreviation: "Нед.",
		scrollTitle: "Прокрутите для увеличения",
		toggleTitle: "Нажмите для переключения",
		amPM: ["ДП", "ПП"],
		yearAriaLabel: "Год",
		time_24hr: true,
	};
	fp.l10ns.ru = Russian;
	var ru = fp.l10ns;

	exports.Russian = Russian;
	exports.default = ru;

	Object.defineProperty(exports, "__esModule", { value: true });
});

const buttonHtml = `
		<div class="datepicker-main__button-wrap">
			<button class="button" data-button-close >Выбрать</button>
			<button class="button button_ghost" data-button-clear >Сбросить</button>
		</div>
	`;

const datepickerCont = document.querySelector(".datepicker-main");

let calendar;
const calendarWrap = document.querySelector("#date-range");

let calendarPage;
const calendarPageWrap = document.querySelector("#date-range-page");

let markDate = {};

const markDateHtml = function (itemList) {
	const markDateIitem = function (itemList) {
		let allHtml = "";
		for (const item of itemList) {
			allHtml += `
				<div class="mark-date__item">
					<div class="mark-date__time">${item.time}</div>
					<div class="mark-date__tupe">${item.tupe}</div>
					<div class="mark-date__name">${item.name}</div>
				</div>
			`;
		}
		return allHtml;
	};

	return `
		<div class="mark-date">
			${markDateIitem(itemList)}
		</div>
		<div class="mark-date-point"></div>
	`;
};

let calendarConf = {
	mode: "range",
	locale: "ru",
	dateFormat: "d.m.Y",
	altFormat: "d.m.Y",
	onDayCreate: function (dObj, dStr, fp, dayElem) {
		const itemDate = flatpickr.formatDate(dayElem.dateObj, "d.m.Y");
		let dateNow = new Date(),
			dateEvent = new Date(flatpickr.formatDate(dayElem.dateObj, "m/d/Y"));
			dateNow.setDate(dateNow.getDate() - 1)

			if (markDate[itemDate] && dateEvent >= dateNow) {
			dayElem.insertAdjacentHTML("beforeend", markDateHtml(markDate[itemDate]));
		}
	},
};

function initCalendar() {
	if (calendarWrap) {
		if (document.body.clientWidth >= 768) {
			calendarConf.static = false;
			calendarConf.inline = false;
			calendarConf.appendTo = datepickerCont;
		}
		if (document.body.clientWidth < 768) {
			calendarConf.static = true;
			calendarConf.inline = true;
			calendarConf.appendTo = false;
		}
		// const clientWidth = document.body.clientWidth < 768;
		// calendarConf.static = clientWidth;
		// calendarConf.inline = clientWidth;
		// calendarConf.appendTo = clientWidth ? false : datepickerCont;

		calendar = flatpickr(calendarWrap, calendarConf);
	}
}

function initCalendarPage() {
	if (calendarPageWrap) {
		if (document.body.clientWidth >= 768) {
			calendarConf.static = false;
			calendarConf.inline = false;
		}
		if (document.body.clientWidth < 768) {
			calendarConf.static = true;
			calendarConf.inline = true;
		}

		const event = new Event("change");
		function emulationEvent(event, item) {
			item.setAttribute("data-filter-commit", "true");
			item.dispatchEvent(event);
		}

		calendarPage = flatpickr(calendarPageWrap, calendarConf);
		calendarPage.config.onChange.push(function () {
			calendarPage.open();
			calendarPageWrap.setAttribute("data-filter-commit", "false");
		});

		const flatpickritem = document.querySelector(".flatpickr-calendar");
		flatpickritem.insertAdjacentHTML("beforeend", buttonHtml);

		flatpickritem.querySelector("[data-button-close]").addEventListener("click", () => {
			calendarPage.close();
			emulationEvent(event, calendarPageWrap);
		});
		flatpickritem.querySelector("[data-button-clear]").addEventListener("click", () => {
			calendarPage.clear();
			emulationEvent(event, calendarPageWrap);
		});
		document.querySelector('[data-active-control="filter1"]').addEventListener("click", () => {
			emulationEvent(event, calendarPageWrap);
		});
	}
}

window.onresize = function () {
	initCalendar();
	initCalendarPage();
};

initCalendar();
initCalendarPage();

// audio-player
const playerProgressList = document.querySelectorAll(".audio-player__progres");

function secInPers(now, end, element) {
	element.style.setProperty("--progres", (now * 100) / end + "%");
}

if (playerProgressList) {
	for (const playerProgress of playerProgressList) {
		const inputRange = playerProgress.querySelector('input[type="range"]');
		const mimicProgress = playerProgress.querySelector(".audio-player__progres-mimic");

		inputRange.addEventListener("input", () => {
			secInPers(inputRange.value, inputRange.max, mimicProgress);
		});
	}
}

const audioPlayerList = document.querySelectorAll(".audio-player");
function secondsToHms(d) {
	d = Number(d);
	const h = Math.floor(d / 3600),
		m = Math.floor((d % 3600) / 60),
		s = Math.floor((d % 3600) % 60),
		hDisplay = h > 0 ? h + ":" : "",
		mDisplay = m > 0 ? (m <= 9 ? (h > 0 ? "0" : "") : "") + m + ":" : "0:",
		sDisplay = s <= 9 ? "0" + s : s;
	return hDisplay + mDisplay + sDisplay;
}

if (audioPlayerList) {
	for (const audioPlayer of audioPlayerList) {
		const audio = audioPlayer.querySelector("audio"),
			progres = audioPlayer.querySelector(".audio-player__progres > input"),
			progresMimic = audioPlayer.querySelector(".audio-player__progres-mimic"),
			playPause = audioPlayer.querySelector(".audio-player__play-pause"),
			rewindBack = audioPlayer.querySelector(".audio-player__rewind_back"),
			rewindForward = audioPlayer.querySelector(".audio-player__rewind_forward"),
			volumebutton = audioPlayer.querySelector(".audio-player__volume-button"),
			volumeProgresInput = audioPlayer.querySelector(".audio-player__volume-progres .audio-player__progres > input"),
			volumeProgresMimic = audioPlayer.querySelector(".audio-player__volume-progres .audio-player__progres > .audio-player__progres-mimic"),
			timeNow = audioPlayer.querySelector(".audio-player__time-now"),
			timeEnd = audioPlayer.querySelector(".audio-player__time-end");

		let nowSeconds, maxSeconds;

		function setTimeNow() {
			nowSeconds = Math.floor(audio.currentTime);
			timeNow.innerHTML = secondsToHms(nowSeconds);
		}

		// Полная загрузка
		audio.addEventListener("durationchange", () => {
			// progres
			maxSeconds = Math.floor(audio.duration);
			progres.max = maxSeconds;
			timeEnd.innerHTML = secondsToHms(maxSeconds);
			setTimeNow();

			// progres
			progres.addEventListener("input", () => {
				audio.currentTime = progres.value;
				setTimeNow();
			});

			// control
			playPause.addEventListener("click", () => {
				if (audio.paused) {
					audio.play();
					playPause.classList.add(activeClass);
				} else {
					audio.pause();
					playPause.classList.remove(activeClass);
				}
			});
			rewindBack.addEventListener("click", () => {
				audio.currentTime -= 30;
			});
			rewindForward.addEventListener("click", () => {
				audio.currentTime += 30;
			});

			// volume
			let volumeNow = audio.volume;
			volumeProgresMimic.style.setProperty("--progres", volumeNow * 100 + "%");
			function muteIcon() {
				let iconOpacity = 1;
				if (audio.volume == 0) iconOpacity = 0;
				volumebutton.style.setProperty("--mute", Number(!iconOpacity));
				volumebutton.style.setProperty("--volume", iconOpacity);
			}

			volumebutton.addEventListener("click", () => {
				let mute = volumeNow;
				if (audio.volume > 0) mute = 0;
				audio.volume = mute;
				volumeProgresMimic.style.setProperty("--progres", mute * 100 + "%");
				muteIcon();
			});

			volumeProgresInput.addEventListener("input", () => {
				volumeNow = volumeProgresInput.value;
				audio.volume = volumeProgresInput.value;
				volumebutton.style.setProperty("--volume1", audio.volume);
				volumebutton.style.setProperty("--volume05", audio.volume + 0.33);
				// volumebutton.style.setProperty("--volume1", audio.volume / 0.5 - 1);
				// volumebutton.style.setProperty("--volume05", audio.volume / 0.5);
				muteIcon();
			});
		});
		// Воспроизведение
		audio.addEventListener("playing", () => {
			const tickInterval = 1000;
			// progres
			let addTimeNow = setTimeout(function tick() {
				setTimeNow();
				secInPers(nowSeconds, maxSeconds, progresMimic);
				if (!audio.paused) {
					addTimeNow = setTimeout(tick, tickInterval);
				}
			}, tickInterval);
		});
	}
}

// https://github.com/michu2k/Accordion
// accordion
const accordionFaq = ".faq";
if (document.querySelector(accordionFaq)) {
	new Accordion(accordionFaq);
}

// https://imask.js.org
// Маска для телефона
document.querySelectorAll(".input[type='tel']:not(.registration-phone)").forEach((item) => {
	let telMask = IMask(item, {
		mask: "+{7}(000)000-00-00",
	});
});

// input file
function uploadFile(target) {
	const item = target.parentNode.querySelector("span");
	item.innerHTML = target.files[0].name;
	item.classList.add(activeClass);
}

// course-pages
const coursePagesList = document.querySelectorAll(".course-pages__list");
if (coursePagesList) {
	for (const courseList of coursePagesList) {
		const courseInfo = courseList.querySelectorAll(".course-info");
		const courseLinc = courseList.querySelectorAll(".course-linc");
		let courseInfoMaxHeight = 0;

		// Минимальная высота списка
		window.onload = function () {
			for (const courseInfoItem of courseInfo) {
				const courseInfoHeight = courseInfoItem.scrollHeight;
				if (courseInfoMaxHeight < courseInfoHeight) courseInfoMaxHeight = courseInfoHeight;

				courseInfoItem.parentNode.style.gridRowEnd = "-" + (courseInfo.length + 1);
			}
			courseList.style.minHeight = courseInfoMaxHeight + "px";
		};
	}
}

// data-tab-wrap
const tabWrap = document.querySelectorAll("[data-tab-wrap]");
if (tabWrap) {
	for (const tabWrapItem of tabWrap) {
		const tabControl = tabWrapItem.querySelectorAll("[data-tab-control]");
		const tabBlock = tabWrapItem.querySelectorAll("[data-tab-block]");

		function tabActive(itme = tabControl[0]) {
			const itemBlock = tabWrapItem.querySelector(`[data-tab-block=${itme.dataset.tabControl}]`);
			let itemBlockHeight = itemBlock.querySelector("[data-tab-height]");
			if (itemBlockHeight === null) {
				itemBlockHeight = tabWrapItem.querySelector(`[data-tab-block=${itme.dataset.tabControl}] [data-tab-height]`);
			}
			const itemBlockHeightList = tabWrapItem.querySelectorAll("[data-tab-height");

			for (const tabControlItem of tabControl) tabControlItem.classList.remove(activeClass);
			for (const tabBlockItem of tabBlock) tabBlockItem.classList.remove(activeClass);
			for (const itemBlockHeightItem of itemBlockHeightList) itemBlockHeightItem.style.height = "0";

			itme.classList.add(activeClass);
			itemBlock.classList.add(activeClass);
			if (itemBlockHeight) itemBlockHeight.style.height = itemBlock.scrollHeight + "px";
		}

		for (const tabControlItem of tabControl) {
			tabControlItem.addEventListener("click", () => {
				tabActive(tabControlItem);
			});
		}

		tabActive();
	}
}

// https://sachinchoolur.github.io/lightgallery.js/docs/
// https://github.com/sachinchoolur/lightgallery.js
const listGallery = document.querySelectorAll("[data-list-gallery]");
for (const listGalleryItem of listGallery) {
	lightGallery(listGalleryItem, {
		download: false,
		// getCaptionFromTitleOrAlt: true,
		selector: "[data-img-gallery]",
	});
}

const mapEventPage = document.querySelector("#event-page-map");
if (mapEventPage) {
	ymaps.ready(init);

	function init() {
		const eventPageMapX = mapEventPage.dataset.mapX;
		const eventPageMapY = mapEventPage.dataset.mapY;

		var myMap = new ymaps.Map("event-page-map", {
			center: [eventPageMapX, eventPageMapY],
			zoom: 10,
			controls: ["zoomControl"],
		});
		myMap.geoObjects.add(
			new ymaps.Placemark(
				[eventPageMapX, eventPageMapY],
				// {
				// 	balloonContent: "<strong>серобуромалиновый</strong> цвет",
				// },
				{
					preset: "islands#dotIcon",
					iconColor: "#0fa9da",
				}
			)
		);
	}
}

function noResultsFilter(selector, noResultsMessage = "К сожалению, в указанные вами даты мероприятий нет. <br>Попробуйте изменить диапазон поиска") {
	const listResultsWrap = document.querySelector(`${selector}`),
		listResults = listResultsWrap.querySelectorAll('.event-card[data-entity="item"]'),
		noResultsHtml = listResultsWrap.querySelector(".events__list-no-result");

	if (noResultsHtml) noResultsHtml.remove();
	if (listResults.length == 0) {
		listResultsWrap.insertAdjacentHTML("beforeend", `<div class="events__list-no-result">${noResultsMessage}</div>`);
	}
}

// Мероприятия видео
document.querySelectorAll("[data-video-play]").forEach((play) => {
	const frame = document.querySelector(`[data-video-frame="${play.dataset.videoPlay}"]`);

	play.addEventListener("click", () => {
		play.style.display = "none";
		frame.src = frame.dataset.videoUrl;
	});
});
