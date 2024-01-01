<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ErrorPageException extends Exception
{
    /**
     * @var array{
     *      title:string|null,
     *      description:string|null,
     *      icon:string|null,
     *      type:string
     *  }
     */
    public array $error_data = [];

    /**
     * @param array{
     *     title:string|null,
     *     description:string|null,
     *     icon:string|null,
     *     type:string
     * } $data
     */
    public function __construct(array $data, int $code = 0, ?Throwable $previous = null)
    {
        $this->error_data = [
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'icon' => $data['icon'] ?? null,
            'type' => $data['type'] ?? null,
        ];
        parent::__construct($data['title'], $code, $previous);
    }
}
