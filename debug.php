<?php
# For magento 2
# require_once dirname(__DIR__) . '/debug.php'; in file: app/bootstrap.php:30
# require_once dirname(__DIR__) . '/../../debug.php'; in file: vendor/phpunit/phpunit/phpunit:50

namespace Debug;
final class Debug
{
    static private $_removeIp = '';

    /**
     * @var int
     */
    public static $argLength = 16;

    /**
     * Magento Root path
     *
     * @var string
     */
    protected static $_filePath;

    protected static function checkRemoteIp()
    {
        if (self::$_removeIp === '')
            return true;
        if (self::$_removeIp === $_SERVER['REMOTE_ADDR'])
            return true;

        return false;
    }

    public static function log($message, $file = 'xdebug.log')
    {
        try {
            if (!self::checkRemoteIp()) {
                return;
            }

            $logDir = __DIR__ . '/';
            // $logDir = __DIR__ . '/var/log/';
            // $logFile = $logDir . '/' . date('Ymd') . '_' . $file;
            $logFile = $logDir . $file;

            if (!is_dir($logDir)) {
                mkdir($logDir);
                chmod($logDir, 0750);
            }

            if (!file_exists($logFile)) {
                file_put_contents($logFile, '');
                chmod($logFile, 0640);
            }

            $time = new \DateTime();
            $time = '[' . $time->format("Y-M-d h:i:s") . ']: ';
            $message = print_r($message, true) . "\n";
            file_put_contents($logFile, $time . $message, FILE_APPEND);
            unset($message);
        } catch (Exception $e) {
        }
    }

    public static function log_trace($return = true, $html = false, $withArgs = true)
    {
        self::log(self::backtrace($return, $html, $withArgs));
    }

    /**
     * Retrieve real root path with last directory separator
     *
     * @return string
     */
    public static function getRootPath()
    {
        if (self::$_filePath === null) {
            if (defined('BP')) {
                self::$_filePath = BP;
            } else {
                self::$_filePath = dirname(__DIR__);
            }
        }

        return self::$_filePath;
    }

    /**
     * Prints or returns a backtrace
     *
     * @param bool $return return or print
     * @param bool $html output in HTML format
     * @param bool $withArgs add short arguments of methods
     * @return string|bool
     */
    public static function backtrace($return = true, $html = false, $withArgs = true)
    {
        $trace = debug_backtrace();

        return self::trace($trace, $return, $html, $withArgs);
    }

    /**
     * Prints or return a trace
     *
     * @param array $trace trace array
     * @param bool $return return or print
     * @param bool $html output in HTML format
     * @param bool $withArgs add short arguments of methods
     * @return string|bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public static function trace(array $trace, $return = false, $html = true, $withArgs = true)
    {
        $out = '';
        if ($html) {
            $out .= '<pre>';
        }

        foreach ($trace as $i => $data) {
            // skip self
            if ($i == 0) {
                continue;
            }

            // prepare method arguments
            $args = [];
            if (isset($data['args']) && $withArgs) {
                foreach ($data['args'] as $arg) {
                    $args[] = self::_formatCalledArgument($arg);
                }
            }

            // prepare method's name
            if (isset($data['class']) && isset($data['function'])) {
                if (isset($data['object']) && get_class($data['object']) != $data['class']) {
                    $className = get_class($data['object']) . '[' . $data['class'] . ']';
                } else {
                    $className = $data['class'];
                }
                if (isset($data['object'])) {
                    $className .= sprintf('#%s#', spl_object_hash($data['object']));
                }

                $methodName = sprintf(
                    '%s%s%s(%s)',
                    $className,
                    isset($data['type']) ? $data['type'] : '->',
                    $data['function'],
                    join(', ', $args)
                );
            } elseif (isset($data['function'])) {
                $methodName = sprintf('%s(%s)', $data['function'], join(', ', $args));
            }

            if (isset($data['file'])) {
                $pos = strpos($data['file'], self::getRootPath());
                if ($pos !== false) {
                    $data['file'] = substr($data['file'], strlen(self::getRootPath()) + 1);
                }
                $fileName = sprintf('%s:%d', $data['file'], $data['line']);
            } else {
                $fileName = false;
            }

            if ($fileName) {
                $out .= sprintf('#%d %s called at [%s]', $i, $methodName, $fileName);
            } else {
                $out .= sprintf('#%d %s', $i, $methodName);
            }

            $out .= "\n";
        }

        if ($html) {
            $out .= '</pre>';
        }

        if ($return) {
            return $out;
        } else {
            echo $out;

            return true;
        }
    }

    /**
     * Format argument in called method
     *
     * @param mixed $arg
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected static function _formatCalledArgument($arg)
    {
        $out = '';
        if (is_object($arg)) {
            $out .= sprintf("&%s#%s#", get_class($arg), spl_object_hash($arg));
        } elseif (is_resource($arg)) {
            $out .= '#[' . get_resource_type($arg) . ']';
        } elseif (is_array($arg)) {
            $isAssociative = false;
            $args = [];
            foreach ($arg as $k => $v) {
                if (!is_numeric($k)) {
                    $isAssociative = true;
                }
                $args[$k] = self::_formatCalledArgument($v);
            }
            if ($isAssociative) {
                $arr = [];
                foreach ($args as $k => $v) {
                    $arr[] = self::_formatCalledArgument($k) . ' => ' . $v;
                }
                $out .= 'array(' . join(', ', $arr) . ')';
            } else {
                $out .= 'array(' . join(', ', $args) . ')';
            }
        } elseif ($arg === null) {
            $out .= 'NULL';
        } elseif (is_numeric($arg) || is_float($arg)) {
            $out .= $arg;
        } elseif (is_string($arg)) {
            if (strlen($arg) > self::$argLength) {
                $arg = substr($arg, 0, self::$argLength) . "...";
            }
            $arg = strtr($arg, ["\t" => '\t', "\r" => '\r', "\n" => '\n', "'" => '\\\'']);
            $out .= "'" . $arg . "'";
        } elseif (is_bool($arg)) {
            $out .= $arg === true ? 'true' : 'false';
        }

        return $out;
    }
}