<?php

if (class_exists(Eccube2\Console\Application::class)) {
    Eccube2\Console\Application::prependConfigPath(realpath(__DIR__ . '/../config'));
}
