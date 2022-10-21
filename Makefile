test:
	php bin/console doctrine:schema:update  --env=test --force && php bin/console doctrine:fixtures:load -n --env=test && php bin/phpunit
