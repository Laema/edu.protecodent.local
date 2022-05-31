<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
global $USER;
?>
    </main>
    <footer class="container-wrap footer__wrap" <?$APPLICATION->ShowViewContent('hide_footer')?>>
        <div class="container-item footer">
            <div class="footer__body">
                <a class="footer__logo" href="/">
                    <svg width="205" height="40">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#main-logo"></use>
                    </svg>
                </a>
                <?$APPLICATION->IncludeComponent("bitrix:menu",
                    "footer",
                    Array(
                    "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                        "DELAY" => "N",	// Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",	// Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                        "ROOT_MENU_TYPE" => "bottom",	// Тип меню для первого уровня
                        "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                    ),
                    false
                );?>
                <div class="footer__contact">
                    <div class="footer__contact-tell">
						<a href="tel:+78127793090">+7 (812) 779-30-90</a>
                        <!--a href="tel:+78126358890">+7 (812) 635-88-90</a-->
                    </div>
                    <div class="footer__contact-adre">196128, Санкт-Петербург,
                        <br>ул. Варшавская, д.5, корп. 2, офис 401, <br>БЦ "Варшавский"
                    </div>
                </div>
                <?if (!empty($GLOBALS['OPTIONS']['UF_SOCIAL']['VALUE'])):?>
                    <ul class="footer__social">
                        <?foreach ($GLOBALS['OPTIONS']['UF_SOCIAL']['VALUE'] as $key => $soc):?>
                            <li class="footer__social-item">
                                <a class="footer__social-linc" href="<?=$soc?>">
                                    <svg width="25" height="25">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#<?=$GLOBALS['OPTIONS']['UF_SOCIAL']['DESCRIPTION'][$key]?>"></use>
                                    </svg>
                                </a>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
            </div>
            <div class="footer__bot">
                <span class="footer__bot-linc"><?=date('Y')?> © PROTECO</span>
                <a class="footer__bot-linc" href="<?=$GLOBALS['OPTIONS']['UF_AGREEMENT_URL']['VALUE']?>">Публичная оферта</a>
                <span class="footer__bot-linc">Сайт сделал: <a class="footer__bot-linc-ra" href="https://ra-studio.ru/">RA-Studio</a>
                </span>
            </div>
        </div>
    </footer>
    <?$APPLICATION->IncludeComponent(
	"slam:easyform",
	"sendPopup",
	array(
		"CATEGORY_EMAIL_IBLOCK_FIELD" => "FORM_EMAIL",
		"CATEGORY_EMAIL_PLACEHOLDER" => "E-mail*",
		"CATEGORY_EMAIL_TITLE" => "Ваш E-mail",
		"CATEGORY_EMAIL_TYPE" => "email",
		"CATEGORY_EMAIL_VALIDATION_ADDITIONALLY_MESSAGE" => "data-bv-emailaddress-message=\"E-mail введен некорректно\"",
		"CATEGORY_EMAIL_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_EMAIL_VALUE" => "",
		"CATEGORY_MESSAGE_IBLOCK_FIELD" => "PREVIEW_TEXT",
		"CATEGORY_MESSAGE_PLACEHOLDER" => "Комментарий",
		"CATEGORY_MESSAGE_TITLE" => "Сообщение",
		"CATEGORY_MESSAGE_TYPE" => "textarea",
		"CATEGORY_MESSAGE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_MESSAGE_VALUE" => "",
		"CATEGORY_PHONE_IBLOCK_FIELD" => "FORM_PHONE",
		"CATEGORY_PHONE_INPUTMASK" => "N",
		"CATEGORY_PHONE_INPUTMASK_TEMP" => "+7 (999) 999-9999",
		"CATEGORY_PHONE_PLACEHOLDER" => "Телефон*",
		"CATEGORY_PHONE_TITLE" => "Мобильный телефон",
		"CATEGORY_PHONE_TYPE" => "tel",
		"CATEGORY_PHONE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_PHONE_VALUE" => "",
		"CATEGORY_TITLE_IBLOCK_FIELD" => "NAME",
		"CATEGORY_TITLE_PLACEHOLDER" => "Ваше имя*",
		"CATEGORY_TITLE_TITLE" => "Ваше имя",
		"CATEGORY_TITLE_TYPE" => "text",
		"CATEGORY_TITLE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_TITLE_VALUE" => "",
		"CREATE_IBLOCK" => "",
		"CREATE_SEND_MAIL" => "",
		"DISPLAY_FIELDS" => array(
			0 => "TITLE",
			1 => "EMAIL",
			2 => "PHONE",
			3 => "MESSAGE",
			4 => "COMPANY_NAME",
			5 => "COMPANY_TYPE",
			6 => "",
		),
		"EMAIL_BCC" => "",
		"EMAIL_FILE" => "Y",
		"EMAIL_SEND_FROM" => "N",
		"EMAIL_TO" => "",
		"ENABLE_SEND_MAIL" => "Y",
		"ERROR_TEXT" => "Произошла ошибка. Сообщение не отправлено.",
		"EVENT_MESSAGE_ID" => array(
			0 => "87",
		),
		"FIELDS_ORDER" => "TITLE,COMPANY_NAME,EMAIL,PHONE,COMPANY_TYPE,MESSAGE",
		"FORM_AUTOCOMPLETE" => "Y",
		"FORM_ID" => "FORM7",
		"FORM_NAME" => "Заказать обучение в своей клинике",
		"FORM_SUBTITLE" => "Заполните и отправьте нам свою заявку и мы свяжемся с вами в ближайшее время",
		"FORM_TYPE" => "orderTraining",
		"FORM_SUBMIT_VALUE" => "Отправить",
		"FORM_SUBMIT_VARNING" => "Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a target=\"_blank\" href=\"#\">Пользовательским соглашением</a>",
		"HIDE_ASTERISK" => "N",
		"HIDE_FIELD_NAME" => "N",
		"HIDE_FORMVALIDATION_TEXT" => "N",
		"IBLOCK_ID" => "17",
		"IBLOCK_TYPE" => "formresult",
		"INCLUDE_BOOTSRAP_JS" => "Y",
		"MAIL_SUBJECT_ADMIN" => "#SITE_NAME#: Сообщение из формы обратной связи",
		"OK_TEXT" => "Ваше сообщение отправлено. Мы свяжемся с вами в течение 2х часов",
		"REQUIRED_FIELDS" => array(
			0 => "TITLE",
			1 => "EMAIL",
			2 => "PHONE",
			3 => "COMPANY_NAME",
			4 => "COMPANY_TYPE",
		),
		"SEND_AJAX" => "Y",
		"SHOW_MODAL" => "N",
		"TITLE_SHOW_MODAL" => "Спасибо!",
		"USE_BOOTSRAP_CSS" => "N",
		"USE_BOOTSRAP_JS" => "N",
		"USE_CAPTCHA" => "N",
		"USE_FORMVALIDATION_JS" => "N",
		"USE_IBLOCK_WRITE" => "Y",
		"USE_JQUERY" => "N",
		"USE_MODULE_VARNING" => "Y",
		"WIDTH_FORM" => "500px",
		"_CALLBACKS" => "",
		"COMPONENT_TEMPLATE" => "sendPopup",
		"CATEGORY_TITLE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_PHONE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_DOCS_TITLE" => "Загрузить файл*",
		"CATEGORY_DOCS_TYPE" => "file",
		"CATEGORY_DOCS_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_DOCS_FILE_EXTENSION" => "doc, docx, xls, xlsx, txt, rtf, pdf, png, jpeg, jpg, gif",
		"CATEGORY_DOCS_FILE_MAX_SIZE" => "100000000",
		"CATEGORY_DOCS_DROPZONE_INCLUDE" => "N",
		"CATEGORY_COMPANY_NAME_TITLE" => "Название организации",
		"CATEGORY_COMPANY_NAME_TYPE" => "text",
		"CATEGORY_COMPANY_NAME_PLACEHOLDER" => "Название организации*",
		"CATEGORY_COMPANY_NAME_VALUE" => "",
		"CATEGORY_COMPANY_NAME_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_COMPANY_NAME_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_COMPANY_TYPE_TITLE" => "Тип организации*",
		"CATEGORY_COMPANY_TYPE_TYPE" => "select",
		"CATEGORY_COMPANY_TYPE_VALUE" => array(
		),
		"CATEGORY_COMPANY_TYPE_ADD_VAL" => "Другое (напишите свой вариант)",
		"CATEGORY_COMPANY_TYPE_MULTISELECT" => "N",
		"CATEGORY_COMPANY_TYPE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_COMPANY_TYPE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"ACTIVE_ELEMENT" => "N",
		"CATEGORY_COMPANY_NAME_IBLOCK_FIELD" => "FORM_COMPANY_NAME",
		"CATEGORY_COMPANY_TYPE_IBLOCK_FIELD" => "FORM_COMPANY_TYPE"
	),
	false
);?>
    <?$APPLICATION->IncludeComponent(
	"slam:easyform",
	"sendPopup",
	array(
		"CATEGORY_EMAIL_IBLOCK_FIELD" => "FORM_EMAIL",
		"CATEGORY_EMAIL_PLACEHOLDER" => "E-mail*",
		"CATEGORY_EMAIL_TITLE" => "Ваш E-mail",
		"CATEGORY_EMAIL_TYPE" => "email",
		"CATEGORY_EMAIL_VALIDATION_ADDITIONALLY_MESSAGE" => "data-bv-emailaddress-message=\"E-mail введен некорректно\"",
		"CATEGORY_EMAIL_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_EMAIL_VALUE" => "",
		"CATEGORY_MESSAGE_IBLOCK_FIELD" => "PREVIEW_TEXT",
		"CATEGORY_MESSAGE_PLACEHOLDER" => "Комментарий",
		"CATEGORY_MESSAGE_TITLE" => "Сообщение",
		"CATEGORY_MESSAGE_TYPE" => "textarea",
		"CATEGORY_MESSAGE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_MESSAGE_VALUE" => "",
		"CATEGORY_PHONE_IBLOCK_FIELD" => "FORM_PHONE",
		"CATEGORY_PHONE_INPUTMASK" => "N",
		"CATEGORY_PHONE_INPUTMASK_TEMP" => "+7 (999) 999-9999",
		"CATEGORY_PHONE_PLACEHOLDER" => "Телефон*",
		"CATEGORY_PHONE_TITLE" => "Мобильный телефон",
		"CATEGORY_PHONE_TYPE" => "tel",
		"CATEGORY_PHONE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_PHONE_VALUE" => "",
		"CATEGORY_TITLE_IBLOCK_FIELD" => "NAME",
		"CATEGORY_TITLE_PLACEHOLDER" => "Ваше имя*",
		"CATEGORY_TITLE_TITLE" => "Ваше имя",
		"CATEGORY_TITLE_TYPE" => "text",
		"CATEGORY_TITLE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_TITLE_VALUE" => "",
		"CREATE_IBLOCK" => "",
		"CREATE_SEND_MAIL" => "",
		"DISPLAY_FIELDS" => array(
			0 => "TITLE",
			1 => "EMAIL",
			2 => "PHONE",
			3 => "MESSAGE",
			4 => "DOCS",
			5 => "COMPANY_NAME",
			6 => "COMPANY_TYPE",
			7 => "",
		),
		"EMAIL_BCC" => "",
		"EMAIL_FILE" => "Y",
		"EMAIL_SEND_FROM" => "N",
		"EMAIL_TO" => "",
		"ENABLE_SEND_MAIL" => "Y",
		"ERROR_TEXT" => "Произошла ошибка. Сообщение не отправлено.",
		"EVENT_MESSAGE_ID" => array(
			0 => "87",
		),
		"FIELDS_ORDER" => "TITLE,COMPANY_NAME,EMAIL,PHONE,COMPANY_TYPE,DOCS,MESSAGE",
		"FORM_AUTOCOMPLETE" => "Y",
		"FORM_ID" => "FORM10",
		"FORM_NAME" => "Прислать свой кейс",
		"FORM_SUBTITLE" => "Отправьте нам свой кейс и мы разместим его у нас на сайте.",
		"FORM_TYPE" => "sendCase",
		"FORM_SUBMIT_VALUE" => "Отправить",
		"FORM_SUBMIT_VARNING" => "Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a target=\"_blank\" href=\"#\">Пользовательским соглашением</a>",
		"HIDE_ASTERISK" => "N",
		"HIDE_FIELD_NAME" => "N",
		"HIDE_FORMVALIDATION_TEXT" => "N",
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "formresult",
		"INCLUDE_BOOTSRAP_JS" => "Y",
		"MAIL_SUBJECT_ADMIN" => "#SITE_NAME#: Сообщение из формы обратной связи",
		"OK_TEXT" => "Ваше сообщение отправлено. Мы свяжемся с вами в течение 2х часов",
		"REQUIRED_FIELDS" => array(
			0 => "TITLE",
			1 => "EMAIL",
			2 => "PHONE",
			3 => "DOCS",
			4 => "COMPANY_NAME",
			5 => "COMPANY_TYPE",
		),
		"SEND_AJAX" => "Y",
		"SHOW_MODAL" => "N",
		"TITLE_SHOW_MODAL" => "Спасибо!",
		"USE_BOOTSRAP_CSS" => "N",
		"USE_BOOTSRAP_JS" => "N",
		"USE_CAPTCHA" => "N",
		"USE_FORMVALIDATION_JS" => "N",
		"USE_IBLOCK_WRITE" => "Y",
		"USE_JQUERY" => "N",
		"USE_MODULE_VARNING" => "Y",
		"WIDTH_FORM" => "500px",
		"_CALLBACKS" => "",
		"COMPONENT_TEMPLATE" => "sendPopup",
		"CATEGORY_TITLE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_PHONE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_DOCS_TITLE" => "Загрузить файл*",
		"CATEGORY_DOCS_TYPE" => "file",
		"CATEGORY_DOCS_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_DOCS_FILE_EXTENSION" => "doc, docx, xls, xlsx, txt, rtf, pdf, png, jpeg, jpg, gif",
		"CATEGORY_DOCS_FILE_MAX_SIZE" => "100000000",
		"CATEGORY_DOCS_DROPZONE_INCLUDE" => "N",
		"CATEGORY_COMPANY_NAME_TITLE" => "Название организации",
		"CATEGORY_COMPANY_NAME_TYPE" => "text",
		"CATEGORY_COMPANY_NAME_PLACEHOLDER" => "Название организации*",
		"CATEGORY_COMPANY_NAME_VALUE" => "",
		"CATEGORY_COMPANY_NAME_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_COMPANY_NAME_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"CATEGORY_COMPANY_TYPE_TITLE" => "Тип организации*",
		"CATEGORY_COMPANY_TYPE_TYPE" => "select",
		"CATEGORY_COMPANY_TYPE_VALUE" => array(
		),
		"CATEGORY_COMPANY_TYPE_ADD_VAL" => "Другое (напишите свой вариант)",
		"CATEGORY_COMPANY_TYPE_MULTISELECT" => "N",
		"CATEGORY_COMPANY_TYPE_VALIDATION_MESSAGE" => "Обязательное поле",
		"CATEGORY_COMPANY_TYPE_VALIDATION_ADDITIONALLY_MESSAGE" => "",
		"ACTIVE_ELEMENT" => "N",
		"CATEGORY_DOCS_IBLOCK_FIELD" => "FORM_DOCS",
		"CATEGORY_COMPANY_NAME_IBLOCK_FIELD" => "FORM_COMPANY_NAME",
		"CATEGORY_COMPANY_TYPE_IBLOCK_FIELD" => "FORM_COMPANY_TYPE"
	),
	false
);?>
    <div class="popups__wrap" data-active-block="popup2"><!-- popup для страницы tokuyama-dental.html чтобы активировать добавь к ".popups__wrap" класс ".active" -->
        <div class="popups popups_ok">
            <button class="popups__close" data-active-control="popup2">
                <svg width="15" height="15">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-cancel-button"></use>
                </svg>
            </button>
            <h3 class="popups__h">Заявка успешно отправлена!</h3>
            <p class="popups__text">Мы свяжемся с Вами в ближайшее время.</p>
        </div>
        <div class="popups__close-area" data-active-control="popup2"></div>
    </div>
	<!-- Registration -->
	<div class="popups__wrap" data-active-block="paymentCheck">
	        <div class="popups">
	            <button class="popups__close" data-active-control="paymentCheck">
	                <svg width="15" height="15">
	                    <use xlink:href="/local/templates/proteco/assets/images/sprite.svg#icon-cancel-button"></use>
	                </svg>
	            </button>
	                <h3 class="popups__h">Прикрепите изображение чека</h3>
					<!-- <label class="input input_file mb-45" id="download">
	                    <input type="file" required onchange="doDownloadRegistered(this);">
	                    <div class="input_file__icon">
	                        <svg width="20" height="20">
	                            <use xlink:href="/local/templates/proteco/assets/images/sprite.svg#icon-file"></use>
	                        </svg>
	                    </div>
                        <span>Прикрепить чек*</span>
                    </label> -->
					<label id="download">
                        <input type="file" required onChange="doDownloadRegistered(this);"/>
                    </label>
					<button id="send-check-button" class="button popups__button" data-action="clickSignUpEvent" data-check-url="" data-event-id="" name="paymentCheck_submit_button">Отправить</button>
	        </div>
	    <div class="popups__close-area" data-active-control="paymentCheck"></div>
	</div>
	<?$APPLICATION->IncludeComponent("bitrix:main.register", "popup", Array(
		"AUTH" => "Y",	// Автоматически авторизовать пользователей
		"REQUIRED_FIELDS" => "",	// Поля, обязательные для заполнения
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_FIELDS" => array(	// Поля, которые показывать в форме
			0 => "EMAIL",
			1 => "TITLE",
			2 => "NAME",
			3 => "LAST_NAME",
			4 => "PERSONAL_PHONE",
			5 => "PERSONAL_CITY",
			6 => "WORK_PROFILE",
			7 => "WORK_COMPANY",
			8 => 'UF_REFERRER',
			9 => 'PERSONAL_COUNTRY'
		),
		"SUCCESS_PAGE" => "",	// Страница окончания регистрации
		"USER_PROPERTY" => array(
			0 => 'UF_REFERRER'
		),	// Показывать доп. свойства
		"USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
		"USE_BACKURL" => "Y",	// Отправлять пользователя по обратной ссылке, если она есть
	),
		false
	);?>
	<!-- // Registration -->
    <div class="popups__wrap" data-active-block="collegInvite">
        <div class="popups popups_ok">
            <button class="popups__close" data-active-control="collegInvite">
                <svg width="15" height="15">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-cancel-button"></use>
                </svg>
            </button>
            <h3 class="popups__h text-left">Пригласить коллегу</h3>
            <p class="popups__text text-left">После приглашения коллеги вы получите <?=declOfNum($GLOBALS['COLLEAG_POINTS'], ['балл', 'балла', 'баллов'])?> Протеко. Узнать колличество накопленных баллов вы можете в личном кабинете.</p>
            <form class="popups__input-wrap popups_inv-form" data-action="submitToInviteColleg" data-popup-name="sendSuccess">
                <input type="hidden" name="EVENT_URL" value="<?=explode('?', $_SERVER['REQUEST_URI'])[0]?>">
                <input class="input" type="email" name="EMAIL" placeholder="E-mail*" required>
                <p class="popups__user-agreement">Нажимая на кнопку, я подтверждаю, что согласен на обработку моих персональных данных, а также с <a href="#">Пользовательским соглашением</a></p>
                <button class="button popups__button" type="submit">Отправить</button>
            </form>
        </div>
        <div class="popups__close-area" data-active-control="collegInvite"></div>
    </div>
    <div class="popups__wrap" data-active-block="sendSuccess">
        <div class="popups popups_ok">
            <button class="popups__close" data-active-control="sendSuccess">
                <svg width="15" height="15">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/sprite.svg#icon-cancel-button"></use>
                </svg>
            </button>
            <h3 class="popups__h">Ваше приглашение успешно отправлено</h3>
        </div>
        <div class="popups__close-area" data-active-control="sendSuccess"></div>
    </div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(65495881, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/65495881" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	</body>
</html>
