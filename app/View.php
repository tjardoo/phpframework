<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array $parameters = [],
    ) {
    }

    public static function make(string $view, array $parameters = []): static
    {
        return new static($view, $parameters);
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (file_exists($viewPath) == false) {
            throw new ViewNotFoundException();
        }

        foreach ($this->parameters as $key=>$value) {
            $$key = $value;
        }

        ob_start();

        include $viewPath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name): ?string
    {
        return $this->parameters[$name] ?? null;
    }
}