<?php


namespace Tests\Feature;


trait ApiVersion
{

    protected $apiVersionPath = '/api/v1/';

    /**
     * Получить полный путь к эндпоинту
     * @param string $path
     * @return string
     */
    protected function getFullPath(string $path)
    {
        return $this->apiVersionPath . ltrim($path, '/');
    }

}
