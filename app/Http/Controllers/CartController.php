<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartData()
    {
        try {
            return $this->getCartResponse('Cart data retrieved successfully');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cart data: ' . $e->getMessage()
            ], 500);
        }
    }
    private function getCartResponse($message = 'Operasi berhasil')
    {
        $subtotal = (float) Cart::subtotal(0, '.', '');

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart' => [
                'items' => Cart::content()->map(function ($item) {
                    return [
                        'rowId' => $item->rowId,
                        'id' => $item->id,
                        'name' => htmlspecialchars($item->name),
                        'qty' => (int) $item->qty,
                        'price' => (float) $item->price,
                        'total' => (float) ($item->price * $item->qty),
                        'options' => $item->options->toArray()
                    ];
                })->values(),
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'totalQty' => (int) Cart::count()
            ]
        ]);
    }
    public function index()
    {
        return view('customer.menu', [
            'cartItems' => Cart::content(),
            'cartTotal' => Cart::total(0, '.', ''),
            'cartCount' => Cart::count()
        ]);
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'qty' => 'integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            $qty = (int) ($request->qty ?? 1);

            if (!$product->is_available || !$product->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak tersedia'
                ], 400);
            }

            $existingCartItem = Cart::search(function ($cartItem) use ($product) {
                return $cartItem->id === $product->id;
            });

            if ($existingCartItem->isNotEmpty()) {
                $rowId = $existingCartItem->first()->rowId;
                $newQty = $existingCartItem->first()->qty + $qty;
                Cart::update($rowId, $newQty);
                $message = 'Kuantitas produk berhasil diperbarui!';
            } else {
                Cart::add(
                    $product->id,
                    $product->name,
                    $qty,
                    $product->price,
                    ['image' => $product->image]
                )->associate(Product::class);
                $message = 'Produk berhasil ditambahkan ke keranjang!';
            }

            return $this->getCartResponse($message);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request)
    {
        try {
            $request->validate([
                'rowId' => 'required',
                'qty' => 'required|numeric|min:0'
            ]);

            $qty = (int) $request->qty;

            if (!is_numeric($qty) || is_nan($qty)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuantitas tidak valid'
                ], 400);
            }

            if ($qty === 0) {
                Cart::remove($request->rowId);
                $message = 'Item keranjang berhasil dihapus';
            } else {
                Cart::update($request->rowId, $qty);
                $message = 'Kuantitas berhasil diperbarui';
            }

            return $this->getCartResponse($message);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'rowId' => 'required'
            ]);

            Cart::remove($request->rowId);

            return $this->getCartResponse('Item keranjang berhasil dihapus');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getCartCount()
    {
        return response()->json([
            'success' => true,
            'count' => Cart::count()
        ]);
    }

    public function clear()
    {
        Cart::destroy();
        return response()->json([
            'success' => true,
            'message' => 'Keranjang dikosongkan',
            'cart' => [
                'items' => Cart::content()->map(function ($item) {
                    return [
                        'rowId' => $item->rowId,
                        'id' => $item->id,
                        'name' => htmlspecialchars($item->name),
                        'qty' => (int) $item->qty,
                        'price' => (float) $item->price,
                        'total' => (float) ($item->price * $item->qty),
                        'options' => $item->options->toArray()
                    ];
                })->values(),
                'subtotal' => (float) Cart::subtotal(0, '.', ''),
                'total' => (float) Cart::subtotal(0, '.', ''),
                'totalQty' => (int) Cart::count()
            ]
        ]);
    }
}
