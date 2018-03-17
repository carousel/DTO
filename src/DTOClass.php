<?php

namespace Carousel\DTO;

class DTOClass
{
    public function __construct(array $request)
    {
        $this->request = $request;
    }
    public function exists($key)
    {
        return array_key_exists($key, $this->request);
    }
    public function except($keys)
    {
        $this->forget($keys);

        return $this->request;
    }
    public function forget($keys)
    {
        $original = &$this->request;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if ($this->exists($key)) {
                unset($this->request[$key]);
                continue;
            }

            $parts = explode('.', $key);
            // clean up before each pass
            $array = &$original;
            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }
    public function only($keys)
    {
        return array_intersect_key($this->request, array_flip((array) $keys));
    }
    public function __get($key)
    {
        if (array_key_exists($key, $this->request)) {
            return $this->request[$key];
        }
    }
    public function serialize()
    {
        return serialize($this->request);
    }
    public function decamelize($input = null)
    {
        if ($input != null) {
            $request = [];
            $decamelized = strtolower(str_replace(' ', '', preg_replace('/(?<!^)[A-Z]/', '_$0', $input)));
            $request[$decamelized] = $this->request[$input];
            return $request;
        } else {
            $request = [];
            foreach ($this->request as $key => $val) {
                $request[strtolower(str_replace(' ', '', preg_replace('/(?<!^)[A-Z]/', '_$0', $key)))] = $val;
            }
            return $request;
        }
    }
    public function camelize($input = null)
    {
        if ($input != null) {
            $request = [];
            $camelized = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
            $request[$camelized] = $this->request[$input];
            return $request;
        } else {
            $request = [];
            foreach ($this->request as $key => $val) {
                $request[lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))))] = $val;
            }
            return $request;
        }
    }
    public function append($input)
    {
        foreach ($input as $key => $val) {
            $this->request[$key] = $val;
        }
        return $this->request;
    }
}
