<!--begin::Header Menu Wrapper-->
<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
    <!--begin::Header Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
        <!--begin::Header Nav-->
        <ul class="menu-nav">
            @if (auth()->user()->type == 'ADMIN')
                <li class="menu-item" data-menu-toggle="click" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-text">Главная</span>
                    </a>
                </li>
                <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-text">Пользователи</span>
                        <span class="menu-desc"></span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                        <ul class="menu-subnav">
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('users.index', ['type' => 'USER']) }}" class="menu-link">
                                    <span class="menu-text">Соискатели</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('users.index', ['type' => 'COMPANY']) }}" class="menu-link">
                                    <span class="menu-text">Работодатели</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('users.index', ['type' => 'ADMIN']) }}" class="menu-link">
                                    <span class="menu-text">Администраторы</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="menu-text">Справочники</span>
                        <span class="menu-desc"></span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                        <ul class="menu-subnav">
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('vacancy_types.index') }}" class="menu-link">
                                    <span class="menu-text">Типы вакансий</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('busynesses.index') }}" class="menu-link">
                                    <span class="menu-text">Виды занятости</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('schedules.index') }}" class="menu-link">
                                    <span class="menu-text">Графики работы</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('countries.index') }}" class="menu-link">
                                    <span class="menu-text">Страны</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('regions.index') }}" class="menu-link">
                                    <span class="menu-text">Регионы</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('job_types.index') }}" class="menu-link">
                                    <span class="menu-text">Сферы работ</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('education_types.index') }}" class="menu-link">
                                    <span class="menu-text">Виды образования</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('skillsets.index') }}" class="menu-link">
                                    <span class="menu-text">Навыки</span>
                                </a>
                            </li>
                            <li class="menu-item" aria-haspopup="true">
                                <a href="{{ route('currencies.index') }}" class="menu-link">
                                    <span class="menu-text">Валюты</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="menu-item">
                <a href="{{ route('vacancies.index') }}" class="menu-link">
                    <span class="menu-text">Вакансии</span>
                </a>
            </li>
            @if (auth()->user()->type == 'COMPANY')
                <li class="menu-item">
                    <a href="{{ route('user_cv.index') }}" class="menu-link">
                        <span class="menu-text">Отклики</span>&nbsp;
                        @if ($user_vacancy_feedbacks)
                            <span class="label label-warning label-inline font-weight-bold">{{$user_vacancy_feedbacks}}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.chat') }}" class="menu-link">
                        <span class="menu-text">Чат</span>&nbsp;
                        @if ($unread_messages)
                            <span
                                class="label label-danger label-inline font-weight-bold">{{ $unread_messages }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.account') }}" class="menu-link">
                        <span class="menu-text">Личный кабинет</span>
                    </a>
                </li>
            @endif
            <li class="menu-item">
                <a href="{{ route('admin.profile') }}" class="menu-link">
                    <span class="menu-text">Профиль</span>
                </a>
            </li>
        </ul>
        <!--end::Header Nav-->
    </div>
    <!--end::Header Menu-->
</div>
<!--end::Header Menu Wrapper-->
