<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            
            'libelle'=>'required|min:3',
            'reference'=>'required|unique:produits',
            'prix_achat'=>'required|numeric',
            'prix_unitaire'=>'required|numeric',
            'quantite'=>'required|numeric',
            'image'=>'required|image',
            'boutiques'=>'required|string|exists:boutique,localisation',

        ];
    }
}
