@extends('layouts.app')

@section('content_here')

{{-- Hero --}}
<div style="background: linear-gradient(135deg, #1E3A5F 0%, #2C4A6E 100%); border-radius: 20px; padding: 3rem 2.5rem; margin-bottom: 2rem; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; border-radius: 50%; background: rgba(199,160,46,0.08);"></div>
    <div style="position: absolute; bottom: -60px; left: -30px; width: 250px; height: 250px; border-radius: 50%; background: rgba(199,160,46,0.05);"></div>
    <div style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
            <div style="background: rgba(199,160,46,0.2); border-radius: 14px; width: 52px; height: 52px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #C7A02E; flex-shrink: 0;">
                <i class="fas fa-link"></i>
            </div>
            <div>
                <h1 style="color: white; font-size: 1.75rem; font-weight: 700; margin: 0; font-family: 'Playfair Display', serif;">API de Correspondance FOSA</h1>
                <p style="color: rgba(255,255,255,0.65); font-size: 0.8rem; margin: 0.15rem 0 0; letter-spacing: 0.5px;">SIDAInfo &harr; DHIS2 &nbsp;|&nbsp; Direction de la Gestion de l'Informatique Sanitaire</p>
            </div>
        </div>
        <p style="color: rgba(255,255,255,0.82); font-size: 0.975rem; line-height: 1.75; max-width: 680px; margin: 0 0 1.75rem;">
            Ce service expose une API REST permettant de résoudre les identifiants de formations sanitaires (FOSA) entre les deux systèmes d'information de santé du Burundi&nbsp;: <strong style="color: #C7A02E;">SIDAInfo</strong> et <strong style="color: #C7A02E;">DHIS2</strong>. Il est conçu pour être consommé par des intégrations automatisées (OpenFn, scripts ETL, etc.).
        </p>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="/matchings" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #C7A02E, #D4AF37); color: #1E3A5F; padding: 0.6rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.2s;">
                <i class="fas fa-table"></i> Gérer les correspondances
            </a>
            <a href="#endpoints" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.1); color: white; padding: 0.6rem 1.5rem; border-radius: 10px; font-weight: 500; font-size: 0.875rem; text-decoration: none; border: 1px solid rgba(255,255,255,0.2); transition: all 0.2s;">
                <i class="fas fa-code"></i> Voir les endpoints
            </a>
        </div>
    </div>
</div>

{{-- Stats cards --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #E8F5E9; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #2E7D32; flex-shrink: 0;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #757575; margin: 0;">Format de réponse</p>
            <p style="font-weight: 600; color: #212121; margin: 0.1rem 0 0; font-size: 0.9rem;">JSON uniforme</p>
        </div>
    </div>
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #F5F0E0; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #C7A02E; flex-shrink: 0;">
            <i class="fas fa-lock-open"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #757575; margin: 0;">Authentification</p>
            <p style="font-weight: 600; color: #212121; margin: 0.1rem 0 0; font-size: 0.9rem;">Aucune requise</p>
        </div>
    </div>
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #E3F2FD; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #1565C0; flex-shrink: 0;">
            <i class="fas fa-server"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #757575; margin: 0;">Protocole</p>
            <p style="font-weight: 600; color: #212121; margin: 0.1rem 0 0; font-size: 0.9rem;">HTTP REST / GET</p>
        </div>
    </div>
    <div class="card" style="padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: #FCE4EC; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #C62828; flex-shrink: 0;">
            <i class="fas fa-database"></i>
        </div>
        <div>
            <p style="font-size: 0.75rem; color: #757575; margin: 0;">Interface admin</p>
            <p style="font-weight: 600; color: #212121; margin: 0.1rem 0 0; font-size: 0.9rem;"><a href="/matchings" style="color: #1E3A5F; text-decoration: none;">/matchings</a></p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start;">

{{-- Left column: endpoints + examples --}}
<div>

    {{-- Modèle de données --}}
    <div class="card" style="padding: 1.75rem; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.1rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-table" style="color: #C7A02E;"></i> Modèle de données
        </h2>
        <p style="color: #616161; font-size: 0.85rem; margin: 0 0 1.25rem;">Chaque correspondance est un enregistrement de la table <code style="background: #F5F5F5; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;">matchings</code>.</p>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <thead>
                    <tr style="background: #1E3A5F;">
                        <th style="padding: 0.65rem 1rem; text-align: left; color: white; font-weight: 600; border-radius: 8px 0 0 0;">Champ</th>
                        <th style="padding: 0.65rem 1rem; text-align: left; color: white; font-weight: 600;">Type</th>
                        <th style="padding: 0.65rem 1rem; text-align: left; color: white; font-weight: 600;">Requis</th>
                        <th style="padding: 0.65rem 1rem; text-align: left; color: white; font-weight: 600; border-radius: 0 8px 0 0;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <td style="padding: 0.65rem 1rem;"><code style="background: #F5F0E0; color: #1E3A5F; padding: 2px 6px; border-radius: 4px; font-weight: 600;">sidainfo_code</code></td>
                        <td style="padding: 0.65rem 1rem; color: #424242;">string</td>
                        <td style="padding: 0.65rem 1rem;"><span class="badge-success">Oui</span></td>
                        <td style="padding: 0.65rem 1rem; color: #616161;">Identifiant unique de la FOSA dans SIDAInfo</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #EEEEEE; background: #FAFAFA;">
                        <td style="padding: 0.65rem 1rem;"><code style="background: #F5F0E0; color: #1E3A5F; padding: 2px 6px; border-radius: 4px; font-weight: 600;">dhis2_id</code></td>
                        <td style="padding: 0.65rem 1rem; color: #424242;">string</td>
                        <td style="padding: 0.65rem 1rem;"><span class="badge-success">Oui</span></td>
                        <td style="padding: 0.65rem 1rem; color: #616161;">UID de l'unité organisationnelle dans DHIS2</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <td style="padding: 0.65rem 1rem;"><code style="background: #F5F0E0; color: #1E3A5F; padding: 2px 6px; border-radius: 4px; font-weight: 600;">nom_formation</code></td>
                        <td style="padding: 0.65rem 1rem; color: #424242;">string</td>
                        <td style="padding: 0.65rem 1rem;"><span class="badge-warning">Non</span></td>
                        <td style="padding: 0.65rem 1rem; color: #616161;">Nom de la formation sanitaire</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #EEEEEE; background: #FAFAFA;">
                        <td style="padding: 0.65rem 1rem;"><code style="background: #F5F0E0; color: #1E3A5F; padding: 2px 6px; border-radius: 4px; font-weight: 600;">description</code></td>
                        <td style="padding: 0.65rem 1rem; color: #424242;">string</td>
                        <td style="padding: 0.65rem 1rem;"><span class="badge-warning">Non</span></td>
                        <td style="padding: 0.65rem 1rem; color: #616161;">Notes complémentaires</td>
                    </tr>
                    <tr>
                        <td style="padding: 0.65rem 1rem;"><code style="background: #F5F0E0; color: #1E3A5F; padding: 2px 6px; border-radius: 4px; font-weight: 600;">is_active</code></td>
                        <td style="padding: 0.65rem 1rem; color: #424242;">boolean</td>
                        <td style="padding: 0.65rem 1rem;"><span class="badge-warning">Non</span></td>
                        <td style="padding: 0.65rem 1rem; color: #616161;">Indique si la correspondance est en vigueur (défaut : <code>true</code>)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Endpoints --}}
    <div id="endpoints">

        {{-- Endpoint 1 --}}
        <div class="card" style="padding: 1.75rem; margin-bottom: 1.25rem;">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <span style="background: #E8F5E9; color: #2E7D32; padding: 3px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">GET</span>
                        <code style="font-size: 0.9rem; color: #1E3A5F; font-weight: 600;">/matching/by-code/{sidainfo_code}</code>
                    </div>
                    <p style="color: #616161; font-size: 0.875rem; margin: 0;">Retourne l'identifiant DHIS2 correspondant à un code SIDAInfo. <strong>Point d'entrée principal pour OpenFn.</strong></p>
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <p style="font-size: 0.8rem; font-weight: 600; color: #424242; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Paramètre de chemin</p>
                <div style="background: #FAFAFA; border: 1px solid #EEEEEE; border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.85rem; display: flex; gap: 1rem;">
                    <code style="color: #1E3A5F; font-weight: 600; min-width: 120px;">sidainfo_code</code>
                    <span style="color: #616161;">Le code SIDAInfo de la FOSA (ex&nbsp;: <code>FOS-12345</code>)</span>
                </div>
            </div>

            {{-- Réponses --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #2E7D32; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="fas fa-circle-check"></i> 200 — Succès
                    </p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;">{
  "success": true,
  "message": "Correspondance trouvée",
  "data": {
    "sidainfo_code": "FOS-12345",
    "dhis2_id": "AbCdEfGhIj1",
    "nom_formation": "CS Rohero"
  }
}</pre>
                </div>
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #C62828; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="fas fa-circle-xmark"></i> 404 — Non trouvé
                    </p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;">{
  "success": false,
  "message": "Code SIDAInfo non trouvé",
  "data": null
}</pre>
                </div>
            </div>

            {{-- Exemples --}}
            <p style="font-size: 0.8rem; font-weight: 600; color: #424242; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Exemples d'utilisation</p>

            {{-- Tabs --}}
            <div x-data="{ tab: 'curl' }" style="border: 1px solid #EEEEEE; border-radius: 10px; overflow: hidden;">
                <div style="display: flex; background: #F5F5F5; border-bottom: 1px solid #EEEEEE;">
                    <button onclick="switchTab(this, 'tab-1-curl')" class="tab-btn tab-active" style="padding: 0.6rem 1.25rem; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; background: none; border-bottom: 2px solid #1E3A5F; color: #1E3A5F;">cURL</button>
                    <button onclick="switchTab(this, 'tab-1-js')" class="tab-btn" style="padding: 0.6rem 1.25rem; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; color: #757575;">JavaScript</button>
                    <button onclick="switchTab(this, 'tab-1-openfn')" class="tab-btn" style="padding: 0.6rem 1.25rem; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; color: #757575;">OpenFn</button>
                    <button onclick="switchTab(this, 'tab-1-php')" class="tab-btn" style="padding: 0.6rem 1.25rem; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; background: none; border-bottom: 2px solid transparent; color: #757575;">PHP</button>
                </div>
                <div id="tab-1-curl" class="tab-panel" style="display: block;">
                    <pre style="background: #0D1117; color: #E6EDF3; padding: 1rem 1.25rem; margin: 0; font-size: 0.8rem; overflow-x: auto; line-height: 1.7;">curl -X GET \
  "https://votre-domaine.bi/matching/by-code/FOS-12345" \
  -H "Accept: application/json"</pre>
                </div>
                <div id="tab-1-js" class="tab-panel" style="display: none;">
                    <pre style="background: #0D1117; color: #E6EDF3; padding: 1rem 1.25rem; margin: 0; font-size: 0.8rem; overflow-x: auto; line-height: 1.7;"><span style="color:#FF7B72;">const</span> sidainfoCode = <span style="color:#A5D6FF;">'FOS-12345'</span>;

<span style="color:#FF7B72;">const</span> response = <span style="color:#D2A8FF;">await</span> fetch(
  <span style="color:#A5D6FF;">`https://votre-domaine.bi/matching/by-code/<span style="color:#FFA657;">${sidainfoCode}</span>`</span>
);

<span style="color:#FF7B72;">const</span> result = <span style="color:#D2A8FF;">await</span> response.<span style="color:#79C0FF;">json</span>();

<span style="color:#FF7B72;">if</span> (result.success) {
  console.<span style="color:#79C0FF;">log</span>(<span style="color:#A5D6FF;">'DHIS2 ID:'</span>, result.data.dhis2_id);
} <span style="color:#FF7B72;">else</span> {
  console.<span style="color:#79C0FF;">error</span>(<span style="color:#A5D6FF;">'Non trouvé:'</span>, result.message);
}</pre>
                </div>
                <div id="tab-1-openfn" class="tab-panel" style="display: none;">
                    <pre style="background: #0D1117; color: #E6EDF3; padding: 1rem 1.25rem; margin: 0; font-size: 0.8rem; overflow-x: auto; line-height: 1.7;"><span style="color:#8B949E;">// Dans un job OpenFn (adaptor: http)</span>
<span style="color:#D2A8FF;">get</span>(
  <span style="color:#A5D6FF;">`matching/by-code/<span style="color:#FFA657;">${state.data.sidainfo_code}</span>`</span>,
  {},
  (state) => {
    <span style="color:#FF7B72;">const</span> dhis2Id = state.data.data?.dhis2_id;
    <span style="color:#FF7B72;">return</span> { ...state, dhis2Id };
  }
);</pre>
                </div>
                <div id="tab-1-php" class="tab-panel" style="display: none;">
                    <pre style="background: #0D1117; color: #E6EDF3; padding: 1rem 1.25rem; margin: 0; font-size: 0.8rem; overflow-x: auto; line-height: 1.7;"><span style="color:#FF7B72;">$code</span> = <span style="color:#A5D6FF;">'FOS-12345'</span>;
<span style="color:#FF7B72;">$url</span>  = <span style="color:#A5D6FF;">"https://votre-domaine.bi/matching/by-code/{$code}"</span>;

<span style="color:#FF7B72;">$response</span> = <span style="color:#79C0FF;">file_get_contents</span>(<span style="color:#FF7B72;">$url</span>);
<span style="color:#FF7B72;">$result</span>   = <span style="color:#79C0FF;">json_decode</span>(<span style="color:#FF7B72;">$response</span>, <span style="color:#79C0FF;">true</span>);

<span style="color:#FF7B72;">if</span> (<span style="color:#FF7B72;">$result</span>[<span style="color:#A5D6FF;">'success'</span>]) {
    <span style="color:#FF7B72;">$dhis2Id</span> = <span style="color:#FF7B72;">$result</span>[<span style="color:#A5D6FF;">'data'</span>][<span style="color:#A5D6FF;">'dhis2_id'</span>];
}</pre>
                </div>
            </div>
        </div>

        {{-- Section : autres endpoints documentés (non encore exposés en route) --}}
        <div class="card" style="padding: 1.75rem; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.25rem;">Autres endpoints disponibles</h3>
            <p style="color: #757575; font-size: 0.82rem; margin: 0 0 1.25rem;">Ces routes peuvent être activées dans <code>routes/web.php</code> selon les besoins.</p>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">

                {{-- Row --}}
                @php
                $endpoints = [
                    ['GET',    '/api/matchings',                     'Lister toutes les correspondances (paginées)',       'Paramètres : per_page (défaut 50), search'],
                    ['POST',   '/api/matchings',                     'Créer ou mettre à jour une correspondance',         'Corps JSON : sidainfo_code*, dhis2_id*, nom_formation, description'],
                    ['PUT',    '/api/matchings/{id}',                'Mettre à jour une correspondance existante',        'Corps JSON : sidainfo_code*, dhis2_id*, nom_formation, description, is_active'],
                    ['DELETE', '/api/matchings/{id}',                'Supprimer une correspondance',                     'Suppression douce (soft delete)'],
                    ['POST',   '/api/matchings/sync',                'Synchronisation massive (batch)',                   'Corps JSON : { "matchings": [{ sidainfo_code, dhis2_id, ... }] }'],
                    ['GET',    '/matchings/export',                  'Exporter toutes les correspondances en CSV',        'Téléchargement direct, encodage UTF-8 BOM'],
                    ['POST',   '/matchings/import',                  'Importer des correspondances depuis un CSV',       'Fichier CSV avec colonnes : sidainfo_code, dhis2_id, nom_formation (optionnel)'],
                ];
                $colors = ['GET'=>['#E8F5E9','#2E7D32'], 'POST'=>['#E3F2FD','#1565C0'], 'PUT'=>['#FFF8E1','#F57C00'], 'DELETE'=>['#FCE4EC','#C62828']];
                @endphp

                @foreach($endpoints as $ep)
                @php [$bg, $fg] = $colors[$ep[0]]; @endphp
                <div style="display: flex; gap: 1rem; align-items: flex-start; padding: 0.875rem 1rem; border: 1px solid #EEEEEE; border-radius: 10px; background: #FAFAFA;">
                    <span style="background: {{ $bg }}; color: {{ $fg }}; padding: 2px 8px; border-radius: 5px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; white-space: nowrap; margin-top: 2px;">{{ $ep[0] }}</span>
                    <div>
                        <code style="font-size: 0.85rem; color: #1E3A5F; font-weight: 600;">{{ $ep[1] }}</code>
                        <p style="font-size: 0.82rem; color: #424242; margin: 0.2rem 0 0;">{{ $ep[2] }}</p>
                        <p style="font-size: 0.78rem; color: #757575; margin: 0.15rem 0 0;"><i class="fas fa-circle-info" style="font-size: 0.7rem;"></i> {{ $ep[3] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Sync example --}}
        <div class="card" style="padding: 1.75rem; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-rotate" style="color: #C7A02E;"></i> Synchronisation massive (sync)
            </h3>
            <p style="color: #616161; font-size: 0.85rem; margin: 0 0 1rem;">Utile pour initialiser ou resynchroniser l'ensemble des correspondances en un seul appel.</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #1565C0; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem;">Corps de la requête</p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;">{
  "matchings": [
    {
      "sidainfo_code": "FOS-001",
      "dhis2_id": "AbCdEfGhIj1",
      "nom_formation": "CS Rohero"
    },
    {
      "sidainfo_code": "FOS-002",
      "dhis2_id": "KlMnOpQrSt2",
      "nom_formation": "HP Kamenge"
    }
  ]
}</pre>
                </div>
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #2E7D32; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem;">Réponse 200</p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;">{
  "success": true,
  "message": "Synchronisation terminée",
  "synced_count": 2,
  "errors_count": 0,
  "errors": []
}</pre>
                </div>
            </div>
        </div>

        {{-- Import CSV --}}
        <div class="card" style="padding: 1.75rem; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-file-csv" style="color: #C7A02E;"></i> Import CSV
            </h3>
            <p style="color: #616161; font-size: 0.85rem; margin: 0 0 1rem;">Importer des correspondances en masse depuis un fichier CSV via l'interface ou l'API.</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #424242; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem;">Format du fichier CSV</p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;"><span style="color: #C7A02E;">sidainfo_code</span>,<span style="color: #C7A02E;">dhis2_id</span>,<span style="color: #8B949E;">nom_formation</span>,<span style="color: #8B949E;">description</span>
FOS-001,AbCdEfGhIj1,CS Rohero,Centre de santé
FOS-002,KlMnOpQrSt2,HP Kamenge,Hôpital provincial</pre>
                    <p style="font-size: 0.78rem; color: #757575; margin: 0.5rem 0 0;"><i class="fas fa-circle-info"></i> Colonnes obligatoires : <code>sidainfo_code</code>, <code>dhis2_id</code>.</p>
                </div>
                <div>
                    <p style="font-size: 0.75rem; font-weight: 600; color: #424242; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.4rem;">Requête cURL</p>
                    <pre style="background: #0D1117; color: #E6EDF3; border-radius: 10px; padding: 1rem; font-size: 0.78rem; margin: 0; overflow-x: auto; line-height: 1.6;">curl -X POST \
  "https://votre-domaine.bi/matchings/import" \
  -H "Accept: application/json" \
  -F "file=@correspondances.csv"</pre>
                </div>
            </div>
        </div>

    </div>{{-- /endpoints --}}
</div>

{{-- Right sidebar --}}
<div style="position: sticky; top: 80px; display: flex; flex-direction: column; gap: 1rem;">

    {{-- Test rapide --}}
    <div class="card" style="padding: 1.5rem;">
        <h3 style="font-size: 0.95rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-flask" style="color: #C7A02E; font-size: 0.875rem;"></i> Test rapide
        </h3>
        <p style="color: #757575; font-size: 0.8rem; margin: 0 0 1rem;">Entrez un code SIDAInfo pour tester l'API directement.</p>
        <div id="try-form">
            <input type="text" id="try-code" placeholder="ex: FOS-12345"
                style="width: 100%; padding: 0.6rem 0.875rem; border: 1.5px solid #E0E0E0; border-radius: 8px; font-size: 0.85rem; box-sizing: border-box; outline: none; margin-bottom: 0.6rem; font-family: monospace; color: #212121;"
                onfocus="this.style.borderColor='#1E3A5F'" onblur="this.style.borderColor='#E0E0E0'">
            <button onclick="tryApi()" style="width: 100%; background: linear-gradient(135deg, #1E3A5F, #2C4A6E); color: white; border: none; padding: 0.6rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i class="fas fa-paper-plane"></i> Envoyer la requête
            </button>
        </div>
        <div id="try-result" style="display: none; margin-top: 0.75rem;">
            <p style="font-size: 0.75rem; font-weight: 600; color: #424242; margin: 0 0 0.4rem; text-transform: uppercase; letter-spacing: 0.5px;">Réponse</p>
            <pre id="try-output" style="background: #0D1117; color: #E6EDF3; border-radius: 8px; padding: 0.875rem; font-size: 0.75rem; margin: 0; overflow-x: auto; line-height: 1.6; white-space: pre-wrap; word-break: break-all;"></pre>
        </div>
    </div>

    {{-- Codes HTTP --}}
    <div class="card" style="padding: 1.5rem;">
        <h3 style="font-size: 0.95rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-triangle-exclamation" style="color: #C7A02E; font-size: 0.875rem;"></i> Codes de retour HTTP
        </h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.82rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 8px; background: #E8F5E9;">
                <code style="color: #2E7D32; font-weight: 700; min-width: 36px;">200</code>
                <span style="color: #424242;">Correspondance trouvée</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 8px; background: #E3F2FD;">
                <code style="color: #1565C0; font-weight: 700; min-width: 36px;">201</code>
                <span style="color: #424242;">Créée avec succès (POST)</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 8px; background: #FCE4EC;">
                <code style="color: #C62828; font-weight: 700; min-width: 36px;">404</code>
                <span style="color: #424242;">Code ou ID introuvable</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 8px; background: #FFF8E1;">
                <code style="color: #F57C00; font-weight: 700; min-width: 36px;">422</code>
                <span style="color: #424242;">Données invalides</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 8px; background: #F5F5F5;">
                <code style="color: #616161; font-weight: 700; min-width: 36px;">500</code>
                <span style="color: #424242;">Erreur serveur interne</span>
            </div>
        </div>
    </div>

    {{-- Structure de réponse --}}
    <div class="card" style="padding: 1.5rem;">
        <h3 style="font-size: 0.95rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-cubes" style="color: #C7A02E; font-size: 0.875rem;"></i> Structure de réponse
        </h3>
        <p style="color: #757575; font-size: 0.8rem; margin: 0 0 0.75rem;">Toutes les réponses JSON partagent la même enveloppe.</p>
        <pre style="background: #0D1117; color: #E6EDF3; border-radius: 8px; padding: 0.875rem; font-size: 0.76rem; margin: 0; overflow-x: auto; line-height: 1.7;">{
  <span style="color:#79C0FF;">"success"</span>: <span style="color:#FFA657;">boolean</span>,
  <span style="color:#79C0FF;">"message"</span>: <span style="color:#FFA657;">string</span>,
  <span style="color:#79C0FF;">"data"</span>:    <span style="color:#FFA657;">object | null</span>
}</pre>
    </div>

    {{-- Liens utiles --}}
    <div class="card" style="padding: 1.5rem;">
        <h3 style="font-size: 0.95rem; font-weight: 700; color: #1E3A5F; margin: 0 0 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-arrow-up-right-from-square" style="color: #C7A02E; font-size: 0.875rem;"></i> Liens utiles
        </h3>
        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
            <a href="/matchings" class="offre-link"><i class="fas fa-table"></i> Interface d'administration</a>
            <a href="/matchings/create" class="offre-link"><i class="fas fa-plus"></i> Ajouter une correspondance</a>
            <a href="/matchings/export" class="offre-link"><i class="fas fa-download"></i> Exporter en CSV</a>
            <a href="/matchings?search=" class="offre-link"><i class="fas fa-magnifying-glass"></i> Rechercher une FOSA</a>
        </div>
    </div>

</div>{{-- /sidebar --}}
</div>{{-- /grid --}}

<style>
    .tab-btn { transition: all 0.2s; }
    .tab-btn.tab-active { border-bottom-color: #1E3A5F !important; color: #1E3A5F !important; font-weight: 600 !important; }
    @media (max-width: 900px) {
        div[style*="grid-template-columns: 1fr 340px"] { grid-template-columns: 1fr !important; }
        div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        div[style*="position: sticky"] { position: static !important; }
    }
</style>

<script>
function switchTab(btn, panelId) {
    const wrapper = btn.closest('[style*="overflow: hidden"]');
    wrapper.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('tab-active');
        b.style.borderBottomColor = 'transparent';
        b.style.color = '#757575';
        b.style.fontWeight = '500';
    });
    wrapper.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
    btn.classList.add('tab-active');
    btn.style.borderBottomColor = '#1E3A5F';
    btn.style.color = '#1E3A5F';
    btn.style.fontWeight = '600';
    document.getElementById(panelId).style.display = 'block';
}

async function tryApi() {
    const code = document.getElementById('try-code').value.trim();
    const resultBox = document.getElementById('try-result');
    const output = document.getElementById('try-output');
    if (!code) {
        document.getElementById('try-code').focus();
        return;
    }
    resultBox.style.display = 'block';
    output.textContent = 'Chargement...';
    try {
        const resp = await fetch(`/matching/by-code/${encodeURIComponent(code)}`, {
            headers: { 'Accept': 'application/json' }
        });
        const json = await resp.json();
        output.textContent = JSON.stringify(json, null, 2);
        output.style.color = json.success ? '#7EE787' : '#FF7B72';
    } catch (e) {
        output.textContent = 'Erreur réseau : ' + e.message;
        output.style.color = '#FF7B72';
    }
}

document.getElementById('try-code').addEventListener('keydown', e => {
    if (e.key === 'Enter') tryApi();
});
</script>

@endsection
