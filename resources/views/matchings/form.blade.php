{{-- resources/views/matchings/form.blade.php --}}
@extends('layouts.app')

@section('content_here')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        
        {{-- En-tête --}}
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-8" style="border-left-color: #CE1126;">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas {{ isset($matching) ? 'fa-edit' : 'fa-plus' }} text-2xl" style="color: #CE1126;"></i>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        {{ isset($matching) ? 'Modifier' : 'Ajouter' }} une correspondance
                    </h1>
                </div>
                <p class="text-gray-600">
                    {{ isset($matching) ? 'Modifiez les informations de la correspondance' : 'Ajoutez une nouvelle correspondance entre SIDAInfo et DHIS2' }}
                </p>
            </div>
        </div>
        
        {{-- Formulaire --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ isset($matching) ? route('matchings.update', $matching->id) : route('matchings.store') }}" 
                  method="POST">
                @csrf
                @if(isset($matching))
                    @method('PUT')
                @endif
                
                <div class="p-6 space-y-6">
                    
                    {{-- Code SIDAInfo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Code SIDAInfo <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="sidainfo_code" 
                               value="{{ old('sidainfo_code', $matching->sidainfo_code ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent @error('sidainfo_code') border-red-500 @enderror"
                               placeholder="Ex: CS_COCODY, HOP_YOPOUGON"
                               required>
                        @error('sidainfo_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle"></i> Code unique de la formation dans SIDAInfo
                        </p>
                    </div>
                    
                    {{-- DHIS2 ID --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            DHIS2 Organisation Unit ID <span class="text-red-600">*</span>
                        </label>
                        <input type="text" 
                               name="dhis2_id" 
                               value="{{ old('dhis2_id', $matching->dhis2_id ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent @error('dhis2_id') border-red-500 @enderror"
                               placeholder="Ex: abc123def456"
                               required>
                        @error('dhis2_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle"></i> UID DHIS2 de l'unité d'organisation
                        </p>
                    </div>
                    
                    {{-- Nom de la formation --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de la formation sanitaire
                        </label>
                        <input type="text" 
                               name="nom_formation" 
                               value="{{ old('nom_formation', $matching->nom_formation ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                               placeholder="Ex: Centre de Santé de Cocody">
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle"></i> Nom complet de la formation (optionnel)
                        </p>
                    </div>
                    
                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Informations complémentaires...">{{ old('description', $matching->description ?? '') }}</textarea>
                    </div>
                    
                    {{-- Statut Actif/Inactif --}}
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="font-medium text-gray-700">Statut</label>
                            <p class="text-sm text-gray-500">Activer ou désactiver cette correspondance</p>
                        </div>
                        <div class="relative inline-block w-12 mr-2 align-middle select-none">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ old('is_active', $matching->is_active ?? true) ? 'checked' : '' }}
                                   class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                            <label for="is_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>
                </div>
                
                {{-- Boutons d'action --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('matchings.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-white rounded-lg transition flex items-center gap-2" 
                            style="background-color: #CE1126;">
                        <i class="fas fa-save"></i> 
                        {{ isset($matching) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Style pour le toggle switch */
.toggle-checkbox:checked {
    right: 0;
    border-color: #1EB53A;
}

.toggle-checkbox:checked + .toggle-label {
    background-color: #1EB53A;
}

.toggle-checkbox {
    right: 0;
    transition: all 0.3s ease;
}

.toggle-checkbox:not(:checked) {
    right: 0;
    transform: translateX(-50%);
}

.toggle-label {
    transition: background-color 0.3s ease;
}
</style>

<script>
// Pour corriger le toggle switch
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.toggle-checkbox');
    if (toggle && !toggle.checked) {
        toggle.style.right = 'auto';
        toggle.style.left = '0';
    }
    
    toggle?.addEventListener('change', function() {
        if (this.checked) {
            this.style.right = '0';
            this.style.left = 'auto';
        } else {
            this.style.right = 'auto';
            this.style.left = '0';
        }
    });
});
</script>
@endsection