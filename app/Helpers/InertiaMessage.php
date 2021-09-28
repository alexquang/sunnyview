<?php

namespace App\Helpers;

class InertiaMessage implements \JsonSerializable
{
    const LEVEL_INFO = 'info';

    const LEVEL_SUCCESS = 'success';

    const LEVEL_WARN = 'warn';

    const LEVEL_ERROR = 'error';

    /**
     * @var string
     */
    private $level;

    /**
     * @var string
     */
    private $content;

    public function success($content)
    {
        return $this->setContent($content, self::LEVEL_SUCCESS);
    }

    public function warn($content)
    {
        return $this->setContent($content, self::LEVEL_WARN);
    }

    public function error($content)
    {
        return $this->setContent($content, self::LEVEL_ERROR);
    }

    public function info($content)
    {
        return $this->setContent($content, self::LEVEL_INFO);
    }

    public function jsonSerialize()
    {
        return [
            'level' => $this->level,
            'content' => $this->content,
            'posted_at' => time(),
        ];
    }

    private function setContent($content, $level = self::LEVEL_INFO)
    {
        $this->level = $level;

        $this->content = translate($content);

        return $this;
    }
}
