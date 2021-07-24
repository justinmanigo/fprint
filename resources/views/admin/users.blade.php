@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-md-10 offset-1">
            <div class="table">
			    <div class="table-wrapper">
                        <div class="table-title mb-3">
                            <div class="row">
                            <div class="col-xs-6 col-md-12">
                                    <h2>Manage <b>Users</b></h2>
                                </div>
                                <!-- <div class="col-xs-7 col-md-12">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">New Order</button>
                                </div> -->
                            </div>
                        </div>
                        <table id="userTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr id="uid{{$user->id}}">
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->type}}</td>
                                    <td>{{$user->contact}}</td>
                                   
                                    <td>  
                                    <!-- <button onclick="getStaffInfo({{$user->id}})" type="button" class="btn btn-success" >view</button> -->
                                    <button onclick="deleteStaff({{$user->id}})" type="button" class="btn btn-danger" >delete</button>
                                    </td>
                               
                                </tr>
                            @endforeach 
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
