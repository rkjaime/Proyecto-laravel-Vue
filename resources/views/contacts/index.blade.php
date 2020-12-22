@extends('welcome')

@extends('navbar')

@section('main')

    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <h1 >Usuarios</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td colspan = 2>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{$contact->id}}</td>
                    <td>{{$contact->name}}</td>
                    <td>{{$contact->email}}</td>
                    <td>
                        <a href="{{ route('contact.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('contact.destroy', $contact->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <div>
</div>

@endsection
