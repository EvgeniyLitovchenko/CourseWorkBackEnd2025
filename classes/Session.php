<?php

namespace classes;

class Session
{
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function setValues(array $values)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }
    }
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        session_destroy();
    }
}