@extends('layouts.app')

@section('content')
    <div class="home-welcome" >
        <div class="container" >
            <h1 >Welcome to DFLIP..</h1 >

            <a type="submit" href ="/login" class="btn btn-primary" >
                <i class="fa fa-plus" ></i >Start Now
            </a >
        </div >
    </div >

    {{--Recent books--}}
    <div class="container">
        <div class="row" >
            <h3 >Recent Books</h3 >

            <div class="book-row" >
                @foreach ($recent_books as $book)
                    <div class="_df_thumb" thumb="thumb/{{$book->pdf_url}}" id="df_{{$book->id}}"
                            source="pdf/{{$book->pdf_url}}" >{{ $book->name }}</div >
                    <p> Created {{$book->publish_age }} ago</p>
                @endforeach
            </div >
        </div >
    </div>

    {{--Recommended reads--}}
    <div class="container">
        <div class="row" >
            <h3 >Recommended Books</h3 >

            <div class="book-row" >
                @foreach ($books as $book)
                    <div class="_df_thumb" thumb="thumb/{{$book->pdf_url}}" id="df_{{$book->id}}"
                         source="pdf/{{$book->pdf_url}}" >{{ $book->name }}</div >
                @endforeach
            </div >
        </div >
    </div>

    {{--Trending books--}}
    <div class="container">
        <div class="row" >
            <h3 >Trending Books</h3 >

            <div class="book-row" >
                @foreach ($trending_books as $book)
                    <div class="_df_thumb" thumb="thumb/{{$book->pdf_url}}" id="df_{{$book->id}}"
                         source="pdf/{{$book->pdf_url}}" >{{ $book->name }}</div >
                @endforeach
            </div >
        </div >
    </div>

@endsection
