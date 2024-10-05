<?php

namespace App\Http\Controllers;

use App\Mail\{ContactMail, StockMail};
use App\Models\{Banner, Content, Comment, Category, Product, Extrafield, Setting, Propal};
use App\Queries\ProductFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Repositories\FournisseurRepository;

class WelcomeController extends Controller
{

  public function __construct(
    private readonly FournisseurRepository $fournisseurRepository
    )
    {
    }
  /**
   * Display Dashboard.
   * 
   * @return \Illuminate\Http\Response
   */
  public function dashboard()
  {
    if (Auth::user()->society) {
      $orders = Propal::where('fk_soc', Auth::user()->society->rowid)->count();
    } else {
      $orders = 0;
    }

    return view('dashboard')->with('orders', $orders);
  }

  /**
   * Display Welcome.
   * 
   * @return \Illuminate\Http\Response
   */
  public function welcome()
  {
    $tasa_usd = Setting::find(2)->value;
    $banners = Banner::all();
    $about = Content::find(1);

    if (Auth::check() && Auth::user()->society) { $price_level = Auth::user()->society->price_level; } else { $price_level = 1; }

    $brands = DB::connection('mysqlerp')
                ->table('llx_societe')
                ->leftJoin('llx_categorie_fournisseur', 'llx_societe.rowid', '=', 'llx_categorie_fournisseur.fk_soc')
                ->where([
                  ['llx_societe.fournisseur', '=', '1'],
                  ['llx_categorie_fournisseur.fk_categorie', '=', '717'],
                ])
                ->take(10)
                ->get();

              $products = Product::query()->with([
                  'prices' => function ($query) use ($price_level) {
                    $query->where('price_level', '=', $price_level)
                          ->orWhere('price_level', '=', 1)
                          ->orderBy('date_price', 'desc');
                  }
                ])
                ->where('tosell', '=', '1')
                ->whereHas('prices', function ($query) use ($price_level) {
                  $query->where('price_level', '=', $price_level)
                        ->orWhere('price_level', '=', 1);
                })
                ->whereHas('categories', function ($query) {
                  $query->where('fk_categorie', '=', '807');
                })
                ->orderBy('rowid', 'ASC')
                ->take(10)
                ->get();

    return view('welcome')->with('banners', $banners)
                          ->with('about', $about)
                          ->with('brands', $brands)
                          ->with('products', $products)
                          ->with('tasa_usd', $tasa_usd)
                          ->with('price_level', $price_level);
  }

  /**
   * Display About.
   * 
   * @return \Illuminate\Http\Response
   */
  public function about()
  {
    $about = Content::find(2);

    return view('web.about')->with('about', $about);
  }

  /**
   * Display Solutions.
   * 
   * @return \Illuminate\Http\Response
   */
  public function solutions()
  {
    $solutions = Content::find(4);

    $category = Category::findOrFail(905);

    return view('web.solutions')->with('solutions', $solutions)->with('category', $category);
  }

  /**
   * Display Conditions.
   * 
   * @return \Illuminate\Http\Response
   */
  public function conditions()
  {
    $conditions = Content::find(5);

    return view('web.conditions')->with('conditions', $conditions);
  }

  /**
   * Display Policy.
   * 
   * @return \Illuminate\Http\Response
   */
  public function policy()
  {
    $policy = Content::find(6);

    return view('web.policy')->with('policy', $policy);
  }

  /**
   * Display Products.
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function products(Request $request)
  {
    $tasa_usd = Setting::find(2)->value;
    $category_id = $request->input('category', '715');
    $category = Category::findOrFail($category_id);
    $sector_id = '';
    $filters = $request->except(['category', 'sector', 'search', '_token', 'page']);

    $stockInTransit= $this->fournisseurRepository->getStockInTransit();



    $isLogged = false;

    if (Auth::check() && Auth::user()->society) { 
      $price_level = Auth::user()->society->price_level;
      $isLogged = true;

    } else {
       $price_level = 1;
    }

    $products = Product::query()->with([
                          'prices' => function ($query) use ($price_level) {
                            $query->where('price_level', '=', $price_level)
                                  ->orWhere('price_level', '=', 1)
                                  ->orderBy('date_price', 'desc');
                          },
                          'extrafields'
                        ])
                        ->where('tosell', '=', '1')
                        ->whereHas('prices', function ($query) use ($price_level) {
                          $query->where('price_level', '=', $price_level)
                                ->orWhere('price_level', '=', 1);
                        });

                        

    if ($category_id != '715') {
      $products = $products->whereHas('categories', function ($query) use ($category_id) {
                              $query->where('fk_categorie', '=', $category_id);
                            });
    }

    if ($request->has('sector') && ($request->input('sector') != '')) {
      $sector_id = $request->input('sector');
      $products = $products->whereHas('categories', function ($query) use ($sector_id) {
                              $query->where('fk_categorie', '=', $sector_id);
                            });
    }

    $productsMatriz = $products;
    $productsMatriz = $productsMatriz->get();

    if ($request->has('search')) {
      $search = $request->input('search');
      $products = $products->where(function ($query) use ($search) {
        $query->where('ref', 'like', "%{$search}%")
              ->orWhere('label', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
      });
    }

    if (count($filters) > 0) {
      foreach ($filters as $filter => $value) {
        $products = $products->whereHas('extrafields', function ($query) use ($filter, $value) {
          $query->whereIn($filter, $value);
        });
      }
    }

    $products = $products->orderBy('rowid', 'ASC')->paginate(20);

    $products->appends(request()->query());

    $extrafields = Extrafield::where('elementtype', '=', 'product')->get();
    $attributes = [];
    $matriz = [];

    if ($category->attributes) {
      $attributes = $category->attributes->toArray();

      if ($productsMatriz->isNotEmpty()) {
        foreach ($productsMatriz as $product) {
          if ($product->extrafields) {
            $matriz[$product->rowid] = $product->extrafields->toArray();
          }
        }
      }

      $matriz = collect($matriz);
    }

    return view('web.products')->with('category', $category)
                               ->with('products', $products)
                               ->with('filters', $filters)
                               ->with('tasa_usd', $tasa_usd)
                               ->with('price_level', $price_level)
                               ->with('extrafields', $extrafields)
                               ->with('attributes', $attributes)
                               ->with('matriz', $matriz)
                               ->with('isLogged', $isLogged)
                               ->with('stockInTransit', $stockInTransit);
  }



  /**
   * Display Products by category
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function category(Request $request, $id)
  {
    $tasa_usd = Setting::find(2)->value;
    $category_id = $id;
    $category = Category::findOrFail($category_id);
    $sector_id = '';
    $filters = $request->except(['category', 'sector', 'search', '_token', 'page']);

    $stockInTransit= $this->fournisseurRepository->getStockInTransit();

    $isLogged = false;

    if (Auth::check() && Auth::user()->society) { 
      $price_level = Auth::user()->society->price_level;
      $isLogged = true;

    } else {
       $price_level = 1;
    }

    $products = Product::query()->with([
                          'prices' => function ($query) use ($price_level) {
                            $query->where('price_level', '=', $price_level)
                                  ->orWhere('price_level', '=', 1)
                                  ->orderBy('date_price', 'desc');
                          },
                          'extrafields'
                        ])
                        ->where('tosell', '=', '1')
                        ->whereHas('prices', function ($query) use ($price_level) {
                          $query->where('price_level', '=', $price_level)
                                ->orWhere('price_level', '=', 1);
                        });

                        

    if ($category_id != '715') {
      $products = $products->whereHas('categories', function ($query) use ($category_id) {
          $query->where('fk_categorie', '=', $category_id);
        });
    }

    if ($request->has('sector') && ($request->input('sector') != '')) {
      $sector_id = $request->input('sector');
      $products = $products->whereHas('categories', function ($query) use ($sector_id) {
                              $query->where('fk_categorie', '=', $sector_id);
                            });
    }

    $productsMatriz = $products;
    $productsMatriz = $productsMatriz->get();

    if ($request->has('search')) {
      $search = $request->input('search');
      $products = $products->where(function ($query) use ($search) {
        $query->where('ref', 'like', "%{$search}%")
              ->orWhere('label', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
      });
    }

    if (count($filters) > 0) {
      foreach ($filters as $filter => $value) {
        $products = $products->whereHas('extrafields', function ($query) use ($filter, $value) {
          $query->whereIn($filter, $value);
        });
      }
    }

    $products = $products->orderBy('rowid', 'ASC')->paginate(20);

    $products->appends(request()->query());

    $extrafields = Extrafield::where('elementtype', '=', 'product')->get();
    $attributes = [];
    $matriz = [];

    if ($category->attributes) {
      $attributes = $category->attributes->toArray();

      if ($productsMatriz->isNotEmpty()) {
        foreach ($productsMatriz as $product) {
          if ($product->extrafields) {
            $matriz[$product->rowid] = $product->extrafields->toArray();
          }
        }
      }

      $matriz = collect($matriz);
    }

    return view('web.products')->with('category', $category)
                               ->with('products', $products)
                               ->with('filters', $filters)
                               ->with('tasa_usd', $tasa_usd)
                               ->with('price_level', $price_level)
                               ->with('extrafields', $extrafields)
                               ->with('attributes', $attributes)
                               ->with('matriz', $matriz)
                               ->with('isLogged', $isLogged)
                               ->with('stockInTransit', $stockInTransit);
  }

  /**
   * Display Product.
   * 
   * @param  string  $ref
   * @return \Illuminate\Http\Response
   */
  public function product(string $ref)
  {
    $tasa_usd = Setting::find(2)->value;

    if (Auth::check() && Auth::user()->society) { $price_level = Auth::user()->society->price_level; } else { $price_level = 1; }

    $product = Product::with([
                        'prices' => function ($query) use ($price_level) {
                          $query->where('price_level', '=', $price_level)
                                ->orWhere('price_level', '=', 1)
                                ->orderBy('date_price', 'desc');
                        }
                      ])
                      ->whereHas('prices', function ($query) use ($price_level) {
                        $query->where('price_level', '=', $price_level)
                              ->orWhere('price_level', '=', 1);
                      })
                      ->where('ref', '=', $ref)
                      ->first();

    if (app()->environment('production')) {
      $image = null;
      $datasheet = null;
      if ($product->documents->isNotEmpty()) {
        $documents = $product->documents->sortBy('position');
        $total = count($product->documents);
        $i = 0;
        while ((!$datasheet || !$image) && ($i < $total)) {
          if (!$datasheet && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'pdf')) {
            $datasheet = '/storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
          }
          if (!$image && (pathinfo($documents[$i]->filename, PATHINFO_EXTENSION) == 'jpg')) {
            $image = 'storage/produit/'.$product->ref.'/'.$documents[$i]->filename;
          }
          $i++;
        }
      }

      if (!$image) { $image = 'img/logos/CD-SOLEC-ICON.jpg'; }
    } else {
      $image = 'img/logos/CD-SOLEC-ICON.jpg';
      $datasheet = null;
    }

    $extrafields = Extrafield::where('elementtype', '=', 'product')->get();

    $product_fields = $product->extrafields->toArray();

    $attributes = [];
    if ($product->categories->isNotEmpty()) {
      $elements = [];
      foreach ($product->categories as $category) {
        $current = $category;
        $depth = 1;
        while (isset($current->fk_parent) && ($current->fk_parent != "715")) {
          $current = $current->parent;
          $depth++;
        }

        $elements[$category->rowid] = $depth;
      }

      if (count($elements) > 0) {
        $max = array_search(max($elements), $elements);

        $subcategory = Category::find($max);

        $attributes = optional($subcategory->attributes)->toArray();
      }
    }

    return view('web.product')->with('product', $product)
                              ->with('image', $image)
                              ->with('datasheet', $datasheet)
                              ->with('tasa_usd', $tasa_usd)
                              ->with('price_level', $price_level)
                              ->with('extrafields', $extrafields)
                              ->with('product_fields', $product_fields)
                              ->with('attributes', $attributes);
  }

  /**
   * Form Stock Product.
   * 
   * @param  string  $ref
   * @return \Illuminate\Http\Response
   */
  public function stock(string $ref)
  {
    $product = Product::where('ref', '=', $ref)->first();

    return view('web.stock')->with('product', $product);
  }

  /**
   * Mail Stock Product.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $ref
   * @return \Illuminate\Http\Response
   */
  public function stock_mail(Request $request, string $ref)
  {
    $request->validate([
      'name' => ['required', 'string', 'min:3', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'phone' => ['required', 'regex:/^\(\d{3}\)-\d{3}-\d{4}$/i'],
      'message' => ['required', 'string', 'min:3', 'max:4294967200'],
    ], [
      'name.required' => 'Nombre es requerido',
      'name.min' => 'El Nombre debe tener al menos 3 caracteres',
      'name.max' => 'El Nombre debe tener maximo 255 caracteres',
      'email.required' => 'Email es requerido',
      'email.email' => 'Email inválido',
      'email.max' => 'El Email debe tener maximo 255 caracteres',
      'phone.required' => 'Teléfono es requerido',
      'phone.regex' => 'Teléfono es inválido. Ejem.:(243)-234-5678',
      'message.required' => 'Mensaje es requerido',
      'message.min' => 'El Mensaje debe tener al menos 3 caracteres',
      'message.max' => 'El Mensaje debe tener maximo 4294967200 caracteres',
    ]);

    $product = Product::where('ref', '=', $ref)->first();

    $mail = new StockMail($request->name, $request->email, $request->phone, $request->message, $product->label, $product->ref);
      
    Mail::to('ventas@cd-solec.com', 'Consulta de Stock CD-SOLEC')->send($mail);

    return redirect()->back()->with("message", "¡Gracias por su solicitud!, pronto será contactado");
  }

  /**
   * Display Brands.
   * 
   * @return \Illuminate\Http\Response
   */
  public function brands()
  {
    $brands = DB::connection('mysqlerp')
                ->table('llx_societe')
                ->leftJoin('llx_categorie_fournisseur', 'llx_societe.rowid', '=', 'llx_categorie_fournisseur.fk_soc')
                ->where([
                  ['llx_societe.fournisseur', '=', '1'],
                  ['llx_categorie_fournisseur.fk_categorie', '=', '717'],
                ])
                ->get();

    return view('web.brands')->with('brands', $brands);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function comments_create()
  {
    $contact = Content::find(3);

    return view('web.contact')->with('contact', $contact);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function comments_store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'min:3', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'phone' => ['required', 'regex:/^\(\d{3}\)-\d{3}-\d{4}$/i'],
      'message' => ['required', 'string', 'min:3', 'max:4294967200'],
    ], [
      'name.required' => 'Nombre es requerido',
      'name.min' => 'El Nombre debe tener al menos 3 caracteres',
      'name.max' => 'El Nombre debe tener maximo 255 caracteres',
      'email.required' => 'Email es requerido',
      'email.email' => 'Email inválido',
      'email.max' => 'El Email debe tener maximo 255 caracteres',
      'phone.required' => 'Teléfono es requerido',
      'phone.regex' => 'Teléfono es inválido. Ejem.:(243)-234-5678',
      'message.required' => 'Mensaje es requerido',
      'message.min' => 'El Mensaje debe tener al menos 3 caracteres',
      'message.max' => 'El Mensaje debe tener maximo 4294967200 caracteres',
    ]);

    $comment = Comment::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'message' => $request->message
    ]);
      
    Mail::to('ventas@cd-solec.com', 'Contacto CD-SOLEC')->send(new ContactMail($comment));

    return redirect()->back()->with("message", "Mensaje enviado Existosamente, ¡Gracias por su contacto!");
  }
}
