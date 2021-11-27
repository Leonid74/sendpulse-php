<?php

/**
 * Interface TokenStorageInterface
 */

namespace Leonid74\Sendpulse\Storage;

interface TokenStorageInterface
{
    /**
     * @param $key string
     * @param $token
     *
     * @return mixed
     */
    public function set($key, $token);

    /**
     * @param $key string
     *
     * @return mixed
     */
    public function get($key);
}
