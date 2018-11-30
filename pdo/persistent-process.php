<?php

require __DIR__ . '/bootstrap.php';

if (!extension_loaded('pcntl')) {
    die("Extension pcntl is not loaded\n");
}

$processes = [];
$processesCount = 2;

for ($i = 0; $i < 2; $i++) {
    $pid = pcntl_fork();
    if ($pid < 0) {
        die("Could not fork\n");
    }
    if ($pid > 0) {
        // parent process
        $processes[] = $pid; // record child process ID
        continue;
    }

    // child process

    for ($j = 0; $j < 3; $j++) {
        $conn = getConnection();
        echo sprintf("Process #%d connection ID: %d\n", posix_getpid(), $conn->getID());
    }

    exit(0);
}

foreach ($processes as $process) {
    // wait child process to exit
    $pid = pcntl_waitpid($process, $status);
    echo sprintf("Child process #%d exited with status: %d\n", $process, $status);
}