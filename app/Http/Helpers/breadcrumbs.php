<?php


// News
Breadcrumbs::for('posts', function ($trail) {
    $trail->parent('home');
    $trail->push('Новости', route('post.index'));
});

// News Single
Breadcrumbs::for('posts.single', function ($trail, $post) {
    $trail->parent('posts');
    $trail->push($post->getName(), route('post.single', $post));
});


// Calendar
Breadcrumbs::for('calendar', function ($trail) {
    $trail->parent('home');
    $trail->push('Календарь', route('calendar.index'));
});
Breadcrumbs::for('calendar_event', function ($trail, $event) {
    $trail->parent('calendar');
    $trail->push($event->getName(), route('calendar.event', $event));
});


// Home > Page
Breadcrumbs::for('page', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page->getName(), route('page.single', $page));
});


// Home > Search
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('home');
    $trail->push('Поиск');
});

