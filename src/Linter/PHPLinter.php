<?php

namespace Photocreate\Api\Client\Linter;

class PHPLinter implements LinterInterface
{
    /**
     * @param string $code
     * @param string $output
     * @return bool true: is valid code, false: is invalid code
     */
    public function lint($code, &$output)
    {
        $tempFile = tempnam(sys_get_temp_dir(), '');
        file_put_contents($tempFile, $code);
        exec("php -l {$tempFile}", $output, $return);

        unlink($tempFile);
        return ($return === 0);
    }
}
