<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Property;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function create()
     {
         //
         return view('company.create');
     }


     public function properties($id){

        $properties = Company::find($id)->property;
        // foreach ($properties as $property){

        //     dd($property->room);
        // }

        return response()->json($properties);
     }

    public function index()
    {
        //

        return view('company.index', [
            'companies' => Company::Paginate(5),
            'company' => 'All Companies'
        ]);

        return view('company.index')->with(['companies'=>$companies, 'company' =>'All Companies']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name'=>'required|min:5',
        ]);

        // dd($request->validated());
        $company = Company::create($data);
        return back()->with('message', 'Company added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
        $properties  = Property::where('company_id', $company->id)->paginate(5);
       return view('property.index',
       [
        'properties'=> $properties,
        'company'=> $company->name
       
    ]);

        // return view('property.index')->with(['properties'=>$properties, 'company'=>$company->name]);

    }

    public function edit($id)
    {
        //
        dd($id);
       $properties = $company->property;

        return view('property.index')->with(['properties'=>$properties, 'company'=>$company->name]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
        $company = Company::where('id', $request->id)->first();
        $company->name = $request->newName;
        $company->save();
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        // $company = Company::where('id', $request->id)->first();
        
        // dd($company->property);
        Company::destroy($request->id);
        return response()->json(['success' => true]);
    }
}
