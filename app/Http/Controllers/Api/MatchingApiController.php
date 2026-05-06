<?php
// app/Http/Controllers/Api/MatchingApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matching;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchingApiController extends Controller
{
    /**
     * Récupérer le DHIS2 ID à partir du code SIDAInfo
     * Endpoint pour OpenFn
     */
    public function getDhis2Id($sidainfo_code)
    {
        try {
            $matching = Matching::where('sidainfo_code', $sidainfo_code)
                                ->where('is_active', true)
                                ->first();
            
            if (!$matching) {
                return response()->json([
                    'success' => false,
                    'message' => 'Code SIDAInfo non trouvé',
                    'data' => null
                ], Response::HTTP_NOT_FOUND);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Correspondance trouvée',
                'data' => [
                    'sidainfo_code' => $matching->sidainfo_code,
                    'dhis2_id' => $matching->dhis2_id,
                    'nom_formation' => $matching->nom_formation
                ]
            ], Response::HTTP_OK);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Récupérer le code SIDAInfo à partir du DHIS2 ID
     */
    public function getSidainfoCode($dhis2_id)
    {
        try {
            $matching = Matching::where('dhis2_id', $dhis2_id)
                                ->where('is_active', true)
                                ->first();
            
            if (!$matching) {
                return response()->json([
                    'success' => false,
                    'message' => 'DHIS2 ID non trouvé',
                    'data' => null
                ], Response::HTTP_NOT_FOUND);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Correspondance trouvée',
                'data' => [
                    'sidainfo_code' => $matching->sidainfo_code,
                    'dhis2_id' => $matching->dhis2_id,
                    'nom_formation' => $matching->nom_formation
                ]
            ], Response::HTTP_OK);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * Liste toutes les correspondances (avec pagination)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 50);
        
        $matchings = Matching::when($request->get('search'), function($query, $search) {
                                return $query->where('sidainfo_code', 'like', "%{$search}%")
                                             ->orWhere('dhis2_id', 'like', "%{$search}%");
                            })
                            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $matchings
        ], Response::HTTP_OK);
    }
    
    /**
     * Ajouter ou mettre à jour une correspondance
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sidainfo_code' => 'required|string|max:100',
            'dhis2_id' => 'required|string|max:100',
            'nom_formation' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);
        
        $matching = Matching::updateOrCreate(
            ['sidainfo_code' => $validated['sidainfo_code']],
            $validated
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Correspondance enregistrée',
            'data' => $matching
        ], Response::HTTP_CREATED);
    }
    
    /**
     * Mettre à jour une correspondance
     */
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
        
        return response()->json([
            'success' => true,
            'message' => 'Correspondance mise à jour',
            'data' => $matching
        ], Response::HTTP_OK);
    }
    
    /**
     * Supprimer une correspondance
     */
    public function destroy($id)
    {
        $matching = Matching::findOrFail($id);
        $matching->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Correspondance supprimée'
        ], Response::HTTP_OK);
    }
    
    /**
     * Synchronisation massive (pour OpenFn)
     */
    public function sync(Request $request)
    {
        $request->validate([
            'matchings' => 'required|array',
            'matchings.*.sidainfo_code' => 'required|string',
            'matchings.*.dhis2_id' => 'required|string'
        ]);
        
        $synced = [];
        $errors = [];
        
        foreach ($request->matchings as $item) {
            try {
                $matching = Matching::updateOrCreate(
                    ['sidainfo_code' => $item['sidainfo_code']],
                    [
                        'dhis2_id' => $item['dhis2_id'],
                        'nom_formation' => $item['nom_formation'] ?? null,
                        'description' => $item['description'] ?? null,
                        'is_active' => $item['is_active'] ?? true
                    ]
                );
                $synced[] = $matching;
            } catch (\Exception $e) {
                $errors[] = [
                    'sidainfo_code' => $item['sidainfo_code'],
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Synchronisation terminée',
            'synced_count' => count($synced),
            'errors_count' => count($errors),
            'errors' => $errors
        ], Response::HTTP_OK);
    }
}