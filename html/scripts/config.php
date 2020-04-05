<?php 
/*
    Создание констант путей
    
    realpath — возвращает канонизированный абсолютный путь к файлу
    dirname - возвращает имя родительского каталога из указанного пути. В РНР 7 можно использовать __DIR__ вместо dirname(__FILE__)
    __FILE__ - возвращает полный путь и имя текущего файла с развернутыми симлинками. Если используется внутри подключаемого файла, то возвращается имя данного файла.
    __DIR__ - возвращает имя директории. Эквивалентно вызову dirname(__FILE__).
    defined("LIBRARY_PATH") - это проверка на наличие
    or define() - это создание консанты (в данном случае - пути)
    
    Пример:
    echo(__FILE__) выдаст /home/cabox/workspace/download/a/sandbox/test.php
    echo realpath(dirname(__FILE__)) = realpath(__DIR__) выдаст /home/cabox/workspace/download/a/sandbox
    Имя TEST_PATH будет соответсвенно  присвоено к /home/cabox/workspace/download/a/sandbox
    
    Использовать так: require_once(TEST_PATH . "/file.php");
    
    Указать путь на уровень выше:
    dirname(dirname(__FILE__)) выдает /home/cabox/workspace/download/a
    Чтобы прописать из папки /home/cabox/workspace/download/a/www путь к соседней папке /home/cabox/workspace/download/a/include: 
    include dirname(dirname(__FILE__)) . '/include/header.php'
    Эквивалентно (для РНР7): return dirname(__FILE__, 2), где 2 - на сколько уровней вверх;
    
*/
// defined("TEST_PATH") or define("TEST_PATH", realpath(dirname(__FILE__)));