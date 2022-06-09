<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('resetpassword/{id}', [AuthController::class, 'resetPassword']);

    // Admin Controller
    Route::post('newadmin', [AdminController::class, 'addNewUser']); //*
    Route::get('admins', [AdminController::class, 'showAdmins']); //*
    Route::get('numagents', [AdminController::class, 'agentNumber']); //*
    // Route::post('updateadmin/{id}', [AdminController::class, 'editUser']);
    // Route::post('newagent', [AdminController::class, 'addNewUser']);
    // Route::post('updateagent/{id}', [AdminController::class, 'editUser']);
    // Route::post('changeuserstatus/{id}', [AdminController::class, 'changStatus']);

    // Farmer Controller
    Route::post('newfarmer', [FarmerController::class, 'addNewFarmer']); //*
    Route::post('updatefarmer/{id}', [FarmerController::class, 'editFarmer']); //*
    Route::get('farmers', [FarmerController::class, 'showAllFarmer']); //*
    Route::get('farmer/{id}', [FarmerController::class, 'showFarmer']); //*
    Route::get('numfarmers', [FarmerController::class, 'farmerNumber']); //*
    // Route::get('showfarmers/{id}', [FarmerController::class, 'showFarmers']);
   
    // Plant Controller
    Route::post('newplant/{id}', [PlantController::class, 'addNewPlant']); //*
    Route::get('plantsfarmer/{id}', [PlantController::class, 'showPlantsByFarmer']); //*
    Route::get('latestplant/{id}', [PlantController::class, 'getLatestPlant']); //*
    Route::get('numplants', [PlantController::class, 'countAllFarmerPlant']); //*
    
    // Enterprise Controller
    Route::post('newenterprise', [EnterpriseController::class, 'addNewEnterprise']); //*
    Route::post('updateenterprise/{id}', [EnterpriseController::class, 'editEnterprise']); //*
    Route::get('enterprises', [EnterpriseController::class, 'showAllEnterprises']); //*
    Route::get('enterprises/{id}', [EnterpriseController::class, 'showEnterprise']); //*
    Route::get('numenterprises', [EnterpriseController::class, 'enterpriseNumber']); //*
    // Route::post('addfarmers/{id}', [EnterpriseController::class, 'addFarmerToEnterprise']);
    // Route::post('removefarmers/{id}', [EnterpriseController::class, 'removeFarmerFromEnterprise']);
    
    // Sale Controller
    Route::post('newsale/{id}', [SaleController::class, 'addNewSale']); //*
    Route::get('salesenterprise/{id}', [SaleController::class, 'showSalesByEnterprise']); //*
    // Route::get('sales', [SaleController::class, 'showAllSales']);

    // Order Controller

    // OrderDetail Controller
});
