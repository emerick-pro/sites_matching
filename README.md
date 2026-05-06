# SIDAInfo Matching

Laravel 11 application that manages the mapping between **SIDAInfo facility codes** and **DHIS2 organisation unit IDs**. It exposes a web UI for CRUD operations and a REST API endpoint consumed by OpenFn.

---

## Stack

| Component   | Detail                        |
|-------------|-------------------------------|
| PHP         | 8.2                           |
| Framework   | Laravel 11                    |
| Database    | MySQL 8.0                     |
| Web server  | Apache (mod_rewrite)          |
| Runtime     | Docker                        |

---

## Quick start

```bash
# First-time setup (build image, start containers)
make install

# Import the initial dataset
make import
```

| Service      | URL / address                                        |
|--------------|------------------------------------------------------|
| Application  | http://localhost:8077                                |
| phpMyAdmin   | http://localhost:8078                                |
| MySQL        | `localhost:3307` — user `matching_user` / `matching_pass` |

---

## Make targets

```
Installation & startup
  install         First install: build + full startup
  build           Rebuild image without cache
  start           Start containers (no rebuild)
  stop            Stop containers
  restart         Restart containers

Logs & monitoring
  logs            Tail all service logs
  logs-app        Tail app container only
  logs-db         Tail db container only
  status          Show container status

Shells & consoles
  shell           Bash shell in app container
  db-shell        MySQL shell in db container
  tinker          Laravel Tinker

Database
  migrate         Run Laravel migrations
  fresh           Reset DB, re-run migrations, re-import SQL dump
  import          Import database/matchings.sql into the DB

Laravel utilities
  cache-clear     Clear all Laravel caches
  routes          List all routes
  test            Run PHPUnit tests

Cleanup
  clean           Stop and remove containers (keeps volumes)
  nuke            Remove containers + volumes (data loss!)
```

---

## API

### GET `/matching/by-code/{sidainfo_code}`

Returns the DHIS2 ID for a given SIDAInfo facility code.

**Success (200)**
```json
{
  "success": true,
  "message": "Correspondance trouvée",
  "data": {
    "sidainfo_code": "FAC001",
    "dhis2_id": "abc123xyz",
    "nom_formation": "Hôpital Central"
  }
}
```

**Not found (404)**
```json
{
  "success": false,
  "message": "Code SIDAInfo non trouvé",
  "data": null
}
```

---

## Web UI

| Route                  | Description               |
|------------------------|---------------------------|
| `GET /matchings`       | List all matchings        |
| `GET /matchings/create`| New matching form         |
| `POST /matchings`      | Create matching           |
| `GET /matchings/{id}/edit` | Edit form             |
| `PUT /matchings/{id}`  | Update matching           |
| `DELETE /matchings/{id}` | Delete matching         |
| `POST /matchings/import` | Import from CSV         |
| `GET /matchings/export`  | Export to CSV           |

### CSV import format

The file must contain at minimum the columns `sidainfo_code` and `dhis2_id`. Optional columns: `nom_formation`, `description`.

---

## Environment

Copy `.env.docker` and adjust values for local development. Key variables:

```
DB_HOST=db
DB_DATABASE=matching_db
DB_USERNAME=matching_user
DB_PASSWORD=matching_pass
```

---

## License

MIT
