all:
	composer update --no-dev -vvv
	composer dumpautoload --optimize
