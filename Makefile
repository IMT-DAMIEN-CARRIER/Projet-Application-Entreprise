SHELL=/bin/bash
#----------------------------------------------------------------------------------------------------------------------#
#                                                     VARIABLES                                                        #
#----------------------------------------------------------------------------------------------------------------------#
D=docker
DC=docker-compose
DF_SERVER=server/docker-compose.yml
DF_CLIENT=client/docker-compose.yml

DC_SERVER=$(DC) -f $(DF_SERVER)
DC_CLIENT=$(DC) -f $(DF_CLIENT)

EXEC_PHP_SERVER = $(DC_SERVER) exec -T -u www-data -e SYMFONY_ENV=$(SYMFONY_ENV) php
EXEC_PHP_CLIENT = $(DC_CLIENT) exec -T -u www-data -e SYMFONY_ENV=$(SYMFONY_ENV) php
#EXEC_PHP_CI = $(DC) exec -T -u www-data -e SYMFONY_ENV=test php
#EXEC_MYSQL = $(DC) exec -T mysql
#EXEC_ADMIN_PHP = $(DC) exec -T php
EXEC_COMPOSER_SERVER = $(EXEC_PHP_SERVER) composer
EXEC_COMPOSER_CLIENT = $(EXEC_PHP_CLIENT) composer
SYMFONY_ENV ?= dev
SYMFONY_SERVER = $(EXEC_PHP_SERVER) php bin/console --env=$(SYMFONY_ENV)
SYMFONY_CLIENT = $(EXEC_PHP_SERVER) php bin/console --env=$(SYMFONY_ENV)

#----------------------------------------------------------------------------------------------------------------------#
#                                                      COULEURS                                                        #
#----------------------------------------------------------------------------------------------------------------------#
COM_COLOR   = $(shell echo -e "\x1b[36m")
OK_COLOR    = $(shell echo -e "\x1b[32m")
ERROR_COLOR = $(shell echo -e "\x1b[31m")
WARN_COLOR  = $(shell echo -e "\x1b[33m")
NO_COLOR    = $(shell echo -e "\x1b[30m")

#----------------------------------------------------------------------------------------------------------------------#
#                                             DOCKER FRONT+BACK                                                        #
#----------------------------------------------------------------------------------------------------------------------#
##
## Général
#################################
stop: ## Extinction des containers Docker
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Extinction des containers Docker Client :                                           $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_CLIENT) stop
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Extinction des containers Docker Server :                                           $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_SERVER) stop
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"
.PHONY: stop

clean: stop reset-vendor## Suppression des containers et volumes Docker
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Suppression des containers et volumes Docker Client:                                $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_CLIENT) down -v --rmi all --remove-orphans
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Suppression des containers et volumes Docker Server :                               $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_SERVER) down -v --rmi all --remove-orphans
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"
.PHONY: clean

build: stop  ## Construction des containers Docker
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Construction des containers Docker Client :                                         $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_CLIENT) build
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Construction des containers Docker Server :                                         $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_SERVER) build
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"
.PHONY: build

start: ## Lancement des containers Docker
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Lancement des containers Docker Client :                                            $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_CLIENT) up -d --remove-orphans
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Lancement des containers Docker Server :                                            $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_SERVER) up -d --remove-orphans
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"
.PHONY: start

install : build start composer-install create-db-server migrate-server ## Installation du projet
.PHONY: install

reinstall: reset-vendor clean start composer-install ## Réinstalle le projet
.PHONY: reinstall

ps: ## Show project servicies
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Affichage des containers Docker Client :                                             $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_CLIENT) ps
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Affichage des containers Docker Server :                                             $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(DC_SERVER) ps
.PHONY: ps

#----------------------------------------------------------------------------------------------------------------------#
#                                                  SYMFONY                                                             #
#----------------------------------------------------------------------------------------------------------------------#
##
## Symfony
#################################

create-db-server:  wait-db## Crée la base de donnée si elle n'existe pas
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Création de la base de donnée :                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(EXEC_PHP_SERVER) bin/console doctrine:database:create --if-not-exists
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"

migrate-server: ## Effectue les migrations en bdd
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Exécution des migrations doctrine :                                                 $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(SYMFONY_SERVER) doctrine:migration:migrate --no-interaction --all-or-nothing --allow-no-migration
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"

reset-vendor: ## Supprime vendor dir et cache dir
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Reset des vendors server:                                                           $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	@rm -Rf server/vendor
	@rm -Rf server/var/cache/*
	@rm -Rf server/var/log/*
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Reset des vendors client:                                                           $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	@rm -Rf client/vendor
	@rm -Rf client/var/cache/*
	@rm -Rf client/var/log/*
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"

cache-clear: ## cache clear
	$(SYMFONY_CLIENT) cache:clear
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	$(SYMFONY_SERVER) cache:clear
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"

#----------------------------------------------------------------------------------------------------------------------#
#                                                  COMPOSER                                                            #
#----------------------------------------------------------------------------------------------------------------------#
##
## Composer
#################################
composer-install: ## Installe les dépendances symfony pour le backend
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Composer install Client:                                                            $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(EXEC_COMPOSER_CLIENT) install --prefer-dist --dev --no-progress --no-scripts --no-interaction;
	$(EXEC_COMPOSER_CLIENT) clear-cache;
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(COM_COLOR) Composer install Server :                                                           $(NO_COLOR)"
	@echo "$(COM_COLOR)                                                                                     $(NO_COLOR)"
	@echo "$(NO_COLOR)"
	$(EXEC_COMPOSER_SERVER) install --prefer-dist --dev --no-progress --no-scripts --no-interaction;
	$(EXEC_COMPOSER_SERVER) clear-cache;
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	@echo "$(NO_COLOR)"

composer-update: ## Mise à jour des dépendances du backend
	$(EXEC_COMPOSER_CLIENT) update -o --prefer-dist;
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"
	$(EXEC_COMPOSER_SERVER) update -o --prefer-dist;
	@echo "$(OK_COLOR) OK                                                                                   $(NO_COLOR)"

#----------------------------------------------------------------------------------------------------------------------#
#                                                      AUTRE                                                           #
#----------------------------------------------------------------------------------------------------------------------#
##
## Autres commandes
#################################
wait-db:
	@$(EXEC_PHP_SERVER) php -r "echo \"Waiting for mysql \";set_time_limit(30);for(;;){if(false!==@fsockopen('mysql',3306)){echo \"Done.\n\";die;}echo \".\";sleep(1);}"
.PHONY: wait-db