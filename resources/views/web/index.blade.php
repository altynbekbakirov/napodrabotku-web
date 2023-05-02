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

    <div class="nav-menu fixed-top">
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
                                <li class="nav-item"> <a class="nav-link active" href="#home">ГЛАВНАЯ <span class="sr-only">(current)</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#features">ДОСТОИНСТВА</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#gallery">ИНТЕРФЕЙС</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#contact">ЗАГРУЗКА</a> </li>
                                <li class="nav-item"><a href="{{ LaravelLocalization::getLocalizedURL('ky', null, [], true) }}" class="btn btn-outline-light my-3 my-sm-0 ml-lg-1">KG</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-gradient" id="home">
        <div class="container mt-5">
            <h1>Поиск работы теперь проще простого!</h1>
            <p class="tagline text-white">Современное мобильное приложение максимально упростит вам поиск работы. </p>
        </div>
        <div class="img-holder mt-3"><img src="{{asset('images/iphone.png')}}" alt="phone" class="img-fluid"></div>
    </header>

    <div class="section light-bg" id="features">


        <div class="container">

            <div class="section-title">
                <h3>То чего искали</h3>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-face-smile gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Простой</h4>
                                    <p class="card-text">С помощью умных технологий будут отображаться только те вакансии, которые вы ищете.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-settings gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Персональный</h4>
                                    <p class="card-text">Вы можете отправить свое резюме на любую вакансию в личном кабинете. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-lock gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Безопасный</h4>
                                    <p class="card-text">Безопасность вашей личной информации обеспечивается лучшим оборудованием и программным обеспечением. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- // end .section -->

    <div class="section">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="box-icon"><span class="ti-mobile gradient-fill ti-3x"></span></div>
                    <h2>Множество вакансий уже ждут вас</h2>
                    <p class="mb-4">Скачайте мобильное приложение, заполните свой профиль и подайте заявку на любую вакансию. </p>
                    <a href="#contact" class="btn btn-primary">ЗАГРУЗИТЬ</a>
                </div>
            </div>
            <div class="perspective-phone">
                <img src="{{asset('images/perspective.png')}}" alt="perspective phone" class="img-fluid">
            </div>
        </div>

    </div>
    <!-- // end .section -->

    <div class="section light-bg">
        <div class="container">
            <div class="section-title">
                <h3>Ваш лучший помощник в поиске работы</h3>
            </div>

            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#communication">Вакансии</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#schedule">Избранные</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages">Чат</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#livechat">Онлайн курсы</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="communication">
                    <div class="d-flex flex-column flex-lg-row">
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                        <div>

                            <h2>Вакансии всех регионов </h2>
                            <p class="lead">Выбирайте только интересующую Вас вакансию через специальный фильтр. </p>
                            <p>Предусмотрена возможность выбора только понравившихся Вам вакансий. Вакансии можно фильтровать по таким параметрам как регион, вид работы, зарплата и время работы.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="schedule">
                    <div class="d-flex flex-column flex-lg-row">
                        <div>
                            <h2>Выберите интересующую вас вакансию и подавайте заявку в любое время</h2>
                            <p class="lead">Сохраняйте интересующие вас вакансии в специальном разделе «Избранное». </p>
                            <p>Выбранные вами вакансии будут сохранены на вашей личной странице. Вы можете отправить свое разово заполненное резюме на любую вакансию.
                            </p>
                        </div>
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    </div>
                </div>
                <div class="tab-pane fade" id="messages">
                    <div class="d-flex flex-column flex-lg-row">
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                        <div>
                            <h2>Если у вас есть вопросы, воспользуйтесь чатом.</h2>
                            <p class="lead">Задайте свой вопрос представителю работодателя в чате.</p>
                            <p>Если у вас есть вопрос по объявленной работодателем вакансии, вы можете связаться с ним через чат.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="livechat">
                    <div class="d-flex flex-column flex-lg-row">
                        <div>
                            <h2>Познавайте новые профессии с онлайн-курсами. </h2>
                            <p class="lead">Следите за эксклюзивными курсами, адаптированными к текущим потребностям. </p>
                            <p>Осваивайте новые профессии, пройдя специальные курсы в приложении, специально подготовленные нашими экспертами и охватывающие самые современные профессии.
                            </p>

                        </div>
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- // end .section -->

    <div class="section light-bg">

        <div class="container">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <ul class="list-unstyled ui-steps">
                        <li class="media">
                            <div class="circle-icon mr-4">1</div>
                            <div class="media-body">
                                <h5>Загрузите приложение</h5>
                                <p>Приложение доступно на платформах Android, Harmony и iOS. </p>
                            </div>
                        </li>
                        <li class="media my-4">
                            <div class="circle-icon mr-4">2</div>
                            <div class="media-body">
                                <h5>Создайте свою страницу</h5>
                                <p>Зарегистрируйте свою личную страницу. Заполните свое резюме.</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4">3</div>
                            <div class="media-body">
                                <h5>Подавайте на любые вакансии</h5>
                                <p>Отправьте свое резюме на вакансии по вашему выбору. </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('images/login.png')}}" alt="iphone" class="img-fluid">
                </div>

            </div>

        </div>

    </div>
    <!-- // end .section -->


    <div class="section light-bg" id="gallery">
        <div class="container">
            <div class="section-title">
                <small>ИНТЕРФЕЙС</small>
                <h3>Примеры пользовательского интерфейса</h3>
            </div>

            <div class="img-gallery owl-carousel owl-theme">
                <img src="{{asset('images/screen1.jpg')}}" alt="image">
                <img src="{{asset('images/screen2.jpg')}}" alt="image">
                <img src="{{asset('images/screen3.jpg')}}" alt="image">
                <img src="{{asset('images/screen4.jpg')}}" alt="image">
                <img src="{{asset('images/screen5.jpg')}}" alt="image">
                <img src="{{asset('images/screen6.jpg')}}" alt="image">
                <img src="{{asset('images/screen7.jpg')}}" alt="image">
                <img src="{{asset('images/screen8.jpg')}}" alt="image">
            </div>

        </div>

    </div>
    <!-- // end .section -->

    <div class="client-logos my-5">
        <div class="container text-center">
            <img src="{{asset('images/client-logos.png')}}" alt="client logos" class="img-fluid">
        </div>
    </div>

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
        <p class="mb-2"><small>© 2021. Бардык укуктар корголгон. ISHTAPP</small></p>

        <small>
            <a href="#" class="m-2">PRESS</a>
            <a href="#" class="m-2">TERMS</a>
            <a href="{{route('web.privacy')}}" class="m-2">PRIVACY</a>
        </small>
    </footer>

@else

    <div class="nav-menu fixed-top">
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

    <header class="bg-gradient" id="home">
        <div class="container mt-5">
            <h1>Иш издөө эми оңойдон оңой!</h1>
            <p class="tagline text-white">Учурдун талабына жараша иштелип чыккан мобилдик колдонмо иш издөө түйшүгүңүздү жеңилдетет. </p>
        </div>
        <div class="img-holder mt-3"><img src="{{asset('images/iphone.png')}}" alt="phone" class="img-fluid"></div>
    </header>

    <div class="section light-bg" id="features">


        <div class="container">

            <div class="section-title">
                <h3>Талабыңызга жараша</h3>
            </div>


            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-face-smile gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Оңой</h4>
                                    <p class="card-text">Акылдуу технологиялар жардамы менен сиз издеген гана иш вакнсиялары көрсөтүлөт. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-settings gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Жеке</h4>
                                    <p class="card-text">Сизге гана таандык жеке аккаунтуңуз менен каалашыңызча вакансияларга резюмеңизди тапшыруу мүмкүнчүлүгү бар. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card features">
                        <div class="card-body">
                            <div class="media">
                                <span class="ti-lock gradient-fill ti-3x mr-3"></span>
                                <div class="media-body">
                                    <h4 class="card-title">Коопсуз</h4>
                                    <p class="card-text">Жеке маалыматыңыздын сактыгы эң мыкты жабдыктар жана программалар менен камсыздалат. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>
    <!-- // end .section -->

    <div class="section">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="box-icon"><span class="ti-mobile gradient-fill ti-3x"></span></div>
                    <h2>Көптөгөн вакансиялар сизди күтүп турат</h2>
                    <p class="mb-4">Мобилдик колдонмону жүктөп алыңыз, жеке баракчаңызды толтуруп, каалаган вакансияга тапшырыңыз. </p>
                    <a href="#contact" class="btn btn-primary">ЖҮКТӨӨ</a>
                </div>
            </div>
            <div class="perspective-phone">
                <img src="{{asset('images/perspective.png')}}" alt="perspective phone" class="img-fluid">
            </div>
        </div>

    </div>
    <!-- // end .section -->

    <div class="section light-bg">
        <div class="container">
            <div class="section-title">
                <h3>Иш издөөдө эң мыкты жардамчыңыз</h3>
            </div>

            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#communication">Вакансиялар</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#schedule">Тандоолор</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages">Жандуу байланыш</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#livechat">Онлайн курстар</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="communication">
                    <div class="d-flex flex-column flex-lg-row">
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                        <div>

                            <h2>Баардык аймактардан вакансияларды көрүңүз </h2>
                            <p class="lead">Колдонмонун ичиндеги атайын фильтр аркылуу сизге гана кызыктуу вакансияны тандаңыз. </p>
                            <p>Иш берүүчүлөр тарабынан жарыяланган вакансияларды регион, иштин түрү, маянасы, убактысы сыяктуу өзгөчөлүктөрүн тандап сизге жаккан гана ишти тандап алуу мүмкүнчүлүгү бар.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="schedule">
                    <div class="d-flex flex-column flex-lg-row">
                        <div>
                            <h2>Сиз кызыккан ишти тандап алып каалаган убактыңызда тапшырыңыз </h2>
                            <p class="lead">Көптөгөн вакансиялардын арасынан сизди кызыктырган вакансияларды атайын "Тандалгандар" бөлүмүнө сактаңыз. </p>
                            <p>Сиз тандаган вакансиялар жеке баракчаңызда сакталып калат. Алдынала бир эле ирет толтурулган резюмеңизди каалашыңызча вакансияларга жиберсеңиз болот.
                            </p>
                        </div>
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    </div>
                </div>
                <div class="tab-pane fade" id="messages">
                    <div class="d-flex flex-column flex-lg-row">
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                        <div>
                            <h2>Сурооңуз болсо дароо байланышыңыз </h2>
                            <p class="lead">Жандуу чат аркылуу жумуш-берүүчүнүн өкүлүнө сурооңузду бериңиз. </p>
                            <p>Иш берүүчү тарабынан жарыяланган вакансия туралуу сурооңуз болсо чат аркылуу иш берүүчүгө кайрылуу мүмкүнчулүгү каралган.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="livechat">
                    <div class="d-flex flex-column flex-lg-row">
                        <div>
                            <h2>Онлайн курстар менен жаңы кесиптерге ээ болуңуз. </h2>
                            <p class="lead">Учурдун талабына жараша атайын иштелип чыккан эксклюзивдүү курстарга байланыңыз. </p>
                            <p>Колдонмонун ичинде эксперттер тарабынан атайын дайындалган жана заманбап кесиптерди камтыган атайын курстарга катышып жаңы кесип ээси болуңуз.
                            </p>

                        </div>
                        <img src="{{asset('images/graphic.png')}}" alt="graphic" class="img-fluid rounded align-self-start mr-lg-5 mb-5 mb-lg-0">
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- // end .section -->

    <div class="section light-bg">

        <div class="container">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <ul class="list-unstyled ui-steps">
                        <li class="media">
                            <div class="circle-icon mr-4">1</div>
                            <div class="media-body">
                                <h5>Колдонмону жүктөңүз</h5>
                                <p>Колдонмобуз Android, Harmony жана iOS платформаларда жеткиликтүү. </p>
                            </div>
                        </li>
                        <li class="media my-4">
                            <div class="circle-icon mr-4">2</div>
                            <div class="media-body">
                                <h5>Жеке баракчаңызды каттаңыз</h5>
                                <p>Жеке баракчаңызды каттап, резюмеңизди толтуруңуз.</p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4">3</div>
                            <div class="media-body">
                                <h5>Көптөгөн вакансияларга тапшырыңыз</h5>
                                <p>Резюмеңизди сиз тандаган вакансияларга тапшырыңыз.  </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('images/login.png')}}" alt="iphone" class="img-fluid">
                </div>

            </div>

        </div>

    </div>
    <!-- // end .section -->

    <div class="section light-bg" id="gallery">
        <div class="container">
            <div class="section-title">
                <small>КЕЛБЕТИ</small>
                <h3>Колдонмонун беттеринен өрнөктөр</h3>
            </div>

            <div class="img-gallery owl-carousel owl-theme">
                <img src="{{asset('images/screen1.jpg')}}" alt="image">
                <img src="{{asset('images/screen2.jpg')}}" alt="image">
                <img src="{{asset('images/screen3.jpg')}}" alt="image">
                <img src="{{asset('images/screen4.jpg')}}" alt="image">
                <img src="{{asset('images/screen5.jpg')}}" alt="image">
                <img src="{{asset('images/screen6.jpg')}}" alt="image">
                <img src="{{asset('images/screen7.jpg')}}" alt="image">
                <img src="{{asset('images/screen8.jpg')}}" alt="image">
            </div>

        </div>

    </div>
    <!-- // end .section -->

    <div class="client-logos my-5">
        <div class="container text-center">
            <img src="{{asset('images/client-logos.png')}}" alt="client logos" class="img-fluid">
        </div>
    </div>

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
