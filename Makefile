# ─────────────────────────────────────────────
#  SIDAInfo Matching — Docker helper
#  App  : http://localhost:8077
#  PMA  : http://localhost:8078
#  MySQL: localhost:3307
# ─────────────────────────────────────────────

.DEFAULT_GOAL := help
COMPOSE        = docker compose

# ── Couleurs ──────────────────────────────────
BOLD  = \033[1m
RESET = \033[0m
GREEN = \033[0;32m
CYAN  = \033[0;36m
GRAY  = \033[0;90m

.PHONY: help install start stop restart build logs shell db-shell \
        tinker migrate fresh import status clean nuke open

## ── Installation & démarrage ─────────────────

install: ## Première installation : build + démarrage complet
	@echo "$(BOLD)$(CYAN)==> Build de l'image Docker...$(RESET)"
	$(COMPOSE) build --no-cache
	@echo "$(BOLD)$(CYAN)==> Démarrage des services...$(RESET)"
	$(COMPOSE) up -d
	@echo ""
	@echo "$(BOLD)$(GREEN)✔ Installation terminée !$(RESET)"
	@echo ""
	@echo "  Application : http://localhost:8077"
	@echo "  phpMyAdmin  : http://localhost:8078"
	@echo "  MySQL       : localhost:3307  (user: matching_user / pass: matching_pass)"
	@echo ""
	@echo "$(GRAY)Suivez les logs avec : make logs$(RESET)"

build: ## Rebuild l'image sans cache
	$(COMPOSE) build --no-cache

start: ## Démarrer les conteneurs (sans rebuild)
	$(COMPOSE) up -d
	@echo "$(GREEN)✔ Services démarrés$(RESET) — http://localhost:8077"

stop: ## Arrêter les conteneurs
	$(COMPOSE) stop
	@echo "$(GREEN)✔ Services arrêtés$(RESET)"

restart: ## Redémarrer les conteneurs
	$(COMPOSE) restart
	@echo "$(GREEN)✔ Services redémarrés$(RESET)"

## ── Logs & monitoring ────────────────────────

logs: ## Afficher les logs en temps réel (tous les services)
	$(COMPOSE) logs -f

logs-app: ## Logs du conteneur application uniquement
	$(COMPOSE) logs -f app

logs-db: ## Logs du conteneur MySQL uniquement
	$(COMPOSE) logs -f db

status: ## État des conteneurs
	$(COMPOSE) ps

## ── Shells & consoles ────────────────────────

shell: ## Ouvrir un shell bash dans le conteneur app
	$(COMPOSE) exec app bash

db-shell: ## Ouvrir mysql dans le conteneur db
	$(COMPOSE) exec db mysql -u matching_user -pmatching_pass matching_db

tinker: ## Lancer Laravel Tinker
	$(COMPOSE) exec app php artisan tinker

## ── Base de données ──────────────────────────

migrate: ## Lancer les migrations Laravel
	$(COMPOSE) exec app php artisan migrate --force

fresh: ## Réinitialiser la BDD et relancer les migrations + import
	@echo "$(BOLD)Réinitialisation de la base de données...$(RESET)"
	$(COMPOSE) exec app php artisan migrate:fresh --force
	$(COMPOSE) exec app bash -c \
		'mysql -h$$DB_HOST -u$$DB_USERNAME -p$$DB_PASSWORD $$DB_DATABASE < database/matchings.sql'
	@echo "$(GREEN)✔ Base réinitialisée et données importées$(RESET)"

import: ## Importer database/matchings.sql dans la BDD (force)
	$(COMPOSE) exec app bash -c \
		'mysql -h$$DB_HOST -u$$DB_USERNAME -p$$DB_PASSWORD $$DB_DATABASE < database/matchings.sql'
	@echo "$(GREEN)✔ Import terminé$(RESET)"

## ── Utilitaires Laravel ──────────────────────

cache-clear: ## Vider tous les caches Laravel
	$(COMPOSE) exec app php artisan optimize:clear

routes: ## Lister toutes les routes
	$(COMPOSE) exec app php artisan route:list

test: ## Lancer les tests PHPUnit
	$(COMPOSE) exec app php artisan test

## ── Nettoyage ────────────────────────────────

clean: ## Arrêter et supprimer les conteneurs (conserve les volumes)
	$(COMPOSE) down
	@echo "$(GREEN)✔ Conteneurs supprimés$(RESET)"

nuke: ## ⚠ Tout supprimer : conteneurs + volumes (perte des données BDD)
	@echo "$(BOLD)⚠ Suppression de tous les conteneurs et volumes...$(RESET)"
	$(COMPOSE) down -v --remove-orphans
	@echo "$(GREEN)✔ Tout supprimé$(RESET)"

## ── Raccourcis ───────────────────────────────

open: ## Ouvrir l'application dans le navigateur (macOS)
	open http://localhost:8077

open-pma: ## Ouvrir phpMyAdmin dans le navigateur (macOS)
	open http://localhost:8078

## ── Aide ─────────────────────────────────────

help: ## Afficher cette aide
	@echo ""
	@echo "$(BOLD)SIDAInfo Matching — commandes disponibles$(RESET)"
	@echo ""
	@awk 'BEGIN {FS = ":.*##"} \
		/^[a-zA-Z_-]+:.*?##/ { printf "  $(CYAN)%-15s$(RESET) %s\n", $$1, $$2 } \
		/^## / { printf "\n$(BOLD)%s$(RESET)\n", substr($$0, 4) }' $(MAKEFILE_LIST)
	@echo ""
