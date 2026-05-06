{{-- resources/views/matchings/partials/table_rows.blade.php --}}
@forelse($matchings as $matching)
<tr data-id="{{ $matching->id }}" class="hover:bg-gray-50 transition duration-150">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $matching->id }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
        <code class="px-2 py-1 rounded text-sm font-mono" style="background-color: #FEE2E2; color: #CE1126;">{{ $matching->sidainfo_code }}</code>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <code class="px-2 py-1 rounded text-sm font-mono" style="background-color: #DCFCE7; color: #166534;">{{ $matching->dhis2_id }}</code>
    </td>
    <td class="px-6 py-4 text-sm text-gray-700">{{ $matching->nom_formation ?? '-' }}</td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($matching->is_active)
            <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: #DCFCE7; color: #166534;">
                <i class="fas fa-check-circle"></i> Actif
            </span>
        @else
            <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: #FEE2E2; color: #991B1B;">
                <i class="fas fa-times-circle"></i> Inactif
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $matching->created_at->format('d/m/Y H:i') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm">
        <div class="flex gap-3">
            <a href="{{ route('matchings.edit', $matching->id) }}" 
               class="text-blue-600 hover:text-blue-800 transition" title="Modifier">
                <i class="fas fa-edit text-lg"></i>
            </a>
            <button type="button" class="text-red-600 hover:text-red-800 transition" 
                    onclick="openDeleteModal({{ $matching->id }}, '{{ $matching->sidainfo_code }}')" title="Supprimer">
                <i class="fas fa-trash text-lg"></i>
            </button>
            <button type="button" class="text-gray-600 hover:text-gray-800 transition" 
                    onclick="copyToClipboard('{{ $matching->sidainfo_code }}', '{{ $matching->dhis2_id }}')" title="Copier">
                <i class="fas fa-copy text-lg"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
        <i class="fas fa-database text-4xl mb-3 block"></i>
        Aucune correspondance trouvée
    </td>
</tr>
@endforelse