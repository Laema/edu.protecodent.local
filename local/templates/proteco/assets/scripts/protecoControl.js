class protecoControl {
    constructor() {
        this.actionChangeSelector = document.querySelectorAll('[data-action*="change"]');
        this.actionClickSelector = document.querySelectorAll('[data-action*="click"]');
        this.actionSubmitSelector = document.querySelectorAll('[data-action*="submit"]');
        this.pageUrl = location.protocol + '//' + location.host + location.pathname;
        this.init();
    }
    init () {
        this.event();
        this.build().calendar();

        let _this = this;
    }
    event() {
        let _this = this;
        this.actionClickSelector.forEach(item => {
            item.addEventListener('click', event => {
                _this.eventList(item, item.dataset.action, event);
            })
        })
        this.actionSubmitSelector.forEach(item => {
            item.addEventListener('submit', event => {
                _this.eventList(item, item.dataset.action, event);
            })
        })
        this.actionChangeSelector.forEach(item => {
            item.addEventListener('change', event => {
                _this.eventList(item, item.dataset.action, event);
            })
        })
    }
    build() {
        let _this = this;
        return {
            calendar() {
                try {
                    let sendData;
                    if (calendarWrap) {
                        sendData = ra.objToUrl(JSON.parse(calendarWrap.dataset.dfilter));
                    } else if (calendarPageWrap) {
                        sendData = ra.objToUrl(JSON.parse(calendarPageWrap.dataset.dfilter));
                    }
                    if (sendData) {
                        const contentType = { "Content-type": "application/x-www-form-urlencoded; charset=UTF-8" };
                        ra.ajax('/ajax/?act=Catalog.getCatalogForCalendar','POST',sendData,contentType,'json').then((response) => {
                            if (response.isSuccess) {
                                markDate = response.result
                                initCalendar();
                                initCalendarPage();
                            }
                        });
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        }
    }
    actions() {
        let _this = this;
        return {
            clickSignUpEvent(item) {
				try {
					if (item.dataset.eventId) {
                        // console.log(item.dataset.checkUrl);
						let postData = new FormData();
						postData.append("ID", item.dataset.eventId);
						postData.append("TYPE", "event");
                        postData.append('PAYMENT_CHECK', item.dataset.checkUrl);

						item.setAttribute("disabled", true);
						ra.ajax("/ajax/?act=Order.addEventInOrder", "POST", postData, {}, "json").then((response) => {
							if (response.isSuccess && response.result.ORDER_ID !== 0) {
								window.location = response.result.EVENT_URL + "?ORDER_ID=" + response.result.ORDER_ID;
							}
						});
					}
				} catch (e) {
					console.log(e);
				}
			},
			clickSignUpCourse(item) {
				try {
					if (item.dataset.eventsId) {
						let postData = new FormData();
						postData.append("ID", item.dataset.eventsId);
						postData.append("COUSE_ID", item.dataset.courseId);
						postData.append("TYPE", "course");
						ra.ajax("/ajax/?act=Order.addCourseInOrder", "POST", postData, {}, "json").then((response) => {
							if (response.isSuccess) {
								for (const button of document.querySelectorAll('[data-action="clickSignUpCourse"]')) button.innerText = "Вы записаны";
							}
						});
					}
				} catch (e) {
					console.log(e);
				}
			},
			clickShowPopup(item) {
				const popupBlock = document.querySelector(`[data-active-block="${item.dataset.popupName}"]`);
                document.getElementById('register-form-event-id').value = item.dataset.eventId;
				if (popupBlock) {
					popupBlock.classList.add("active");
				}
			},
            clickShowPaymentCheckPopup(item) {
				const popupBlock = document.querySelector(`[data-active-block="paymentCheck"]`);
				if (popupBlock) {
					popupBlock.classList.add("active");
				}
			},
			clickUnsubscribe(item) {
				try {
					if (item.dataset.subId) {
						let postData = new FormData();
						postData.append("ID", item.dataset.subId);
						ra.ajax("/ajax/?act=User.mailingUnsubscribe", "POST", postData, {}, "json").then((response) => {
							if (response.isSuccess) {
								window.location.reload();
							}
						});
					}
				} catch (e) {
					console.log(e);
				}
			},
			submitToInviteColleg(item, event) {
				try {
					event.preventDefault();
					let postData = new FormData(item);
					let formBtn = item.querySelector('button[type="submit"]');
					formBtn.setAttribute("disabled", true);
					ra.ajax("/ajax/?act=User.sendInvite", "POST", postData, {}, "json").then((response) => {
						if (response.isSuccess) {
							this.clickShowPopup(item);
							formBtn.removeAttribute("disabled");
							item.closest(".popups__wrap").classList.remove("active");
							item.querySelector('input[name="EMAIL"]').value = "";
						}
					});
				} catch (e) {
					console.log(e);
				}
			},
		};
    }
    eventList(i, e, event = false) {
        let _this = this;
        switch (e) {
            case "clickSignUpEvent":
                _this.actions().clickSignUpEvent(i);
                break;
            case "clickShowPopup":
                _this.actions().clickShowPopup(i);
                break;
            case "clickSignUpCourse":
                _this.actions().clickSignUpCourse(i);
                break;
            case "clickUnsubscribe":
                _this.actions().clickUnsubscribe(i);
                break;
            case "submitToInviteColleg":
                _this.actions().submitToInviteColleg(i, event);
                break;
            case "clickShowPaymentCheckPopup":
                _this.actions().clickShowPaymentCheckPopup(i, event);
                break;
        }
    }
}

try {
    window.controller = new protecoControl();
} catch (e) {
    console.log(e);
}
