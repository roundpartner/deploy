all:
	composer update --no-dev
	composer dumpautoload --optimize
