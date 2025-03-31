test:
	vendor/bin/phpstan analyse --level 9 src tests
	XDEBUG_MODE=coverage vendor/bin/phpunit src tests

style:
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix
