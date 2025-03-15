<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Listar produtos (para usuários logados).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Auth::user()->products;
        return response()->json($products);
    }

    /**
     * Listar produtos públicos (para visitantes).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPublic(Request $request)
    {
        $query = Product::query();

        // Filtros
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('sale_price', [$request->min_price, $request->max_price]);
        }

        $products = $query->get();
        return response()->json($products);
    }

    /**
     * Cadastrar um novo produto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'category' => 'required|string',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'category' => $request->category,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'created_by' => auth()->id(),
        ]);

        return response()->json($product, 201);
    }

    /**
     * Exibir detalhes de um produto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Auth::user()->products()->find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        return response()->json($product);
    }

    /**
     * Atualizar um produto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Auth::user()->products()->find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'category' => 'sometimes|string',
            'purchase_price' => 'sometimes|numeric',
            'sale_price' => 'sometimes|numeric',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    /**
     * Excluir um produto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Auth::user()->products()->find($id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produto excluído com sucesso']);
    }
}
