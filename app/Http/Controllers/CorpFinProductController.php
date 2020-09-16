<?php

namespace App\Http\Controllers;


use App\CorpFinProduct;
use App\Country;
use Auth;
use Illuminate\Http\Request;
use Validator;

class CorpFinProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->company;

        // $Products = $company->corpFinProducts;
        $Products = CorpFinProduct::where('company_id', $company->id)->paginate(10);

        return view('CorpFIN.panel.view_product', ['company' => $company, 'corpFinProducts' => $Products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Auth::user()->company;

        $country = $company->country;

        $currency = Country::where('name', $country)->get();

        return view('CorpFIN.panel.Add_product', ['currency' => $currency, 'company' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'measure' => 'required',
                'rp' => 'required',
            ],
            [
                'name.required' => 'Product name is Required',
                'measure.required' => 'measure is required',
                'RP.required' => 'Rate / Price is required',
            ]
        );

        if ($validator->fails()) {
            $messages = response($validator->messages());
            return response(['result' => 'val_fail', 'error' => $messages]);
        } else {

            $input = $request->all();
            $input['rp'] = $request->get('rp');
            $input['company_id'] = Auth::user()->company_id;

            try{
                CorpFinProduct::create($input);
            }
            catch(\Exception $e) {
                return response(['result' => 'fail'], 400);
            }
            return redirect()->route('corpfin.product.view')->withSuccess("Product added Successfully");
            // return response(['result' => 'success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request/*, $id*/)
    {
        //Todo: manage validation
        try{
            $corpProduct = CorpFinProduct::find($request->get('id'));
            $corpProduct->update($request->all());
        }
        catch(\Exception $e) {
            \Session::flash('error','Product update failed');
            return redirect()->back();
        }

        \Session::flash('success','Product update successful');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $Product = CorpFinProduct::find($request->get('id'));
            $Product->delete();
        }
        catch(\Exception $e)
        {
            return response(['result' => 'fail']);
        }

        return response(['result' => 'success']);
    }

    /**
     * get the products from api
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getProducts(Request $request)
    {
        $company = Auth::user()->company;
        $result = $company->corpFinProducts->find($request->get('id'));
        return response($result);

    }
    
    /**
     * filter products from api
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function filterProducts(Request $request)
    {
        $input = $request->all();
        $company = Auth::user()->company;
        $query = CorpFinProduct::where('company_id', $company->id);
        if(!empty($input['taxes']))
        {
            $query->where('taxes', $input['taxes']);
        }
        if(!empty($input['measure']))
        {
            $query->where('measure', $input['measure']);
        }
        if(!empty($input['markup']))
        {
            $query->where('markup', '!=', 0);
        }
        $result = $query->get();
        return response($result);

    }

    /**
     * query product.
     *
     * @return Search result
     */
     public static function query_product($query = null)
    {
        // return $query;
        if ($query != null)
        {
            $company = Auth::user()->company;
            $input = $query;

            $exp = explode(' ', $input);

            $s = '';
            $c = 1;
            foreach ($exp AS $e)
            {
                $s .= "+$e*";

                if ($c + 1 == count($exp))
                    $s .= ' ';

                $c++;
            }

            $query = "MATCH (name) AGAINST ('$s' IN BOOLEAN MODE)";
            // $query looks like 
            // MATCH (first_name, last_name, email) AGAINST ('+jar* +eitni*' IN BOOLEAN MODE)

            return $users = CorpFinProduct::where('company_id', $company->id)->whereRaw($query)->get();
        }
        
    }

    /**
     * filter products from api
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function get_product_by_name(Request $request)
    {
        
        $company = Auth::user()->company;
        $query = CorpFinProduct::where('company_id', $company->id)->where('name', $request->input('name'))->first();
        if(!empty($query)){
            return response(['status'=> 'ok', 'data'=> $query]);
        }
        return response(['status'=> 'error', 'msg'=> 'product with provided name does.nt exist']);
    }
}
