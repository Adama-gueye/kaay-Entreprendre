<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use OpenApi\Annotations as OA;
use ReturnJsonResponseTrait;

/**
 * @OA\Info(
 *     description="EndPoints pour utilisateur",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Retourne liste des utilisateurs",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function listeUtilisteurs() {
        $users = User::all();
        return response()->json(compact('users'),200);

    }

    /**
     * 
     * @OA\Post(
     *     path="/api/login",
     *     summary="Connexion entre l'utilisateur",
     *     @OA\Response(response="201", description="connexion succes"),
     *     @OA\Response(response="401", description="Identifiant incorect")
     * )
     */
     public function loginUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                
                return response()->json(['message' => $validator->errors()],401);
            }
            
            if(Auth::attempt($request->all())){
                
                $user = Auth::user(); 
                $success =  $user->createToken('MyApp')->plainTextToken; 
                
                //dd($success);
                return  response()->json(['message'=>'connexion reussi', 'user' => $user, 'token'=>$success ],200);
            }
        } catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }   
            
            //return $this->returnJsonResponse(200, 'Connexion réussi', $user );
           
        
        // return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return  response()->json(compact('users'),200);
        }

        return  response()->json('Unauthorized',401);
    }

    /**
     * create compte utilisateur
     */

     /**
     * 
     * @OA\Post(
     *     path="/api/register",
     *     summary="Création compte d'un utilisareur",
     *     @OA\Response(response="201", description="compte creer succes"),
     * )
     */
     public function createCompte(Request $request)
    {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'nom' => 'required',
                'prenom' => 'required',

            ]);
       
            if($validator->fails()){
    
                return  response()->json(['message' => $validator->errors()],401);
            }
        $user = new User();
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $filename);
            $user['image']= $filename;
        }
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->save();
        return response()->json($user,201);
        
    }

    /**
     * Display the specified resource.
     */

    /**
     * 
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Déconnexion utilisareur",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        
        return  response()->json(['data' => 'User Logout successfully.'],200);
    }

    public function deleteUser(Request $request): Response
    {
        try {
            $user =  User::findOrFail($request->id);
            $user->delete();
            return response()->json(['user' => 'Utilisateur supprimé'],200);
        } catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }   
        
    }

    public function editUser(Request $request) {
        try {
            $user = User::FindOrFail($request->id);
            return response()->json(compact('user'),200);
        }  catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }  
        
    }

    public function updateUser(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'email',
                'nom' => 'string',
                'prenom' => 'string',

            ]);
       
            if($validator->fails()){
    
                return  response()->json(['message' => $validator->errors()],401);
            }
            $user = User::FindOrFail($request->id);
            $user->update([
                'nom' => $request->nom, 
                'prenom' => $request->prenom,
                'email' => $request->email,
            ]);
            return response()->json('Mise a jour réussi',200);
        }  catch (ModelNotFoundException $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 403);
        }  
        
    }

    
}
