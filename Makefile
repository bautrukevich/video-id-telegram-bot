telegram.set-webhook:
	php set_webhook.php $(url) --ansi

serve:
	cd public && php -S 0.0.0.0:9900
share:
	ngrok http 9900

.PHONY: test
