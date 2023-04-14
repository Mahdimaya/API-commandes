<?php

namespace App\Http\Controllers;

use App\Models\ligne_de_cart;
use App\Models\produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = produit::all();
        return response(["Produits" => $produits], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = $request->validate([
            'id_produit' => ['required','int'],
            'nom' => ['required'],
            'prix' => ['required'],
            'image' => ['required'],
            'description' => ['required'],

        ]);

       $validorder = produit::create($validator);
       return response($validorder);
    }
    public function update(Request $request)
        {

            $validatedcommande = $request->validate([
                'id_produit' => ['required','int'],
                'nom' => ['required'],
                'prix' => ['required'],
                'image' => ['required'],
                'description' => ['required']

            ]);
            $product = produit::find($request->id_product);
            if($product->id != $validatedcommande['id_produit'])
            {
            return response(['message' => 'Impossible de terminer loperation!'],403);
            }
            $product->nom= $request['nom'] ;
            $product->prix= $request['prix'];
            $product->image= $request['image'];
            $product->save();
            $product1 = ligne_de_cart::find($request->id_product);
            $product1->image= $request['image'];
            $product1->save();


            return response( ['produit mise a jour!'], 200);
        }

        public function destroy(Request $request)
    {
        $Deletedproduct = produit::find($request->id_product);
        $Deletedproduct->delete();
            return response('Le SSproduit est supprimé!', 200);
    }
}