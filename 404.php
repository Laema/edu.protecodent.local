<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");?>
    <section class="container-wrap error-page__wrap">
        <div class="container-item error-page">
            <h1 class="error-page__h">Похоже такой страницы не существует</h1>
            <div class="error-page__item">
                <div class="error-page__number">4</div>
                <img class="error-page__img" src="<?=SITE_TEMPLATE_PATH?>/assets/images/404.png">
                <div class="error-page__number">4</div>
            </div><a class="button error-page__button" href="/">На главную</a>
        </div>
    </section>
    <section class="container-wrap event-error__wrap">
        <div class="container-item event-error">
            <h2 class="event-error__h">Наши мероприятия</h2>
            <ul class="event-page__list">
                <li class="event-card">
                    <div class="event-card__head event-card__head_master-class">
                        <svg class="event-card__head-icon" width="45" height="45">
                            <use xlink:href="./assets/images/sprite.svg#icon-master-class"></use>
                        </svg><span class="event-card__head-text">Мастер-класс</span>
                        <div class="event-card__head-label"> <span>Доступно в курсе</span></div>
                    </div>
                    <div class="event-card__body">
                        <div class="event-card__time-wrap">
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-date"></use>
                                </svg><span>01 января 2021</span>
                            </div>
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-time"></use>
                                </svg><span>с 17:00 до 19:30</span>
                            </div>
                        </div>
                        <h4 class="event-card__heading">Круглый стол с врачом консультантом Е.Мендоса «Работа над ошибками в прямой композитной реставрации. Нюансы использования Estelite»</h4>
                        <div class="event-card__person"><img class="event-card__person-img" width="80" height="115" src="./assets/images/img1.jpg" alt="Летягина Юлия Александровна">
                            <div class="event-card__person-text-wrap">
                                <div class="event-card__person-name">Летягина Юлия Александровна (Санкт-Петербург)</div>
                                <div class="event-card__person-text">Ведущий врач-стоматолог-терапевт, главный врач стоматологической клиники «Феникс». Особая специализация: пациенты, имеющие парафункции жевательных мышц и заболевания ВНЧС</div>
                            </div>
                        </div>
                        <div class="event-card__program">
                            <div class="event-card__program-head">Программа курса</div>
                            <ol class="event-card__program-list">
                                <li class="event-card__program-item">Основные понятия и определения парафункций жевательных мышц. Определение бруксизма</li>
                                <li class="event-card__program-item">Диагностика бруксизма</li>
                                <li class="event-card__program-item">Клинические проявления. От абфракций до неинфекционного периодонтита (травматическая окклюзия)</li>
                                <li class="event-card__program-item">Общие принципы лечения бруксизма</li>
                            </ol>
                        </div>
                    </div>
                    <div class="event-card__bot">
                        <div class="event-card__bot-pey">Регистрационный взнос: 3 000 ₽</div><a class="button" href="#">Записаться</a>
                    </div>
                </li>
                <li class="event-card">
                    <div class="event-card__head event-card__head_lecture">
                        <svg class="event-card__head-icon" width="45" height="45">
                            <use xlink:href="./assets/images/sprite.svg#icon-lecture"></use>
                        </svg><span class="event-card__head-text">Лекция</span>
                    </div>
                    <div class="event-card__body">
                        <div class="event-card__time-wrap">
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-date"></use>
                                </svg><span>01 января 2021</span>
                            </div>
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-time"></use>
                                </svg><span>с 17:00 до 19:30</span>
                            </div>
                        </div>
                        <h4 class="event-card__heading">Круглый стол с врачом консультантом Е.Мендоса «Работа над ошибками в прямой композитной реставрации. Нюансы использования Estelite»</h4>
                        <div class="event-card__person"><img class="event-card__person-img" width="80" height="115" src="./assets/images/img1.jpg" alt="Летягина Юлия Александровна">
                            <div class="event-card__person-text-wrap">
                                <div class="event-card__person-name">Летягина Юлия Александровна (Санкт-Петербург)</div>
                                <div class="event-card__person-text">Ведущий врач-стоматолог-терапевт, главный врач стоматологической клиники «Феникс». Особая специализация: пациенты, имеющие парафункции жевательных мышц и заболевания ВНЧС</div>
                            </div>
                        </div>
                        <div class="event-card__program">
                            <div class="event-card__program-head">Программа курса</div>
                            <ol class="event-card__program-list">
                                <li class="event-card__program-item">Основные понятия и определения парафункций жевательных мышц. Определение бруксизма</li>
                                <li class="event-card__program-item">Диагностика бруксизма</li>
                                <li class="event-card__program-item">Клинические проявления. От абфракций до неинфекционного периодонтита (травматическая окклюзия)</li>
                                <li class="event-card__program-item">Общие принципы лечения бруксизма</li>
                            </ol>
                        </div>
                    </div>
                    <div class="event-card__bot">
                        <div class="event-card__bot-pey">Регистрационный взнос: 3 000 ₽</div><a class="button" href="#">Записаться</a>
                    </div>
                </li>
                <li class="event-card">
                    <div class="event-card__head event-card__head_seminar">
                        <svg class="event-card__head-icon" width="45" height="45">
                            <use xlink:href="./assets/images/sprite.svg#icon-seminar"></use>
                        </svg><span class="event-card__head-text">Выставка</span>
                    </div>
                    <div class="event-card__body">
                        <div class="event-card__time-wrap">
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-date"></use>
                                </svg><span>01 января 2021</span>
                            </div>
                            <div class="event-card__time">
                                <svg width="17" height="17">
                                    <use xlink:href="./assets/images/sprite.svg#icon-time"></use>
                                </svg><span>с 17:00 до 19:30</span>
                            </div>
                        </div>
                        <h4 class="event-card__heading">Круглый стол с врачом консультантом Е.Мендоса «Работа над ошибками в прямой композитной реставрации. Нюансы использования Estelite»</h4>
                        <div class="event-card__person"><img class="event-card__person-img" width="80" height="115" src="./assets/images/img1.jpg" alt="Летягина Юлия Александровна">
                            <div class="event-card__person-text-wrap">
                                <div class="event-card__person-name">Летягина Юлия Александровна (Санкт-Петербург)</div>
                                <div class="event-card__person-text">Ведущий врач-стоматолог-терапевт, главный врач стоматологической клиники «Феникс». Особая специализация: пациенты, имеющие парафункции жевательных мышц и заболевания ВНЧС</div>
                            </div>
                        </div>
                        <div class="event-card__program">
                            <div class="event-card__program-head">Программа курса</div>
                            <ol class="event-card__program-list">
                                <li class="event-card__program-item">Основные понятия и определения парафункций жевательных мышц. Определение бруксизма</li>
                                <li class="event-card__program-item">Диагностика бруксизма</li>
                                <li class="event-card__program-item">Клинические проявления. От абфракций до неинфекционного периодонтита (травматическая окклюзия)</li>
                                <li class="event-card__program-item">Общие принципы лечения бруксизма</li>
                            </ol>
                        </div>
                    </div>
                    <div class="event-card__bot">
                        <div class="event-card__bot-pey">Регистрационный взнос: 3 000 ₽</div><a class="button" href="#">Записаться</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>