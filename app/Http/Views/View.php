<?php

namespace App\Http\Views;

class View
{
    protected static $layout = null;
    protected static $sections = [];
    protected static $currentSection = null;

    public static function render(string $view, array $data = []): string
    {
        // Backup state to support nested view calls (partials)
        $lastLayout = self::$layout;
        $lastSections = self::$sections;
        $lastSection = self::$currentSection;

        // Reset state for this render scope
        self::$layout = null;
        self::$sections = [];
        self::$currentSection = null;

        try {
            $content = self::renderFile($view, $data);

            if (self::$layout) {
                self::$sections['content'] = $content;
                return self::renderFile(self::$layout, array_merge($data, self::$sections));
            }

            return $content;
        } finally {
            // Restore state
            self::$layout = $lastLayout;
            self::$sections = $lastSections;
            self::$currentSection = $lastSection;
        }
    }

    protected static function renderFile(string $view, array $data): string
    {
        $path = self::resolveViewPath($view);
        extract($data);
        ob_start();
        include $path;
        return ob_get_clean();
    }

    protected static function resolveViewPath(string $view): string
    {
        $viewPath = str_replace('.', '/', $view);
        $path = BASE_PATH . '/resources/views/' . $viewPath . '.php';

        if (!file_exists($path)) {
            throw new \Exception("View file not found: {$path}");
        }
        return $path;
    }

    public static function extend(string $layout): void
    {
        self::$layout = $layout;
    }

    public static function section(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }

    public static function endsection(): void
    {
        if (self::$currentSection) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }

    public static function yieldContent(string $name): string
    {
        return self::$sections[$name] ?? '';
    }
}
