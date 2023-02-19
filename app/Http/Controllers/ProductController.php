<?php
  
namespace App\Http\Controllers;
  
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Mail\ProductAdd;
use Datatables;
use Mail;
  
class ProductController extends Controller
{
    /**
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth');
   }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Product::with('user')->select('*'))
            ->addColumn('userName', function($row){
                return '<a class="" href="'.route('user.show',$row->user->id).'">'.$row->user->name.'</a>';
            })
            ->addColumn('action', function($row){
                $btn = '<form action="'.route('product.destroy',$row->id).'" method="POST">';
                $btn = $btn.'<a class="btn btn-info" href="'.route('product.show',$row->id).'">Show</a>';
                $btn = $btn.'<a class="btn btn-primary" href="'.route('product.edit',$row->id).'">Edit</a>';
                $btn = $btn.'<input type="hidden" name="_method" value="DELETE">';
                $btn = $btn.'<input type="hidden" name="_token" value="'.csrf_token().'">';
                $btn = $btn.'<button type="submit" class="btn btn-danger">Delete</button>';
                $btn = $btn.'</form>';
                return $btn;
            })
            ->rawColumns(['action','userName'])
            ->addIndexColumn()
            ->make(true);
            }
        return view('products.index');
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'original_price' => 'required',
            'type' => 'required',
            'user_id' => 'required',
        ]);
        
        $product = Product::create($request->all());
        $data = ['name' => $product->user->name, 'product'=>$product->name, 'type'=>$product->type];
        //The email sending is done using the to method on the Mail facade
        Mail::to($product->user->email)->send(new ProductAdd($data));

        return redirect()->route('product.index')
                        ->with('success','Product created successfully.');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('products.show',compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        
        $product->update($request->all());
        
        return redirect()->route('product.index')
                        ->with('success','Product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
         
        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }
    public function html_email() {
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
           $message->to('abc@gmail.com', 'Tutorials Point')->subject
              ('Laravel HTML Testing Mail');
           $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "HTML Email Sent. Check your inbox.";
     }
}