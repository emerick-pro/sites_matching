{{-- resources/views/matchings/index.blade.php --}}
@extends('layouts.app')



@section('content_here')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- En-tête --}}
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8" style="border-left-color: #CE1126;">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-exchange-alt text-2xl" style="color: #CE1126;"></i>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                                Table de correspondance SIDAInfo ↔ DHIS2
                            </h1>
                        </div>
                        <p class="text-gray-600">
                            Gestion des correspondances entre les codes des formations sanitaires
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-white" 
                                style="background-color: #1EB53A;"
                                onclick="openImportModal()">
                            <i class="fas fa-upload"></i> Importer Excel
                        </button>
                        <a href="{{ route('matchings.export') }}" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-white" 
                           style="background-color: #2563EB;">
                            <i class="fas fa-download"></i> Exporter
                        </a>
                        <a href="{{ route('matchings.create') }}" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-white" 
                           style="background-color: #CE1126;">
                            <i class="fas fa-plus"></i> Nouvelle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte de recherche --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4" id="searchForm">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" id="searchInput" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent" 
                               placeholder="Rechercher par code SIDAInfo, DHIS2 ID ou nom de formation..." 
                               value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div>
                    <button type="submit" class="px-6 py-3 rounded-lg transition text-white w-full md:w-auto" style="background-color: #CE1126;">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    @if($search ?? false)
                        <a href="{{ route('matchings.index') }}" class="px-6 py-3 rounded-lg transition text-white inline-block text-center mt-2 md:mt-0 md:ml-2" style="background-color: #6B7280;">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        {{-- Tableau des correspondances --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead style="background: linear-gradient(135deg, #CE1126 0%, #A81020 100%);">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Code SIDAInfo</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">DHIS2 ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Nom formation</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Date création</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matchingsTableBody">
                        @include('matchings.partials.table_rows', ['matchings' => $matchings])
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
                {{ $matchings->appends(['search' => $search ?? ''])->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal d'import Excel --}}
<div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 overflow-y-auto" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border shadow-lg rounded-lg bg-white w-full max-w-md">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-file-excel" style="color: #1EB53A;"></i> Importer des correspondances
            </h3>
            <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('matchings.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div class="py-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fichier CSV</label>
                <input type="file" name="file" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required accept=".csv,.txt">
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Format requis: CSV avec séparateur virgule<br>
                    Colonnes: <code>sidainfo_code</code>, <code>dhis2_id</code>, <code>nom_formation</code> (optionnel)
                </p>
            </div>
           
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 text-white rounded-lg transition" style="background-color: #1EB53A;">
                    <i class="fas fa-upload"></i> Importer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal de confirmation de suppression --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 overflow-y-auto" style="display: none;">
    <div class="relative top-40 mx-auto p-5 border shadow-lg rounded-lg bg-white w-full max-w-md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmer la suppression</h3>
            <p class="text-sm text-gray-500 mb-4">
                Êtes-vous sûr de vouloir supprimer la correspondance pour le code : 
                <strong id="deleteCode" class="text-red-600"></strong> ?
            </p>
            <p class="text-xs text-gray-400 mb-4">Cette action est irréversible.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Annuler
                </button>
                <button id="confirmDeleteBtn" class="px-4 py-2 text-white rounded-lg transition" style="background-color: #CE1126;">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Notification Toast --}}
<div id="toast" class="fixed bottom-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden items-center gap-2" style="display: none;">
    <i id="toastIcon" class="fas"></i>
    <span id="toastMessage"></span>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

// Configuration Axios
let csrfToken = null;

// Essayer d'abord avec content
const metaContent = document.querySelector('meta[name="csrf-token"][content]');
if (metaContent) {
    csrfToken = metaContent.getAttribute('content');
}

// Sinon essayer avec value
if (!csrfToken) {
    const metaValue = document.querySelector('meta[name="csrf-token"][value]');
    if (metaValue) {
        csrfToken = metaValue.getAttribute('value');
    }
}

// Si toujours pas, essayer avec le token depuis les cookies
if (!csrfToken) {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'XSRF-TOKEN') {
            csrfToken = decodeURIComponent(value);
            break;
        }
    }
}

// Configurer Axios
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
} else {
    console.warn('CSRF token not found');
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Pour les requêtes POST avec Axios, configurer aussi le token dans les params
axios.interceptors.request.use(config => {
    if (csrfToken) {
        config.headers['X-CSRF-TOKEN'] = csrfToken;
    }
    return config;
});

//---end config tiken


let deleteId = null;

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toastIcon');
    const messageSpan = document.getElementById('toastMessage');
    
    toast.style.backgroundColor = type === 'success' ? '#1EB53A' : '#CE1126';
    icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
    messageSpan.textContent = message;
    
    toast.style.display = 'flex';
    
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}

function openDeleteModal(id, code) {
    deleteId = id;
    document.getElementById('deleteCode').textContent = code;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    deleteId = null;
    document.getElementById('deleteModal').style.display = 'none';
}

// Suppression avec Axios
document.getElementById('confirmDeleteBtn')?.addEventListener('click', async function() {
    if (!deleteId) return;
    
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Suppression...';
    btn.disabled = true;
    
    try {
        const response = await axios.delete(`/sidhis2/matchings/${deleteId}`);
        
        if (response.data.success) {
            showToast(response.data.message, 'success');
            closeDeleteModal();
            
            // Supprimer la ligne du tableau
            const row = document.querySelector(`tr[data-id="${deleteId}"]`);
            if (row) {
                row.remove();
            }
            
            // Recharger le tableau si plus de lignes
            const remainingRows = document.querySelectorAll('#matchingsTableBody tr').length;
            if (remainingRows === 0) {
                location.reload();
            }
        } else {
            showToast(response.data.message || 'Erreur lors de la suppression', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        const message = error.response?.data?.message || 'Erreur lors de la suppression';
        showToast(message, 'error');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
        deleteId = null;
    }
});

// Fermer la modale en cliquant en dehors
window.onclick = function(event) {
    const importModal = document.getElementById('importModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === importModal) {
        closeImportModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}

// Import avec Axios
document.getElementById('importForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Import...';
    submitBtn.disabled = true;
    
    try {
        const response = await axios.post(this.action, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        
        if (response.data.success) {
            showToast(response.data.message, 'success');
            closeImportModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(response.data.message || 'Erreur lors de l\'import', 'error');
        }
    } catch (error) {
        console.error('Erreur:', error);
        const message = error.response?.data?.message || 'Erreur lors de l\'import';
        showToast(message, 'error');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

function openImportModal() {
    document.getElementById('importModal').style.display = 'block';
}

function closeImportModal() {
    document.getElementById('importModal').style.display = 'none';
    document.getElementById('importForm')?.reset();
}

function copyToClipboard(sidainfoCode, dhis2Id) {
    const text = sidainfoCode + ' → ' + dhis2Id;
    navigator.clipboard.writeText(text).then(() => {
        showToast('Copié : ' + text, 'success');
    });
}

// Recherche avec AJAX
let searchTimeout;
document.getElementById('searchInput')?.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const search = this.value;
        const url = new URL(window.location.href);
        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }
        window.location.href = url.toString();
    }, 500);
});

// Afficher les messages flash
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
});
</script>

<style>
/* Animation de suppression */
@keyframes fadeOut {
    from { opacity: 1; transform: translateX(0); }
    to { opacity: 0; transform: translateX(-20px); }
}

tr.deleting {
    animation: fadeOut 0.3s ease forwards;
}

/* Style pour la pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: block;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    color: #CE1126;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background-color: #FEE2E2;
}

.pagination .active .page-link {
    background-color: #CE1126;
    color: white;
}

.pagination .disabled .page-link {
    color: #9CA3AF;
    pointer-events: none;
}
</style>
@endsection