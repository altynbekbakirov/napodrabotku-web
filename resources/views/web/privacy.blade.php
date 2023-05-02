<!doctype html>
<html lang="en">

<head>
    <title>@if(app()->getlocale() == 'ky') ishtapp - Иш издөө мобилдик колдонмосу @else ishtapp - Мобильное приложение для поиска работы @endif</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ishtapp - Иш издөө мобилдик колдонмосу">
    <meta name="keywords" content="ishtapp">

    <!-- Font -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <!-- Main css -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-ML9977P');</script>
    <!-- End Google Tag Manager -->

</head>

<body data-spy="scroll" data-target="#navbar" data-offset="30">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ML9977P"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<!-- Nav Menu -->

@if(app()->getlocale() == 'ru')

    <!-- Nav Menu -->
    <div class="nav-menu bg-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-dark navbar-expand-lg">
                        <a class="navbar-brand" href="{{route('web.index')}}">
                            <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"> <a class="nav-link active" href="{{route('web.index')}}#home">ГЛАВНАЯ <span class="sr-only">(current)</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" href="{{route('web.index')}}#features">ДОСТОИНСТВА</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="{{route('web.index')}}#gallery">ИНТЕРФЕЙС</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="{{route('web.index')}}#contact">ЗАГРУЗКА</a> </li>
                                <li class="nav-item"><a href="{{ LaravelLocalization::getLocalizedURL('ky', null, [], true) }}" class="btn btn-outline-light my-3 my-sm-0 ml-lg-1">KG</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@else

    <div class="nav-menu bg-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-dark navbar-expand-lg">
                        <a class="navbar-brand" href="{{route('web.index')}}">
                            <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"> <a class="nav-link active" href="#home">БАШКЫ <span class="sr-only">(current)</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#features">ПАЙДАСЫ</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#gallery">КЕЛБЕТИ</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#contact">ЖҮКТӨӨ</a> </li>
                                <li class="nav-item"><a href="{{ LaravelLocalization::getLocalizedURL('ru', null, [], true) }}" class="btn btn-outline-light my-3 my-sm-0">RU</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endif

    <div class="section">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Политика в области обработки и обеспечения безопасности персональных данных</h2>

                    <p class="lead mt-5">1. Общие положения</p>
                    <p class="mb-4">
                        ishtapp (далее — «Компания») в рамках выполнения своей основной деятельности осуществляет обработку персональных данных различных категорий субъектов персональных данных с использованием информационных систем персональных данных, включающих в том числе следующий интернет-сайт Компании: https://ishtapp.kg, а также иные сайты Компании, которые ссылаются на данную Политику.
                    </p>
                    <p>
                        В соответствии с действующим законодательством Кыргызской Республики Компания является оператором персональных данных.
                    </p>
                    <p>
                        Для целей настоящей Политики под персональными данными понимаются любая информация, предоставленная через интернет-сайты Компании и (или) собранная с использованием таких интернет-сайтов, относящаяся к прямо или косвенно определенному, или определяемому физическому лицу (субъекту персональных данных).
                    </p>

                    <p class="lead mt-5">2. Сбор персональных данных</p>
                    <p>
                        Компания осуществляет сбор информации через интернет-сайты и мобильные приложения следующими способами:
                    </p>

                    <ul>
                        <li>
                            <p class="mb-1">Персональные данные, предоставляемые пользователями:</p>
                            <p>
                                Компания осуществляет сбор персональных данных, которые вводят в поля данных на интернет-сайтах Компании сами пользователи или иные лица по их поручению.
                            </p>
                        </li>
                        <li>
                            <p>Сбор данных о местонахождении устройств пользователей мобильного приложения Компании при использовании пользователями мобильного приложения.</p>
                        </li>
                        <li>
                            <p>Сбор IP адресов пользователей и файлов cookies.</p>
                        </li>
                        <li>
                            <p>Пассивный сбор персональных данных о текущем подключении в части статистических сведений:</p>
                            <ul class="list-unstyled">
                                <li>
                                    <p>— идентификатор пользователя, присваиваемый Сайтом;</p>
                                </li>
                                <li>
                                    <p>— посещенные страницы;</p>
                                </li>
                                <li>
                                    <p>— количество посещений страниц;</p>
                                </li>
                                <li>
                                    <p>— информация о перемещении по страницам сайта;</p>
                                </li>
                                <li>
                                    <p>— длительность пользовательской сессии;</p>
                                </li>
                                <li>
                                    <p>— точки входа (сторонние сайты, с которых пользователь по ссылке переходит на Сайт);</p>
                                </li>
                                <li>
                                    <p>— точки выхода (ссылки на Сайте, по которым пользователь переходит на сторонние сайты);</p>
                                </li>
                                <li>
                                    <p>— страна пользователя;</p>
                                </li>
                                <li>
                                    <p>— регион пользователя;</p>
                                </li>
                                <li>
                                    <p>— часовой пояс, установленный на устройстве пользователя;</p>
                                </li>
                                <li>
                                    <p>— провайдер пользователя;</p>
                                </li>
                                <li>
                                    <p>— браузер пользователя;</p>
                                </li>
                                <li>
                                    <p>— цифровой отпечаток браузера (canvas fingerprint);</p>
                                </li>
                                <li>
                                    <p>— доступные шрифты браузера;</p>
                                </li>
                                <li>
                                    <p>— установленные плагины браузера;</p>
                                </li>
                                <li>
                                    <p>— параметры WebGL браузера;</p>
                                </li>
                                <li>
                                    <p>— тип доступных медиа-устройств в браузере;</p>
                                </li>
                                <li>
                                    <p>— наличие ActiveX;</p>
                                </li>
                                <li>
                                    <p>— перечень поддерживаемых языков на устройстве пользователя;</p>
                                </li>
                                <li>
                                    <p>— архитектура процессора устройства пользователя;</p>
                                </li>
                                <li>
                                    <p>— ОС пользователя;</p>
                                </li>
                                <li>
                                    <p>— параметры экрана (разрешение, глубина цветности, параметры размещения страницы на экране);</p>
                                </li>
                                <li>
                                    <p>— информация об использовании средств автоматизации при доступе на Сайт.</p>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <p>
                        В отношении зарегистрированных пользователей Сайта могут собираться сведения об использовании портов на устройствах пользователей с целью выявления подозрительной активности и защиты личных кабинетов пользователей. Данные могут быть получены с помощью различных методов, например, файлов cookies и файловых веб-маяков и др.
                    </p>

                    <p>
                        Компания может использовать сторонние интернет-сервисы (технологии третьих лиц) для организации сбора статистических персональных данных, сторонние интернет-сервисы обеспечивают хранение полученных данных на собственных серверах. Компания не несет ответственности за локализацию серверов сторонних интернет-сервисов. При этом такие сторонние интернет-сервисы (технологии третьих лиц), установленные на Сайте и используемые Компанией, могут устанавливать и считывать cookie-файлы браузеров конечных пользователей Сайта, или использовать сетевые маячки (web beacons) для сбора информации в процессе рекламной деятельности на Сайте. Порядок сбора и использования данных, собираемыми такими сторонними интернет-сервисами (технологиями третьих лиц), определяется самостоятельно этими сторонними интернет-сервисами и непосредственно они несут ответственность за соблюдение этого порядка и использование собираемых ими данных, в том числе эти сторонние интернет-сервисы отвечают и обеспечивают выполнение требований применимого законодательства, в том числе законодательства о персональных данных КР.
                    </p>
                    <p>
                        Компания не проводит сопоставление информации, предоставляемой пользователем самостоятельно и позволяющей идентифицировать субъекта персональных данных, со статистическими персональными данными, полученными в ходе применения подобных пассивных методов сбора информации.
                    </p>

                    <p class="lead mt-5">3. Принципы и условия обработки персональных данных</p>
                    <p>
                        Обработка персональных данных в Компании осуществляется на законной и справедливой основе и ограничивается достижением конкретных, заранее определенных и законных целей, в том числе, в соответствии с Условиями использования Сайтов, Условиями оказания услуг, Соглашением об оказании услуг по содействию в трудоустройстве.
                    </p>
                    <p>
                        Обработке подлежат только персональные данные, которые отвечают целям их обработки. Содержание и объем обрабатываемых в Компании персональных данных соответствуют заявленным целям обработки, избыточность обрабатываемых персональных данных не допускается.
                    </p>
                    <p>
                        При обработке персональных данных в Компании обеспечивается точность персональных данных, их достаточность и, в необходимых случаях, актуальность по отношению к целям обработки персональных данных. Компания принимает необходимые меры (обеспечивает их принятие) по удалению или уточнению неполных, или неточных персональных данных.
                    </p>
                    <p>
                        Компания в ходе своей деятельности может предоставлять и (или) поручать обработку персональных данных другому лицу с согласия субъекта персональных данных, если иное не предусмотрено законодательством КР о персональных данных. При этом обязательным условием предоставления и (или) поручения обработки персональных данных другому лицу является обязанность сторон по соблюдению конфиденциальности и обеспечению безопасности персональных данных при их обработке.
                    </p>
                    <p>
                        Сроки обработки персональных данных определяются в соответствии с целями, для которых они были собраны.
                    </p>

                    <p class="lead mt-5">4. Права субъекта персональных данных</p>
                    <p>
                        Субъект персональных данных имеет право (если иное не предусмотрено законом):
                    </p>
                    <ul>
                        <li>
                            <p>требовать уточнения своих персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, недостоверными, незаконно полученными или не являются необходимыми для заявленной цели обработки, а также принимать предусмотренные законом меры по защите своих прав;</p>
                        </li>
                        <li>
                            <p>требовать перечень своих персональных данных, обрабатываемых Компанией, и источник их получения;</p>
                        </li>
                        <li>
                            <p>получать информацию о сроках обработки своих персональных данных, в том числе о сроках их хранения;</p>
                        </li>
                        <li>
                            <p>требовать извещения всех лиц, которым ранее были сообщены неверные или неполные его персональные данные, обо всех произведённых в них исключениях, исправлениях или дополнениях;</p>
                        </li>
                        <li>
                            <p>обжаловать в уполномоченном органе по защите прав субъектов персональных данных или в судебном порядке неправомерные действия или бездействия при обработке его персональных данных;</p>
                        </li>
                        <li>
                            <p>на защиту своих прав и законных интересов, в том числе на возмещение убытков и (или) компенсацию морального вреда в судебном порядке.</p>
                        </li>
                    </ul>
                    <p>
                        Если у Вас есть вопросы о характере применения, использовании, изменении или удалении Ваших персональных данных, которые были Вами предоставлены, или если Вы хотите отказаться от дальнейшей их обработки Компанией, пожалуйста, свяжитесь с нами по электронной почте: info@ishtapp.kg.
                    </p>
                    <p>
                        Обращаем Ваше внимание, что оператор персональных данных не несет ответственности за недостоверную информацию, предоставленную субъектом персональных данных.
                    </p>

                    <p class="lead mt-5">5. Реализация требований к защите персональных данных</p>
                    <p>
                        С целью поддержания деловой репутации и обеспечения выполнения требований федерального законодательства Компания считает важнейшими задачами обеспечение легитимности обработки персональных данных в бизнес-процессах Компании и обеспечение надлежащего уровня безопасности обрабатываемых в Компании персональных данных.
                    </p>
                    <p>
                        Компания требует от иных лиц, получивших доступ к персональным данным, не раскрывать третьим лицам и не распространять персональные данные без согласия субъекта персональных данных, если иное не предусмотрено федеральным законом.
                    </p>
                    <p>
                        С целью обеспечения безопасности персональных данных при их обработке Компания принимает необходимые и достаточные правовые, организационные и технические меры для защиты персональных данных от неправомерного или случайного доступа к ним, уничтожения, изменения, блокирования, копирования, предоставления, распространения персональных данных, а также от иных неправомерных действий в отношении них.
                    </p>
                    <p>
                        Компания добивается того, чтобы все реализуемые ею мероприятия по организационной и технической защите персональных данных осуществлялись на законных основаниях, в том числе в соответствии с требованиями законодательства Кыргызской Республики по вопросам обработки персональных данных.
                    </p>
                    <p>
                        В целях обеспечения адекватной защиты персональных данных Компания проводит оценку вреда, который может быть причинен субъектам персональных данных в случае нарушения безопасности их персональных данных, а также определяет актуальные угрозы безопасности персональных данных при их обработке в информационных системах персональных данных.
                    </p>
                    <p>
                        В соответствии с выявленными актуальными угрозами Компания применяет необходимые и достаточные правовые, организационные и технические меры по обеспечению безопасности персональных данных, включающие в себя использование средств защиты информации, обнаружение фактов несанкционированного доступа к персональным данным и принятие мер, восстановление персональных данных, ограничение доступа к персональным данным, регистрацию и учет действий с персональными данными, а также контроль и оценку эффективности применяемых мер по обеспечению безопасности персональных данных.
                    </p>
                    <p>
                        Руководство Компании осознает важность и необходимость обеспечения безопасности персональных данных и поощряет постоянное совершенствование системы защиты персональных данных, обрабатываемых в рамках выполнения основной деятельности Компании.
                    </p>
                    <p>
                        В Компании назначены лица, ответственные за организацию обработки и обеспечение безопасности персональных данных.
                    </p>
                    <p>
                        Каждый новый работник Компании, непосредственно осуществляющий обработку персональных данных, ознакамливается с требованиями законодательства Кыргызской Республики по обработке и обеспечению безопасности персональных данных, настоящей Политикой и другими локальными актами Компании по вопросам обработки и обеспечения безопасности персональных данных и обязуется их соблюдать.
                    </p>
                </div>
            </div>
        </div>

    </div>
    <!-- // end .section -->

@if(app()->getlocale() == 'ru')

    <div class="section bg-gradient">
        <div class="container">
            <div class="call-to-action">

                <div class="box-icon"><span class="ti-mobile gradient-fill ti-3x"></span></div>
                <h2>Загрузка приложения</h2>
                <p class="tagline text-white">Наше приложение доступно на следующих платформах. Выберите тот, который вам подходит. </p>
                <div class="my-4">
                    <a target="_blank" href="https://apps.apple.com/kg/app/ishtapp/id1561101479" class="btn btn-light">
                        <img src="{{asset('images/appleicon.png')}}" alt="icon"> App Store
                    </a>
                    <a target="_blank" href="https://play.google.com/store/apps/details?id=ulut.kg.ishapp" class="btn btn-light">
                        <img src="{{asset('images/playicon.png')}}" alt="icon"> Google play
                    </a>
                    <a target="_blank" href="https://appgallery.huawei.com/#/app/C104077717" class="btn btn-light">
                        <img src="{{asset('images/galleryicon.png')}}" alt="icon"> App Gallery
                    </a>
                </div>
                <p class="text-white"><small><i>Работает на платформах *iOS 10.0.5+, Android Kitkat и выше </i></small></p>
            </div>
        </div>

    </div>
    <!-- // end .section -->

    <div class="light-bg py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <p class="mb-2"> <span class="ti-location-pin mr-2"></span>Сделано в Кыргызстане</p>
                    <div class=" d-block d-sm-inline-block">
                        <p class="mb-2">
                            <span class="ti-email mr-2"></span> <a class="mr-4" href="mailto:info@ishtapp.kg">info@ishtapp.kg</a>
                        </p>
                    </div>
                    <div class="d-block d-sm-inline-block">
                        <p class="mb-0">
                            <span class="ti-headphone-alt mr-2"></span> <a href="tel:51836362800">0550-05-03-66</a>
                        </p>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="social-icons">
                        <a href="#"><span class="ti-facebook"></span></a>
                        <a href="#"><span class="ti-twitter-alt"></span></a>
                        <a href="#"><span class="ti-instagram"></span></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- // end .section -->
    <footer class="my-5 text-center">
        <!-- Copyright removal is not prohibited! -->
        <p class="mb-2"><small>COPYRIGHT © 2021. ALL RIGHTS RESERVED. ISHTAPP</small></p>

        <small>
            <a href="#" class="m-2">PRESS</a>
            <a href="#" class="m-2">TERMS</a>
            <a href="#" class="m-2">PRIVACY</a>
        </small>
    </footer>

@else

    <div class="section bg-gradient">
        <div class="container">
            <div class="call-to-action">

                <div class="box-icon"><span class="ti-mobile gradient-fill ti-3x"></span></div>
                <h2>Жүктөп алыңыз</h2>
                <p class="tagline text-white">Колдонмобуз төмөнкү платформаларда жеткиликтүү. Сизге тийиштүүсүн тандаңыз. </p>
                <div class="my-4">
                    <a target="_blank" href="https://apps.apple.com/kg/app/ishtapp/id1561101479" class="btn btn-light">
                        <img src="{{asset('images/appleicon.png')}}" alt="icon"> App Store
                    </a>
                    <a target="_blank" href="https://play.google.com/store/apps/details?id=ulut.kg.ishapp" class="btn btn-light">
                        <img src="{{asset('images/playicon.png')}}" alt="icon"> Google play
                    </a>
                    <a target="_blank" href="https://appgallery.huawei.com/#/app/C104077717" class="btn btn-light">
                        <img src="{{asset('images/galleryicon.png')}}" alt="icon"> App Gallery
                    </a>
                </div>
                <p class="text-white"><small><i>*iOS 10.0.5+, Android Kitkat жана андан жогорку үлгүдөгү платформаларда иштейт. </i></small></p>
            </div>
        </div>

    </div>
    <!-- // end .section -->

    <div class="light-bg py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <p class="mb-2"> <span class="ti-location-pin mr-2"></span>Кыргызстанда жасалган</p>
                    <div class=" d-block d-sm-inline-block">
                        <p class="mb-2">
                            <span class="ti-email mr-2"></span> <a class="mr-4" href="mailto:info@ishtapp.kg">info@ishtapp.kg</a>
                        </p>
                    </div>
                    <div class="d-block d-sm-inline-block">
                        <p class="mb-0">
                            <span class="ti-headphone-alt mr-2"></span> <a href="tel:51836362800">0550-05-03-66</a>
                        </p>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="social-icons">
                        <a href="#"><span class="ti-facebook"></span></a>
                        <a href="#"><span class="ti-twitter-alt"></span></a>
                        <a href="#"><span class="ti-instagram"></span></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- // end .section -->
    <footer class="my-5 text-center">
        <!-- Copyright removal is not prohibited! -->
        <p class="mb-2"><small>COPYRIGHT © 2021. ALL RIGHTS RESERVED. ISHTAPP</small></p>

        <small>
            <a href="#" class="m-2">PRESS</a>
            <a href="#" class="m-2">TERMS</a>
            <a href="{{route('web.privacy')}}" class="m-2">PRIVACY</a>
        </small>
    </footer>

@endif

<!-- jQuery and Bootstrap -->
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- Plugins JS -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{asset('js/script.js')}}"></script>

</body>

</html>
