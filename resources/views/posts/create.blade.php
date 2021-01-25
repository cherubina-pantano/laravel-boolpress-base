@extends('layouts.main')

@section('content')

    <div class="container mb-5">

        <h1>Create a New Post</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            
            </div>
        @endif


        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title')}}" placeholder="Inserisci il titolo">            
            </div>

            <div class="form-group">
                <label for="body">Description</label>
                <textarea type="text" class="form-control" name="body" id="body">  {{ old('body')}} </textarea>          
            </div>

            <div class="form-group">
                <label for="path_img">Post image</label>
                <input class="form-control" type="file" name="path_img" id="path_img" accept="image/*">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary"  value="Create post">            
            </div>
        
        
        </form>

       




    
    </div>
@endsection