<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequests;
use App\Models\VehicleMakes;
use App\Models\VehicleModels;

class ServiceRequestsController extends Controller {

  /**
   * [Display a paginated list of Service Requests in the system]
   * @return view
   */
  public function index(){
    $requests = ServiceRequests::where('is_deleted', 0)
                ->orderBy('updated_at','desc')
                ->paginate(20);
    return view('index',compact('requests'));
  }

  /**
   * [Display edit Service request page]
   * @param  $id
   * @return view
   */
  public function edit($id){
    $makes = VehicleMakes::select('id', 'title')->get();
    $data = ServiceRequests::find($id);
    $data->makeId = VehicleModels::select('vehicle_make_id')->findOrFail($data->vehicle_model_id)->vehicle_make_id;
    $models = VehicleModels::select('id', 'title')->where('vehicle_make_id', $data->makeId)->get();
    return view('editTicket', compact('makes', 'models', 'data'));
  }

  /**
   * [delete Service request by id]
   * @param  $id
   * @return redirect
   */
  public function delete($id){
    $serviceRequest = ServiceRequests::findOrFail($id);
    if(isset($serviceRequest)) {
      $serviceRequest->is_deleted = 1;
      $serviceRequest->save();
    }
    return redirect('/');
  }

  /**
   * AJAX call to get
   * @param  int $make_id
   * @return string App\Models\VehicleModels
   */
  public function getModel($make_id) {
    $make = VehicleMakes::find($make_id);
    return json_encode($make->vehicle_models);
  }

  /**
   * This method will show create Ticket screen
   * @param  ServiceRequests $serviceRequest [get the object you are planning on editing]
   * @return view
   */
  public function createTicket(ServiceRequests $serviceRequest) {
    $makes = VehicleMakes::select('id', 'title')->get();
    return view('createTicket', compact('makes'));
  }

  /**
   * [Store the service request]
   * @param  Request $request
   * @return redirect
   */
  public function store(Request $request) {
    if($this->formValidation($request)) {
      if(isset($request->id)) {
        $serviceRequest = ServiceRequests::find($request->id);
      } else {
        $serviceRequest = new ServiceRequests();
      }

      $serviceRequest->client_name = $request->client_name;
      $serviceRequest->client_phone = $request->client_phone;
      $serviceRequest->client_email = $request->client_email;
      $serviceRequest->vehicle_model_id = $request->vehicle_model_id;
      $serviceRequest->status = 'new';
      $serviceRequest->description = $request->description;
      $serviceRequest->save();
    }
    return redirect('/');
  }

  /**
   * [validate the submitted service request form ]
   * @return boolean
   */
  private function formValidation(Request $request) {
    return $request->validate([
      'client_name' => 'required',
      'client_phone' => 'required|numeric',
      'client_email' => 'required|email',
      'vehicle_model_id' => 'required',
      'description' => 'required',
    ]);
  }
}
