<?php

require_once __DIR__.'/silex.phar';
$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
    'twig.options'    => array('cache' => __DIR__.'/cache')
));

$app->post('/add-reason.json', function() use ($app) {
    $res = mail('admin@dont-code.com', 'dont-code.com: Новая причина не писать код сегодня!', $app['request']->get('message'));
    return json_encode(array('success' => $res));
});
$app->post('/send-feedback.json', function() use ($app) {
    $body = <<<TXT
Email: {$app['request']->get('email')}
Message: {$app['request']->get('message')}
TXT;
    $res = mail('admin@dont-code.com', 'dont-code.com: Новай отзыв', $body);
    return json_encode(array('success' => $res));
});

$app->get('/', function() use ($app) {
    return $app->redirect('/ru.html');
});

$app->get('/{lang}.html', function ($lang) use ($app) {

    $lang = ($lang === 'undef') ?
            substr($app['request']->getPreferredLanguage(), 0, 2) :
            $lang;

    // RU
    if ($lang == 'ru') {
        $title = 'Не пиши код сегодня!';
        $locale = 'ru_RU';
        $meta = array(
            'title' => 'Не пиши код сегодня!',
            'site_name' => 'Не пиши код сегодня!',
            'keywords' => 'Не пиши код, программирование, код, программист',
            'description' => 'Несколько причин не писать код сегодня, добавь свою!'
        );
        $twText = 'Ты все еще пишешь код?! Несколько причин не писать код сегодня!';
        $links = array(
            'swearing_off' => 'убрать мат',
            'swearing_on' => 'вернуть мат',
            'add_reason' => 'Добавить причину',
            'feedback' => 'связь',
            'your_email' => 'твой email',
            'message' => 'сообщение',
            'close' => 'закрыть',
            'success_reason' => 'Успешно! твоя причина будет добавлена после модерации :)',
            'error_reason' => 'Неудача! что-то пошло не так, свяжись с нами!',
            'success_feedback' => 'Успешно! мы скоро ответим вам!',
            'add' => 'Добавить',
            'send' => 'Отправить'
        );
    // EN
    } else if ($lang == 'en') {
        $title = "Don't code today!";
        $locale = 'en_US';
        $meta = array(
            'title' => 'Don&#039;t code today!',
            'site_name' => 'Don&#039;t code today!',
            'keywords' => 'don’t code, coding, code, coder, programmer, programming',
            'description' => 'several reasons not to code today, add yours!'
        );
        $twText = '“Still coding?! Several reasons not to code today!”';
        $links = array(
            'swearing_off' => 'hide swearing',
            'swearing_on' => 'show swearing',
            'add_reason' => 'Add reason',
            'feedback' => 'feedback',
            'your_email' => 'your email',
            'message' => 'message',
            'close' => 'close',
            'success_reason' => 'Success! Your reason will be added after review :)',
            'error_reason' => 'Error! Something went wrong, please get in touch with us!',
            'success_feedback' => 'Success! We’ll reply soon!',
            'add' => 'Add',
            'send' => 'Send'
        );
    // FR
    } else if ($lang == 'fr') {
        $title = "N'ecris pas le code aujourd'hui";
        $locale = 'fr_FR';
        $meta = array(
            'title' => 'N&#039;ecris pas le code aujourd&#039;hui',
            'site_name' => 'N&#039;ecris pas le code aujourd&#039;hui',
            'keywords' => "n'ecris pas le code, programmation, code, programmeur",
            'description' => 'Quelques raisons de ne pas écrire le code aujourd&#039;hui'
        );
        $twText = "As -tu encore écrire le code? Quelques raisons de ne pas écrire le code aujourd'hui";
        $links = array(
            'swearing_off' => 'enlever les obscénités',
            'swearing_on' => 'rendre les obscénités',
            'add_reason' => "Ajouter l'argument",
            'feedback' => "l'information en retour",
            'your_email' => 'ton email',
            'message' => 'un message',
            'close' => 'clore',
            'success_reason' => 'Avec succès! Ton argument sera ajouté après la modération :)',
            'error_reason' => "L'échec! Quelque chose est pass'é incorrect, contacte avec administrateur",
            'success_feedback' => 'Avec succès! Nous allons vous répondre!',
            'add' => 'Ajouter',
            'send' => 'Envoyer'
        );
    // DE
    } else {
        $title = "Codier du nicht!";
        $locale = 'de_DE';
        $meta = array(
            'title' => 'Codier du nicht!',
            'site_name' => 'Codier du nicht!',
            'keywords' => 'codier du nicht, programmierung, code, programmierer',
            'description' => 'Mehrere Gründe, heute nicht zu codieren, füg deinen hinzu!'
        );
        $twText = 'Codierst du noch?! Mehrere Gründe, heute nicht zu codieren!';
        $links = array(
            'swearing_off' => 'entfernen schimpfwörter',
            'swearing_on' => 'zurückstellen schimpfwörter',
            'add_reason' => 'Fügen einen Grund hinzu',
            'feedback' => 'feed-back',
            'your_email' => 'dein email',
            'message' => 'nachricht',
            'close' => 'verlassen',
            'success_reason' => 'Erfolgreich! Dein Grund wird nach der Moderation hinzugefügt :)',
            'error_reason' => 'Fehler! Etwas ging schief, setzt du dich mit Admin ins Vernehmen!',
            'success_feedback' => 'Erfolgreich! Wir werden bald antworten!',
            'add' => 'Hinzufügen',
            'send' => 'Senden'
        );
    }

    return $app['twig']->render('index.twig.html', array(
        'title' => $title,
        'lang' => $lang,
        'now' => time(),
        'twText' => $twText,
        'locale' => $locale,
        'meta' => $meta,
        'links' => $links
    ));

})
->assert('lang', 'ru|en|de|fr')->value('lang', 'undef');

$app->run();
?>
