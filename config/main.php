<?php

return [
    'logActive' => true,
    'logToConsole' => false,
    'logPath' => '/var/logs/',
    'dumpFile' => 'var/news.txt',                           // путь с дампом
    'feeds' => [
        [
            'scheme' => 'http',
            'url' => 'www.mk.ru/news/',
            'articlesClass' => 'div[class=center]',  // индертификатор новостных ссылок
            'articleNo' => 2,                               // берем ссылку под этим номером
            'contentClass' => 'div[class=content]',  // индентификатор новостного контента
            'removeTags' => [                               // удалять эти теги
				 'div[class=tools]',
				 'span[class=date]',
				 'script',
				 'div[id=__utl-buttons-1]',
				 'div[class=big_image]'
            ]
        ],
        [
            'scheme' => 'https',
            'url' => 'lenta.ru',
            'articlesClass' => 'div[class=items]',  // индертификатор новостных ссылок
            'articleNo' => 3,                               // берем ссылку под этим номером
            'contentClass' => 'div[class=b-topic__content]',  // индентификатор новостного контента
            'removeTags' => [                               // удалять эти теги
                'div[class=b-topic__info]',
				'div[class=b-topic__socials _header]',
				'div[class=b-banner]',
				'div[class=b-topic__title-image]',
				'div[class=b-box]',
				'div[itemprop=author]',
                'img',
                'script'
            ]
        ],
    ]
];