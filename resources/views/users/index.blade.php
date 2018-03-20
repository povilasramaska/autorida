@extends('layouts/app')

@section('content')
<div class="container">

<h1>Users ({{count($users)}})</h1>


    <div class="row justify-content-md-between">

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip code</th>
                    <th>Country</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}} {{$user->surname}}</td>
                        <td>{{$user->birthday}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->city}}</td>
                        <td>{{$user->zipcode}}</td>
                        <td>{{$user->country}}</td>
                        <td>
                            <div class="row">

                            <div class="col-md-6">
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary ">Delete</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary ">Edit</a>
                            </div>
                            </div>
                        </td>
                    </tr>


                    @endforeach
                </tbody>
        </table>
        @if (count($users) == 0)
            <h2>No users found...</h2>
        @endif


    </div>
</div>
@endsection
