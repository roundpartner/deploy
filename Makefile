all:
	composer update --no-dev -vvv roundpartner/configuration
	composer update --no-dev -vvv roundpartner/cloud
	composer update --no-dev -vvv roundpartner/verify-hash
	composer dumpautoload --optimize
