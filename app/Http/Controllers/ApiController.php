<?php

namespace App\Http\Controllers;
use App\items;
use App\meals;
use App\recips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()///to get all items from fridge
    {
        return response()->json(['status'=>'success','data'=>items::all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //to add items in fridge
    {
        $item=new items();
        $item->item_name=$request->item_name;
        $item->item_amount=$request->item_amount;
        $item->item_addDate=date('Y-m-d');
        $item->item_expiryDate=$request->item_expiryDate;
        if($item->save()){
            return response()->json(['status'=>'success','data'=>$item],201);
        }else{
            return response()->json(['status'=>'error'],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)///show item from fridge by id
    {
        $item=items::find($id);
        if(empty($item)){
            return response()->json(['status'=>'error','message'=>'the item is not found'],404);
        }else{
            return response()->json(['status'=>'success','data'=>$item],200);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insert_meals(Request $request) //to insert meals wih its Recips
    {
        $item_ids=items::get('id');
        $meals=new meals();
        $recips=new recips();
        $meals->meals_name=$request->meals_name;
        $mealsaved= $meals->save();
        $mealeid= $meals->id;
        if($item_ids){
            $sizeof=count($request->item_id);
            $itemss=$request->item_id;
            for ($i=0; $i< $sizeof;$i++) {
                $recips->item_id=$itemss[$i];
                $recips->meals_id=$mealeid;
              $recips->save();
            }
        }else{
            return response()->json(['status'=>'error'],500);
        }
        if( $mealsaved){
            return response()->json(['status'=>'success','data'=>$mealsaved],201);
        }else{
            return response()->json(['status'=>'error'],500);
        }
    }

    public function get_meals(Request $request){///to search meal is avalibale or not
        $meals_name=$request->meals_name;
        $meals = DB::table('recips')
        ->join('items', 'items.id', '=','recips.item_id')
        ->join('meals', 'meals.id', '=','recips.meals_id')
        ->where("meals.meals_name",'like','%'.$meals_name.'%')
        ->where("items.item_expiryDate",">",date('Y-m-d'))
        ->select('recips.*','items.*')
       ->get();
        if( count($meals)==0){
            return response()->json(['status'=>'error','message'=>'the meal is not found'],404);
        }else{
            return response()->json(['status'=>'success',$meals_name=>$meals],200);
        }
    }
}
