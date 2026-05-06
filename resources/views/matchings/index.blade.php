{{-- resources/views/matchings/index.blade.php --}}
@extends('layouts.app')

@section('content_here')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        
        {{-- En-tête avec bande distincte --}}
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-exchange-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white tracking-tight">
                                    Table de correspondance
                                </h1>
                                <p class="text-blue-100 text-sm mt-0.5">
                                    SIDAInfo ↔ DHIS2
                                </p>
                            </div>
                        </div>
                        <p class="text-blue-100 text-sm ml-14">
                            Gestion des correspondances entre les codes des formations sanitaires
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-sm" 
                                onclick="openImportModal()">
                            <i class="fas fa-upload"></i> Importer
                        </button>
                        <a href="{{ route('matchings.export') }}" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-sm">
                            <i class="fas fa-download"></i> Exporter
                        </a>
                        <a href="{{ route('matchings.create') }}" class="px-4 py-2 rounded-lg transition flex items-center gap-2 text-sm font-semibold bg-amber-500 hover:bg-amber-600 text-white shadow-lg shadow-amber-500/30">
                            <i class="fas fa-plus"></i> Nouvelle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte de recherche --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-3" id="searchForm">
                <div class="flex-1">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" id="searchInput" class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-gray-50" 
                               placeholder="Rechercher par code SIDAInfo, DHIS2 ID ou nom de formation..." 
                               value="{{ $search ?? '' }}">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-lg transition text-white text-sm font-medium bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-md">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    @if($search ?? false)
                        <a href="{{ route('matchings.index') }}" class="px-5 py-2.5 rounded-lg transition text-gray-600 bg-gray-100 hover:bg-gray-200 text-sm font-medium">
                            <i class="fas fa-times"></i> Effacer
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        {{-- Tableau des correspondances --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code SIDAInfo</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">DHIS2 ID</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom formation</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date création</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="matchingsTableBody" class="divide-y divide-gray-50">
                        @include('matchings.partials.table_rows', ['matchings' => $matchings])
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50" id="paginationContainer">
                {{ $matchings->appends(['search' => $search ?? ''])->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal d'import Excel --}}
<div id="importModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 overflow-y-auto" style="display: none;">
    <div class="relative top-20 mx-auto p-6 shadow-xl rounded-xl bg-white w-full max-w-md">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-file-excel text-green-600"></i> Importer des correspondances
            </h3>
            <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="{{ route('matchings.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div class="py-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fichier CSV</label>
                <input type="file" name="file" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50" required accept=".csv,.txt">
                <p class="text-xs text-gray-500 mt-3">
                    <i class="fas fa-info-circle"></i> Format requis: CSV avec séparateur virgule<br>
                    Colonnes: <code class="text-xs bg-gray-100 px-1 rounded">sidainfo_code</code>, <code class="text-xs bg-gray-100 px-1 rounded">dhis2_id</code>, <code class="text-xs bg-gray-100 px-1 rounded">nom_formation</code> (optionnel)
                </p>
            </div>
           
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 text-white rounded-lg transition text-sm font-medium bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                    <i class="fas fa-upload"></i> Importer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal de confirmation de suppression --}}
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 overflow-y-auto" style="display: none;">
    <div class="relative top-40 mx-auto p-6 shadow-xl rounded-xl bg-white w-full max-w-md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Confirmer la suppression</h3>
            <p class="text-sm text-gray-500 mb-3">
                Êtes-vous sûr de vouloir supprimer la correspondance pour le code : 
                <strong id="deleteCode" class="text-red-600"></strong> ?
            </p>
            <p class="text-xs text-gray-400 mb-5">Cette action est irréversible.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Annuler
                </button>
                <button id="confirmDeleteBtn" class="px-4 py-2 text-white rounded-lg transition text-sm font-medium bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Notification Toast --}}
<div id="toast" class="fixed bottom-4 right-4 text-white px-5 py-3 rounded-lg shadow-lg z-50 hidden items-center gap-2 text-sm" style="display: none;">
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

//---end config token

let deleteId = null;

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const icon = document.getElementById('toastIcon');
    const messageSpan = document.getElementById('toastMessage');
    
    toast.style.backgroundColor = type === 'success' ? '#10B981' : '#EF4444';
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
     
	
		const response = await axios.delete("{{ route('matchings.destroy', '') }}/" + deleteId);
        
        if (response.data.success) {
			alert('OK done');
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

/* Style élégant pour la pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.4rem;
    flex-wrap: wrap;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: block;
    padding: 0.5rem 0.85rem;
    border-radius: 0.5rem;
    color: #4B5563;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 0.85rem;
    font-weight: 500;
    background-color: white;
    border: 1px solid #E5E7EB;
}

.pagination .page-link:hover {
    background-color: #EFF6FF;
    border-color: #93C5FD;
    color: #1D4ED8;
    transform: translateY(-1px);
}

.pagination .active .page-link {
    background: linear-gradient(135deg, #2563EB, #1D4ED8);
    color: white;
    border-color: #2563EB;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

.pagination .disabled .page-link {
    color: #9CA3AF;
    pointer-events: none;
    background-color: #F9FAFB;
    border-color: #E5E7EB;
}

/* Lignes du tableau alternées */
tbody tr:nth-child(even) {
    background-color: #F9FAFB;
}

tbody tr:hover {
    background-color: #EFF6FF;
    transition: all 0.2s ease;
}

/* Boutons d'action */
.action-btn {
    transition: all 0.2s;
}

.action-btn:hover {
    transform: translateY(-2px);
}

/* Style pour les badges */
.badge-active {
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-inactive {
    background: linear-gradient(135deg, #6B7280, #4B5563);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* Card hover effect */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}
</style>
@endsection