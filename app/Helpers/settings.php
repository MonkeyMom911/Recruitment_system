<?php
if (!function_exists('setting')) {
    /**
     * Get or set the specified setting value.
     *
     * @param string|array|null $key
     * @param mixed $default
     * @return mixed|\App\Models\Setting
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            app('setting')->set($key);
            return app('setting');
        }

        return app('setting')->get($key, $default);
    }
}