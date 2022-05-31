if (typeof JCJsEasyForm !== 'undefined' && {}.toString.call(JCJsEasyForm) === '[object Function]') {
} else {
    var JCJsEasyForm = function (arParams) {
        if (typeof arParams === 'object') {
            this.form = document.querySelector('#' + arParams.FORM_ID);
            this.isModalSuccess = false;
            this.modalForm = document.querySelector('#modal' + arParams.FORM_ID);
            this.isModalForm = false;
            this.params = arParams;
            JCJsEasyForm.prototype.init(this);
        }
    };
    JCJsEasyForm.prototype.init = function (_this) {
        if (!_this.form.length) {
            return false;
        }

        let required = _this.form.querySelectorAll("[required]");
        required.forEach(item => {
            item.addEventListener('focus', function (e) {
                item.classList.remove('error');
            });
        });
        if (_this.params.USE_CAPTCHA) {
            _this.captcha();
        }

        if (_this.params.SEND_AJAX) {
            if (_this.params.USE_FORMVALIDATION_JS === 'Y') {
                _this.form.bootstrapValidator().on('success.form.bv', function (e) {
                    e.preventDefault();
                    if (_this.params.USE_FORMVALIDATION_JS == 'Y') {
                        if (!_this.form.data('bootstrapValidator').isValid()) {
                            return false;
                        }
                    }
                    try {
                        var dataParams = _this.form.serializeArray();
                        var oldParams = _this.params['OLD_PARAMS'];
                        for (var i in oldParams) {
                            dataParams.push({name: 'arParams[' + i + ']', value: oldParams[i]});
                        }
                        _this.form.find('.submit-button').addClass('spinner');
                        $.ajax({
                            type: 'POST',
                            url: _this.params.TEMPLATE_FOLDER,
                            data: dataParams,
                            success: function (data) {
                                data = JSON.parse(data);
                                if (data.result === 'ok') {
                                    try {
                                        var funcName = _this.params._CALLBACKS;
                                        if (funcName) {
                                            eval(funcName)(data);
                                        } else {
                                            _this._showMessage(true, data.message);
                                        }
                                    } catch (e) {
                                        _this._showMessage(true, data.message);
                                    }

                                    setTimeout(function () {
                                        _this.form.find('.alert').addClass('hidden');
                                    }, 4000);

                                    _this._resetForm();
                                } else {
                                    _this._showMessage(false, data.message);
                                }
                                _this.form.find('.submit-button').removeClass('spinner');
                                _this.form.find('[disabled="disabled"]').removeAttr('disabled');

                            },
                            error: function () {
                                _this._showMessage(false);
                            }
                        });
                    } catch (e) {
                        console.log('error ajax');
                    }
                    return false;
                });
            } else {
                _this.form.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    if (_this.params.USE_FORMVALIDATION_JS === 'Y') {
                        if (!_this.form.data('bootstrapValidator').isValid()) {
                            return false;
                        }
                    } else {
                        let required = _this.form.querySelectorAll("[required]");
                        let isValid = true;
                        required.forEach(item => {
                            if (!item.value || item.classList.contains('phone-error')) {
                                item.classList.add('error');
                                isValid = false;
                            } else {item.classList.remove('error')}
                        });
                        if (!isValid) {
                            return isValid;
                        }
                    }
                    try {
                        let submitButton = _this.form.querySelector('button[type="submit"]');
                        submitButton.setAttribute('disabled', 'disabled');
                        let oldText = submitButton.innerHTML;

                        var dataParams = JCJsEasyForm.prototype.serializeArray(_this.form);
                        var oldParams = _this.params['OLD_PARAMS'];
                        for (var i in oldParams) {
                            dataParams.push({name: 'arParams[' + i + ']', value: oldParams[i]});
                        }
                        let sendData = new FormData();
                        dataParams.forEach(item => {
                            sendData.append(item.name, item.value);
                        });
                        const data = await JCJsEasyForm.prototype.ajax(_this.params.TEMPLATE_FOLDER, 'POST', sendData, {}, 'json');
                        if (data.result === 'ok') {
                            submitButton.innerHTML = "Сообщение отправлено";
                            _this._resetForm();
                            //_this.form.querySelector('[data-alert="success"]').style.display = "block";
                        } else {
                            //_this._showMessage(false, data.message);
                        }
                        setTimeout(() => {
                            submitButton.removeAttribute('disabled');
                            submitButton.innerHTML = oldText;
                            //_this.form.querySelector('[data-alert="success"]').style.display = "none";
                        }, 3000);
                    } catch (e) {
                        console.log('error ajax', e);
                    }
                    return false;
                });
            }
        } else {
            if (_this.params.USE_FORMVALIDATION_JS == 'Y') {
                _this.form.bootstrapValidator().on('success.form.bv', function (e) {
                    if (_this.params.USE_FORMVALIDATION_JS == 'Y') {
                        if (!_this.form.data('bootstrapValidator').isValid()) {
                            return false;
                        }
                    }
                });
            }
        }
    };

    JCJsEasyForm.prototype.captcha = function () {

        var _this = this;
        var captchaCallback = function (response) {

            if (_this.params.USE_FORMVALIDATION_JS == 'Y') {
                if (response !== undefined) {
                    $('input[name="captchaValidator"]').val(1);
                } else {
                    $('input[name="captchaValidator"]').val('');
                }

                _this.form.bootstrapValidator('updateStatus', "captchaValidator", 'NOT_VALIDATED').bootstrapValidator('validateField', "captchaValidator");
            }
        };
        try {

            setTimeout(function () {
                grecaptcha.render(_this.params.FORM_ID + '-captchaContainer', {
                    'sitekey': _this.params.CAPTCHA_KEY,
                    'callback': captchaCallback,
                    'expired-callback': captchaCallback
                });
            }, 500);

        } catch (e) {

        }

    };

    JCJsEasyForm.prototype._showMessage = function (status, message) {
        var alert,
            alertSuccess,
            alertDanger,
            serverMessage,
            modalTitle;
        alert = this.form.querySelector('.alert');
        if (status === undefined || alert === null) {
            return false;
        }
        console.log(alert);
        /*alertSuccess = alert.filter('.alert-success');
        alertDanger = alert.filter('.alert-danger');*/
        if (status === true) {
            alert.addClass('hidden');
            if (this.isModalSuccess) {
                if (this.isModalForm)
                    this.modalForm.modal('hide');

                if (message) {
                    this.modalSuccess.find('.ok-text').html(message);
                }

                if (!this.modalSuccess.hasClass('in'))
                    this.modalSuccess.addClass('in');
                this.modalSuccess.modal('show');
            } else {
                serverMessage = message || alertSuccess.data('message');
                alertSuccess.html(serverMessage);
                alertSuccess.removeClass('hidden');
            }
        } else if (status === false) {
            alert.addClass('hidden');
            serverMessage = message || alertDanger.data('message');

            alertDanger.html(serverMessage);
            alertDanger.removeClass('hidden');
        } else {
            alert.addClass('hidden');
        }

    };

    JCJsEasyForm.prototype._resetForm = function () {
        var _this = this;

        setTimeout(function () {
            if (_this.params.USE_FORMVALIDATION_JS == 'Y') {
                _this.form.dataset('bootstrapValidator').resetForm(true);
            }
            _this.form.reset();

            var switchSelects = _this.form.querySelector('.switch-select');
            if (switchSelects !== null && switchSelects !== undefined) {
                switchSelects.querySelector('select').trigger('refresh');
            }
            if (_this.params.USE_CAPTCHA) {
                try {
                    grecaptcha.reset();
                } catch (e) {
                    console.log('grecaptcha reset failed', e);
                }
            }
            var fileArea = _this.form.querySelector('.file-extended');
            if (fileArea !== null && fileArea !== undefined) {
                fileArea.querySelector('.file-placeholder-tbody').innerHTML = '';
                _this.form.querySelector('.file-selectdialog-switcher').setAttribute('style', '');
                fileArea.parent().querySelector('input[type="hidden"]').remove();
            }
        }, 1000);

    };

    JCJsEasyForm.prototype.switchSelect = function () {
        // switch select
        var switchSelects = this.form.querySelector('.switch-select');

        if (switchSelects !== null && switchSelects !== undefined) {
            if (switchSelects.length) {
                var _this = this;
                switchSelects.forEach(function () {
                    var self = this;
                    var parent = self.querySelector('.switch-parent');
                    var child = self.querySelector('.switch-child');
                    var btnBack = self.querySelector('.btn-switch-back');
                    var select = self.querySelector('select');
                    if (select.length && btnBack.length && child.length && parent.length) {
                        select.on('change', function () {
                            var optionSelected = select.querySelector('option:selected');
                            var dataSwitch = optionSelected.data('switch');
                            if (dataSwitch !== undefined) {
                                parent.addClass('hidden');
                                child.removeClass('hidden');
                            }
                        });
                        btnBack.on('click', function (e) {
                            e.preventDefault();
                            parent.removeClass('hidden');
                            child.addClass('hidden');
                            select.querySelector('option').eq(0).prop('selected', true);
                            setTimeout(function () {
                                select.trigger('refresh');
                            }, 1);
                        });

                        _this.form.on('reset', function () {
                            parent.removeClass('hidden');
                            child.addClass('hidden');
                            select.find('option').eq(0).prop('selected', true);
                            setTimeout(function () {
                                select.trigger('refresh');
                            }, 1);
                        });
                    }
                });
            }
        }
    };


    //ajax
    JCJsEasyForm.prototype.ajax = async function (url = '', method = 'GET', body = '', headers = {}, dataType = 'json'/* json|text|html */) {
        let params = {};
        if (url === '' || url === undefined) return false;
        if (method !== '' && method !== undefined) params['method'] = method;
        if (body !== '' && body !== undefined) params['body'] = body;
        if (headers !== {} && headers !== undefined) params['headers'] = headers;
        let response = await fetch(url, params);
        if (dataType === 'html') {
            let parser = new DOMParser();
            let doc = await parser.parseFromString(await response.text(), 'text/html');
            return await doc;
        }
        return response.json();
    }

//serialize
    JCJsEasyForm.prototype.serialize = function (form) {
        var serialized = [];
        for (var i = 0; i < form.elements.length; i++) {
            var field = form.elements[i];
            if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;
            if (field.type === 'select-multiple') {
                for (var n = 0; n < field.options.length; n++) {
                    if (!field.options[n].selected) continue;
                    serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[n].value));
                }
            } else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
                serialized.push(encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value));
            }
        }
        return serialized.join('&');
    };

//serializeArray
    JCJsEasyForm.prototype.serializeArray = function (form) {
        var arr = [];
        Array.prototype.slice.call(form.elements).forEach(function (field) {
            if (!field.name || field.disabled || ['file', 'reset', 'submit', 'button'].indexOf(field.type) > -1) return;
            if (field.type === 'select-multiple') {
                Array.prototype.slice.call(field.options).forEach(function (option) {
                    if (!option.selected) return;
                    arr.push({
                        name: field.name,
                        value: option.value
                    });
                });
                return;
            }
            if (['checkbox', 'radio'].indexOf(field.type) > -1 && !field.checked) return;
            arr.push({
                name: field.name,
                value: field.value
            });
        });
        return arr;
    };
}