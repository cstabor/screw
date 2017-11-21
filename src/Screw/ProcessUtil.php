<?php

namespace Screw;

class ProcessUtil
{
    /**
     * Execute a command and return it's output.
     * Exit when the timeout has expired.
     *
     * @param string $cmd     Command to execute.
     * @param integer $timeout Timeout in seconds.
     * @param integer $code
     * @return string Output of the command.
     * @throws \Exception
     */
    public static function exec($cmd, $timeout, &$code)
    {
        $code = -11;
        // File descriptors passed to the process.
        $descriptors = [
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w']   // stderr
        ];
        
        // Start the process.
        $process = proc_open('exec ' . $cmd, $descriptors, $pipes);
        if (!is_resource($process)) {
            throw new \Exception('Could not execute process');
        }
        
        // Set the stdout stream to none-blocking.
        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);
        
        // Turn the timeout into microseconds.
        $timeout *= 1000000;
        
        // Output buffer.
        $buffer = '';
        
        // While we have time to wait.
        while ($timeout > 0) {
            $start = microtime(true);
            // Wait until we have output or the timer expired.
            $read  = [$pipes[1]];
            $write = $other = [];
            stream_select($read, $write, $other, 0, $timeout);
            
            // Get the status of the process.
            // Do this before we read from the stream,
            // this way we can't lose the last bit of output if the process dies between these functions.
            $status = proc_get_status($process);
            if (false === $status['running']) {
                $code = $status['exitcode'];
            }
            
            // Read the contents from the buffer.
            // This function will always return immediately as the stream is none-blocking.
            $buffer .= stream_get_contents($pipes[1]);
            
            if (!$status['running']) {
                break; // Break from this loop if the process exited before the timeout.
            }
            
            // Subtract the number of microseconds that we waited.
            $timeout -= (microtime(true) - $start) * 1000000;
        }
        // Check if there were any errors.
        $errors = stream_get_contents($pipes[2]);
        if (!empty($errors)) {
            throw new \Exception($errors);
        }
        // Kill the process in case the timeout expired and it's still running.
        // If the process already exited this won't do anything.
        proc_terminate($process, 9);
        
        // Close all streams.
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        
        proc_close($process);
        
        return $buffer;
    }
}
