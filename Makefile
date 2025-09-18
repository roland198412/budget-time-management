help: ## Shows available commands with description
		@echo "\033[34mList of available targets:\033[39m"
		@echo ""
		@echo "\033[33mTarget:\033[39m"
		@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-25s %s\n", $$1, $$2}'

up:  ## Sail up in detached mode
	[ -f sail ] && bash sail || bash vendor/bin/sail up -d
down: ## Sail down without removing any volumes
	[ -f sail ] && bash sail || bash vendor/bin/sail down
ps: ## Sail docker processes
	[ -f sail ] && bash sail || bash vendor/bin/sail ps
clear: ## Clear caches and reset cache permissions
	bash vendor/bin/sail artisan optimize:clear
	bash vendor/bin/sail artisan permission:cache-reset
	bash vendor/bin/sail artisan event:clear
	bash vendor/bin/sail artisan cache:clear
	bash vendor/bin/sail artisan config:clear
migrate: ## Run Migrations
	[ -f sail ] && bash sail || bash vendor/bin/sail artisan migrate --step
seed: ## Run Seeders
	[ -f sail ] && bash sail || bash vendor/bin/sail artisan db:seed
rollback: ## Rollback migrations
	[ -f sail ] && bash sail || bash vendor/bin/sail artisan migrate:rollback
shell: ## Create a shell into the application container
	[ -f sail ] && bash sail || bash vendor/bin/sail bash
tink: ## Laravel tinker
	[ -f sail ] && bash sail || bash vendor/bin/sail tinker