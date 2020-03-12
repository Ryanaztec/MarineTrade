<?php

namespace App\AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CacheClearListener {
    public function onPostUpdate() {
        // HARDCODE databases 1 and 5 as cache related Redis databases
        $process = new Process('/usr/bin/redis-cli -n 1 flushdb && /usr/bin/redis-cli -n 5 flushdb');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            //	    throw new ProcessFailedException($process);
        }

        //echo $process->getOutput();die;
    }
}
