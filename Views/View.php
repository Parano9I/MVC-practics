<?php

namespace Shop\Views;

class View
{
    private static $viewTemplate;
    private const HEAD_NAME = 'head';
    private const TEMPLATES_EXTENSION = '.php';

    private static function getTemplatesDir(): string
    {
        return dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'templates';
    }

    private static function getHeadTemplate(): void
    {
    }

    public static function render(string $template, array $args = []): void
    {
        self::$viewTemplate = $template;
        extract($args);

        if (!empty(self::HEAD_NAME)) {
            require_once self::getTemplatesDir() . DIRECTORY_SEPARATOR .  self::HEAD_NAME . self::TEMPLATES_EXTENSION;
        };
        require_once self::getTemplatesDir() . DIRECTORY_SEPARATOR . self::$viewTemplate . self::TEMPLATES_EXTENSION;
    }
}