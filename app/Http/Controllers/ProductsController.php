<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //

    public function index()
    {
        return response()->json(['data' => "hello word", 'status' => 200]);
    }
    public function getproducts($id = false)
    {
        $data = Products::all();
        return response()->json(['data' => $data, 'message' => 'data berhasil dikirim', 'status' => Response::HTTP_OK], Response::HTTP_OK);
    }

    public function getproduct($id)
    {
        $data = Products::find($id);
        if (is_null($data)) {
            return response()->json(['data' => $data, 'message' => 'tidak ada data', 'status' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json(['data' => $data, 'message' => 'data berhasil dikirim', 'status' => Response::HTTP_OK], Response::HTTP_OK);
        }
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'desc' => 'required|string',
        //     'price' => 'required|numeric',
        //     'image' => 'required|image|mimes:png,jpg',
        // ]);


        $request->validate([
            'name' => 'required|string',
            'desc' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg',
        ], ['name.required' => 'harus disis']);

        if ($image = $request->file('image')) {
            $target = 'assets/images/';
            $prodimg = date('YmdHiS') . '.' . $image->getClientOriginalExtension();
            $image->move($target, $prodimg);
            $input['image'] = "$prodimg";
        }
        $input = $request->all();
        $data = ['data' => $input, 'message' => 'data berhasil diinsert', 'status' => Response::HTTP_CREATED];
        Products::create($input);
        return response()->json($data, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id)
    {
        $produk = Products::find($id);
        if ($produk) {
            $request->validate([
                'name' => 'string',
                'desc' => 'string',
                'price' => 'numeric',
                'image' => 'image|mimes:png,jpg',
            ], ['name.string' => 'harus disisiiiii']);

            if ($image = $request->file('image')) {
                $target = 'assets/images/';
                // unlink($target, $produk->image);
                $prodimg = date('YmdHiS') . '.' . $image->getClientOriginalExtension();
                $image->move($target, $prodimg);
                $input['image'] = "$prodimg";
            }
            $input = $request->all();
            $produk->update($input);
            $data = ['data' => $produk, 'message' => 'data berhasil diupdate', 'status' => Response::HTTP_OK];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = ['data' => $produk, 'message' => 'data gagal diupdate', 'status' => Response::HTTP_NOT_FOUND];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }

    public function delete(Request $request, $id)
    {
        $produk = Products::find($id);
        if ($produk) {
            $produk->delete();
            $data = ['data' => $produk, 'message' => 'data berhasil dihapus', 'status' => Response::HTTP_OK];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = ['data' => $produk, 'message' => 'data gagal dihapus', 'status' => Response::HTTP_NOT_FOUND];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }
}
