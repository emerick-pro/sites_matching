<?php
// app/Http/Controllers/MatchingController.php

namespace App\Http\Controllers;

use App\Models\Matching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response; 
use Illuminate\Http\JsonResponse;

class MatchingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $matchings = Matching::query()
            ->when($search, function($query, $search) {
                return $query->where('sidainfo_code', 'like', "%{$search}%")
                            ->orWhere('dhis2_id', 'like', "%{$search}%")
                            ->orWhere('nom_formation', 'like', "%{$search}%");
            })
			->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('matchings.index', compact('matchings', 'search'));
    }
    
    public function create()
    {
        return view('matchings.form');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sidainfo_code' => 'required|string|max:100|unique:matchings',
            'dhis2_id' => 'required|string|max:100',
            'nom_formation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        Matching::create($validated);
        
        return redirect()->route('matchings.index')
                         ->with('success', 'Correspondance ajoutée avec succès');
    }
    
    public function edit($id)
    {
        $matching = Matching::findOrFail($id);
        return view('matchings.form', compact('matching'));
    }
    
    public function update(Request $request, $id)
    {
        $matching = Matching::findOrFail($id);
        
        $validated = $request->validate([
            'sidainfo_code' => 'required|string|max:100|unique:matchings,sidainfo_code,' . $id,
            'dhis2_id' => 'required|string|max:100',
            'nom_formation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        $matching->update($validated);
        
        return redirect()->route('matchings.index')
                         ->with('success', 'Correspondance mise à jour avec succès');
    }
    
	/*
	* Exporte la table en csv
	*/
        
   public function export()
    {
        $matchings = Matching::all();
        
        // Nom du fichier
        $filename = 'matchings_' . date('Y-m-d_H-i-s') . '.csv';
        
        // En-têtes CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Créer le contenu CSV
        $callback = function() use ($matchings) {
            $file = fopen('php://output', 'w');
            
            // Ajouter les en-têtes de colonnes (UTF-8 BOM pour Excel)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, [
                'ID',
                'Code SIDAInfo',
                'DHIS2 ID',
                'Nom formation',
                'Description',
                'Statut',
                'Date création',
                'Date mise à jour'
            ]);
            
            // Ajouter les données
            foreach ($matchings as $matching) {
                fputcsv($file, [
                    $matching->id,
                    $matching->sidainfo_code,
                    $matching->dhis2_id,
                    $matching->nom_formation ?? '',
                    $matching->description ?? '',
                    $matching->is_active ? 'Actif' : 'Inactif',
                    $matching->created_at ? $matching->created_at->format('d/m/Y H:i:s') : '',
                    $matching->updated_at ? $matching->updated_at->format('d/m/Y H:i:s') : ''
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
     /**
     * Supprimer une correspondance (AJAX compatible)
     */
    public function destroy($id)
    {
        try {
            $matching = Matching::findOrFail($id);
            $sidainfoCode = $matching->sidainfo_code;
            $matching->delete();
            
            // Si la requête est AJAX, retourner JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Correspondance pour le code '{$sidainfoCode}' supprimée avec succès"
                ]);
            }
            
            // Sinon, redirection normale
            return redirect()->route('matchings.index')
                             ->with('success', 'Correspondance supprimée avec succès');
                             
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('matchings.index')
                             ->with('error', 'Erreur lors de la suppression');
        }
    }
    
    /**
     * Import AJAX compatible
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);
        
        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        
        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle);
            $headers = array_map('strtolower', $headers);
            
            if (!in_array('sidainfo_code', $headers) || !in_array('dhis2_id', $headers)) {
                fclose($handle);
                $message = 'Le fichier doit contenir les colonnes: sidainfo_code, dhis2_id';
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 422);
                }
                return redirect()->back()->with('error', $message);
            }
            
            $sidainfoCodeIndex = array_search('sidainfo_code', $headers);
            $dhis2IdIndex = array_search('dhis2_id', $headers);
            $nomFormationIndex = array_search('nom_formation', $headers);
            $descriptionIndex = array_search('description', $headers);
            
            DB::beginTransaction();
            
            try {
                while (($row = fgetcsv($handle)) !== false) {
                    $sidainfoCode = trim($row[$sidainfoCodeIndex] ?? '');
                    $dhis2Id = trim($row[$dhis2IdIndex] ?? '');
                    
                    if (empty($sidainfoCode) || empty($dhis2Id)) {
                        $errorCount++;
                        continue;
                    }
                    
                    $data = [
                        'sidainfo_code' => $sidainfoCode,
                        'dhis2_id' => $dhis2Id,
                        'nom_formation' => $nomFormationIndex !== false ? trim($row[$nomFormationIndex] ?? '') : null,
                        'description' => $descriptionIndex !== false ? trim($row[$descriptionIndex] ?? '') : null,
                        'is_active' => true
                    ];
                    
                    Matching::updateOrCreate(
                        ['sidainfo_code' => $data['sidainfo_code']],
                        $data
                    );
                    
                    $successCount++;
                }
                
                DB::commit();
                fclose($handle);
                
                $message = "Import terminé : $successCount correspondances importées.";
                if ($errorCount > 0) {
                    $message .= " $errorCount lignes ignorées.";
                }
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => $message]);
                }
                
                return redirect()->route('matchings.index')->with('success', $message);
                
            } catch (\Exception $e) {
                DB::rollback();
                fclose($handle);
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
                }
                
                return redirect()->back()->with('error', 'Erreur: ' . $e->getMessage());
            }
        }
        
        $message = 'Impossible de lire le fichier';
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $message], 422);
        }
        
        return redirect()->back()->with('error', $message);
    }
}