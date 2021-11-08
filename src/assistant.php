<?php

declare(strict_types=1);

if (
	!(is_file($file = __DIR__ . '/../vendor/autoload.php') && include $file) &&
	!(is_file($file = __DIR__ . '/../../../autoload.php') && include $file)
) {
	fwrite(STDERR, "Install packages using Composer.\n");
	exit(1);
}

if (function_exists('pcntl_signal')) {
	pcntl_signal(SIGINT, function (): void {
		pcntl_signal(SIGINT, SIG_DFL);
		echo "Terminated\n";
		exit(1);
	});
} elseif (function_exists('sapi_windows_set_ctrl_handler')) {
	sapi_windows_set_ctrl_handler(function () {
		echo "Terminated\n";
		exit(1);
	});
}

set_time_limit(0);

$runner = new Nette\Assistant\CliRunner;
die($runner->run());
