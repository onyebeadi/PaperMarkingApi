<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/marking_guide','PaperMarkerController@list_marking_guides');
$router->get('/answer_paper','PaperMarkerController@list_answer_papers');
$router->post('/marking_guide/{guide}','PaperMarkerController@store_marking_guide');
$router->post('/answer_paper/{name}/{answer_paper}','PaperMarkerController@store_answer_paper');
$router->get('/authors/{author}','PaperMarkerController@show');
$router->put('/marking_guide/{id}','PaperMarkerController@update');
$router->patch('/marking_guide/{id}','PaperMarkerController@update');
$router->delete('/answer_paper/{id}','PaperMarkerController@delete_answer_paper');
$router->delete('/marking_guide/{id}','PaperMarkerController@delete_marking_guide');